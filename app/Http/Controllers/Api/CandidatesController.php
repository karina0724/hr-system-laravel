<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCandidatesRequest;
use App\Http\Requests\UpdateCandidatesRequest;
use App\Models\Candidates;
use Illuminate\Support\Facades\Gate;

class CandidatesController extends Controller
{
    private function validateCedula(string $cedula): bool
    {
        $total = 0;
        // Eliminar los guiones de la cédula
        $cleanedCedula = str_replace("-", "", $cedula);
        $length = strlen($cleanedCedula);
        $multipliers = [1, 2, 1, 2, 1, 2, 1, 2, 1, 2, 1];

        // La cédula debe tener exactamente 11 dígitos
        if ($length !== 11) {
            return false;
        }

        // Proceso de validación
        for ($i = 0; $i < $length; $i++) {
            $digit = intval($cleanedCedula[$i]);
            $calc = $digit * $multipliers[$i];

            // Si el cálculo es mayor que 9, sumar los dígitos
            if ($calc < 10) {
                $total += $calc;
            } else {
                $total += intval($calc / 10) + ($calc % 10);
            }
        }

        // Si el total es múltiplo de 10, la cédula es válida
        return $total % 10 === 0;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Candidates::class);

        // Obtener candidatos con la relación de posiciones
        $candidates = Candidates::with('position')->get();
        if ($candidates->isEmpty()) {
            return ResponseHelper::success(data: $candidates, message: 'No hay candidatos registrados.');
        }

        return ResponseHelper::success(data: $candidates, message: 'Candidatos recuperados correctamente.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCandidatesRequest $request)
    {
        Gate::authorize('create', Candidates::class);

        // Validar cédula si el tipo de documento es 'personal-id'
        if ($request->id_type === 'personal-id' && !self::validateCedula($request->id_number)) {
            return ResponseHelper::error(message: 'El número de cédula no es válido.', statusCode: 422);
        }

        // Crear un nuevo candidato
        $candidate = Candidates::create($request->validated());

        if (!$candidate) {
            return ResponseHelper::error(message: 'El candidato no se pudo crear. Intente nuevamente.', statusCode: 500);
        }

        return ResponseHelper::success(data: $candidate, message: 'Candidato creado correctamente.', statusCode: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Buscar el candidato por ID
        $candidate = Candidates::with('position')->find($id);
        if (!$candidate) {
            return ResponseHelper::error(message: 'El candidato no existe.', statusCode: 404);
        }

        Gate::authorize('view', $candidate);

        return ResponseHelper::success(data: $candidate, message: 'Candidato recuperado correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCandidatesRequest $request, Candidates $candidate)
    {
        Gate::authorize('update', $candidate);

        // Validar cédula si el tipo de documento es 'personal-id'
        if ($request->id_type === 'personal-id' && !self::validateCedula($request->id_number)) {
            return ResponseHelper::error(message: 'El número de cédula no es válido.', statusCode: 422);
        }

        $updated = $candidate->update($request->validated());

        if (!$updated) {
            return ResponseHelper::error(message: 'El candidato no se pudo actualizar. Intente nuevamente.', statusCode: 500);
        }

        return ResponseHelper::success(data: $candidate, message: 'Candidato actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidates $candidate)
    {
        Gate::authorize('delete', $candidate);

        $deleted = $candidate->delete();

        if (!$deleted) {
            return ResponseHelper::error(message: 'El candidato no se pudo eliminar. Intente nuevamente.', statusCode: 500);
        }

        return ResponseHelper::success(message: 'Candidato eliminado correctamente.');
    }
}

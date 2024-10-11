<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionsRequest;
use App\Http\Requests\UpdatePositionsRequest;
use App\Models\Positions;
use Illuminate\Support\Facades\Gate;

class PositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Positions::class);

        $positions = Positions::all();
        if ($positions->isEmpty()) {
            return ResponseHelper::success(data: $positions, message: 'No hay posiciones registradas.');
        }

        return ResponseHelper::success(data: $positions, message: 'Posiciones recuperadas correctamente.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionsRequest $request)
    {
        Gate::authorize('create', Positions::class);

        if($request->min_salary > $request->max_salary) {
            return ResponseHelper::error(message: 'El salario mínimo no puede ser mayor al salario máximo.');
        }

        if($request->min_salary == $request->max_salary) {
            return ResponseHelper::error(message: 'El salario mínimo no puede ser igual al salario máximo.');
        }

        $position = Positions::create($request->validated());

        if (!$position) {
            return ResponseHelper::error(message: 'La posición no se pudo crear. Intente nuevamente.', statusCode: 500);
        }

        return ResponseHelper::success(data: $position, message: 'Posición creada correctamente.', statusCode: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Buscar la posición o lanzar una excepción si no se encuentra
        $position = Positions::find($id);
        if (!$position) {
            return ResponseHelper::error(message: 'La posición no existe.', statusCode: 404);
        }

        Gate::authorize('view', $position);

        return ResponseHelper::success(data: $position, message: 'Posición recuperada correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositionsRequest $request, Positions $position)
    {
        Gate::authorize('update', $position);

        $updated = $position->update($request->validated());

        if (!$updated) {
            return ResponseHelper::error(message: 'La posición no se pudo actualizar. Intente nuevamente.', statusCode: 500);
        }

        return ResponseHelper::success(data: $position, message: 'Posición actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Positions $position)
    {
        Gate::authorize('delete', $position);

        $deleted = $position->delete();

        if (!$deleted) {
            return ResponseHelper::error(message: 'La posición no se pudo eliminar. Intente nuevamente.', statusCode: 500);
        }

        return ResponseHelper::success(message: 'Posición eliminada correctamente.');
    }
}

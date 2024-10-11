<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompetenciesRequest;
use App\Http\Requests\UpdateCompetenciesRequest;
use App\Models\Competencies;
use Illuminate\Support\Facades\Gate;

class CompetenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Authorize that only recruiters can access this endpoint
        Gate::authorize('viewAny', Competencies::class);

        // Return all competencies
        $competencies = Competencies::all();
        if ($competencies->isEmpty()) {
            return ResponseHelper::success(data: $competencies, message: 'No hay competencias registradas.');
        }

        return ResponseHelper::success(data: $competencies, message: 'Competencias recuperadas correctamente.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompetenciesRequest $request)
    {
        // Authorize that only recruiters can create competencies
        Gate::authorize('create', Competencies::class);

        // Create a new Competencies
        $competency = Competencies::create($request->validated());

        // Check if the competency was created successfully
        if (!$competency) {
            return ResponseHelper::error(message: 'La competencia no se pudo crear. Intente nuevamente.', statusCode: 500);
        }

        // Return response with the newly created Competencies
        return ResponseHelper::success(data: $competency, message: 'Competencia creada correctamente.', statusCode: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Competencies $competencies)
    {
        // Authorize that only recruiters can view this specific Competencies
        Gate::authorize('view', $competencies);

        // Return the requested Competencies
        return ResponseHelper::success(data: $competencies, message: 'Competencia recuperada correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompetenciesRequest $request, Competencies $competencies, int $id)
    {
        // Authorize that only recruiters can update competencies
        Gate::authorize('update', $competencies);

        $competency = Competencies::find($id);

        // Update the Competencies
        foreach (request()->all() as $key => $value) {
            if ($request->has($key)) {
                $competency->$key = $value;
            }
        }
        $updated = $competency->save(request()->all());

        // Check if the update was successful
        if (!$updated) {
            return ResponseHelper::error(message: 'La competencia no se pudo actualizar. Intente nuevamente.', statusCode: 500);
        }

        // Return the updated Competencies
        return ResponseHelper::success(data: $competency, message: 'Competencia actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Competencies $competencies, int $id)
    {
        // Authorize that only recruiters can delete competencies
        Gate::authorize('delete', $competencies);

        $competency = Competencies::find($id);

        // Delete the Competencies
        $deleted = $competency->delete();

        // Check if the deletion was successful
        if (!$deleted) {
            return ResponseHelper::error(message: 'La competencia no se pudo eliminar. Intente nuevamente.', statusCode: 500);
        }

        // Return response indicating successful deletion
        return ResponseHelper::success(message: 'Competencia eliminada correctamente.', statusCode: 200);
    }
}

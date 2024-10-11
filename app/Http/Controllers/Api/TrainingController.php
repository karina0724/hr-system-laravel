<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Models\Training;
use Illuminate\Support\Facades\Gate;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Training::class);

        $trainings = Training::all();
        if ($trainings->isEmpty()) {
            return ResponseHelper::success(data: $trainings, message: 'No hay entrenamientos registrados.');
        }

        return ResponseHelper::success(data: $trainings, message: 'Entrenamientos recuperados correctamente.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainingRequest $request)
    {
        Gate::authorize('create', Training::class);

        $training = Training::create($request->validated());

        if (!$training) {
            return ResponseHelper::error(message: 'El entrenamiento no se pudo crear. Intente nuevamente.', statusCode: 500);
        }

        return ResponseHelper::success(data: $training, message: 'Entrenamiento creado correctamente.', statusCode: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Training $training)
    {
        Gate::authorize('view', $training);

        return ResponseHelper::success(data: $training, message: 'Entrenamiento recuperado correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingRequest $request, Training $training)
    {
        Gate::authorize('update', $training);

        $updated = $training->update($request->validated());

        if (!$updated) {
            return ResponseHelper::error(message: 'El entrenamiento no se pudo actualizar. Intente nuevamente.', statusCode: 500);
        }

        return ResponseHelper::success(data: $training, message: 'Entrenamiento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Training $training)
    {
        Gate::authorize('delete', $training);

        $deleted = $training->delete();

        if (!$deleted) {
            return ResponseHelper::error(message: 'El entrenamiento no se pudo eliminar. Intente nuevamente.', statusCode: 500);
        }

        return ResponseHelper::success(message: 'Entrenamiento eliminado correctamente.');
    }
}

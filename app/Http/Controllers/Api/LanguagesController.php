<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLanguagesRequest;
use App\Http\Requests\UpdateLanguagesRequest;
use App\Models\Languages;
use Illuminate\Support\Facades\Gate;

class LanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Languages::class);

        $languages = Languages::all();
        if ($languages->isEmpty()) {
            return ResponseHelper::success(data: $languages, message: 'No hay idiomas registrados.');
        }

        return ResponseHelper::success(data: $languages, message: 'Idiomas recuperados correctamente.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLanguagesRequest $request)
    {
        Gate::authorize('create', Languages::class);

        $language = Languages::create($request->validated());

        if (!$language) {
            return ResponseHelper::error(message: 'El idioma no se pudo crear. Intente nuevamente.', statusCode: 500);
        }

        return ResponseHelper::success(data: $language, message: 'Idioma creado correctamente.', statusCode: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Languages $language)
    {
        Gate::authorize('view', $language);

        return ResponseHelper::success(data: $language, message: 'Idioma recuperado correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLanguagesRequest $request, Languages $language)
    {
        // Autorizar que solo los reclutadores pueden actualizar idiomas
        Gate::authorize('update', $language);

        // Actualizar el idioma con los datos validados de la solicitud
        $updated = $language->update($request->validated());

        // Verificar si la actualización fue exitosa
        if (!$updated) {
            return ResponseHelper::error(message: 'El idioma no se pudo actualizar. Intente nuevamente.', statusCode: 500);
        }

        // Retornar la respuesta con el idioma actualizado
        return ResponseHelper::success(data: $language, message: 'Idioma actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Languages $language)
    {
        // Autorizar que solo los reclutadores pueden eliminar idiomas
        Gate::authorize('delete', $language);

        // Intentar eliminar el idioma
        $deleted = $language->delete();

        // Verificar si la eliminación fue exitosa
        if (!$deleted) {
            return ResponseHelper::error(message: 'El idioma no se pudo eliminar. Intente nuevamente.', statusCode: 500);
        }

        // Retornar la respuesta indicando que el idioma fue eliminado correctamente
        return ResponseHelper::success(message: 'Idioma eliminado correctamente.', statusCode: 200);
    }
}

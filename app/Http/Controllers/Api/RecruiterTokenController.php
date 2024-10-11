<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecruiterToken;

class RecruiterTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retorna todos los tokens reclutadores
        return RecruiterToken::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validatedData = $request->validate([
            'token' => 'required|string|max:255',
            'email' => 'required|email|max:100',
            'is_used' => 'required|boolean',
            'created_at' => 'nullable|date',
            'used_at' => 'nullable|date',
        ]);

        // Crear un nuevo RecruiterToken
        $recruiterToken = RecruiterToken::create($validatedData);

        return response()->json([
            'message' => 'Recruiter token created successfully',
            'data' => $recruiterToken
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Encontrar un RecruiterToken por su ID
        $recruiterToken = RecruiterToken::find($id);

        if (!$recruiterToken) {
            return response()->json(['message' => 'Token not found'], 404);
        }

        return response()->json($recruiterToken);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Encontrar el RecruiterToken por su ID
        $recruiterToken = RecruiterToken::find($id);

        if (!$recruiterToken) {
            return response()->json(['message' => 'Token not found'], 404);
        }

        // Validación de datos
        $validatedData = $request->validate([
            'token' => 'string|max:255',
            'email' => 'email|max:100',
            'is_used' => 'boolean',
            'created_at' => 'nullable|date',
            'used_at' => 'nullable|date',
        ]);

        // Actualizar el RecruiterToken con los datos validados
        $recruiterToken->update($validatedData);

        return response()->json([
            'message' => 'Recruiter token updated successfully',
            'data' => $recruiterToken
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Encontrar y eliminar un RecruiterToken por su ID
        $recruiterToken = RecruiterToken::find($id);

        if (!$recruiterToken) {
            return response()->json(['message' => 'Token not found'], 404);
        }

        $recruiterToken->delete();

        return response()->json(['message' => 'Recruiter token deleted successfully'], 200);
    }
}

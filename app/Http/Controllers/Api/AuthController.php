<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginGoogleRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\RecruiterToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register new user.
     * @param RegisterRequest $request
     * @return response
     */
    public function register(RegisterRequest $request)
    {
        // Check if the user already exists by email (for Google login)
        $existingUser = User::where('email', $request->email)->first();

        // If the user exists and the auth_type is 'google', just log in and return the token
        if ($existingUser && $request->auth_type === 'google') {
            return $this->loginGoogle(new LoginGoogleRequest([
                'email' => $request->email,
                'google_id' => $request->google_id
            ]));
        }

        // If the role is 'recruiter', validate the token and the email
        if ($request->role === 'recruiter') {
            $tokenRecord = RecruiterToken::where('email', $request->email)
                ->where('token', $request->verificationToken)
                ->where('is_used', 0) // Ensure the token is not used
                ->first();

            // Check if the token is valid
            if (!$tokenRecord) {
                return ResponseHelper::error('error', 'Token de verificación inválido.', 400);
            }

            // Attempt to mark the token as used before creating the user
            $tokenRecord->is_used = 1;
            $tokenRecord->used_at = now();

            // If the token cannot be marked as used, abort the process
            if (!$tokenRecord->save()) {
                return ResponseHelper::error('error', 'Failed to update the verification token.', 500);
            }
        }

        // Now proceed with creating the user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'auth_type' => $request->auth_type,
            'google_id' => $request->google_id,
            'profile_picture' => $request->profile_picture,
            'email_verified' => $request->email_verified,
            'status' => $request->status ?? 'active'
        ]);

        if (!$user) {
            return ResponseHelper::error('error', 'User could not be created. Please try again.', 400);
        }

        if($request->auth_type === 'google'){
            return $this->loginGoogle(new LoginGoogleRequest([
                'email' => $request->email,
                'google_id' => $request->google_id
            ]));
        }

        return ResponseHelper::success('success', 'User created successfully!', $user, 201);
    }

    /**
     * Login user.
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        // Validate credentials
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return ResponseHelper::error('error', 'Credenciales incorrectas.', 401);
        }

        // Get the authenticated user
        $user = Auth::user();
        if (!$user) {
            return ResponseHelper::error('error', 'Usuario no encontrado.', 404);
        }

        // Create API token
        try {
            $token = $user->createToken('auth_token')->plainTextToken;
            return ResponseHelper::success('success', 'Usuario autenticado con éxito!', ['token' => $token, 'user' => $user]);
        } catch (\Exception $e) {
            return ResponseHelper::error('error', 'Error al crear el token: '.$e->getMessage(), 500);
        }
    }

    /**
     * Login user via Google.
     * @param Request $request
     */
    private function loginGoogle(LoginGoogleRequest $request)
    {
        // Find the user by email
        $user = User::where('email', $request->email)->where('status', 'active')->first();

        // If user doesn't exist or is not active, return error
        if (!$user) {
            return ResponseHelper::error('error', 'El usuario no existe o no está activo.', 404);
        }

        // Check if the user is authenticated through Google (by google_id)
        if ($user->google_id === $request->google_id) {
            // Create API token and return it
            try {
                $token = $user->createToken('auth_token')->plainTextToken;
                return ResponseHelper::success('success', 'Usuario autenticado con éxito vía Google!', ['token' => $token, 'user' => $user]);
            } catch (\Exception $e) {
                return ResponseHelper::error('error', 'Error al crear el token: '.$e->getMessage(), 500);
            }
        }

        // If Google ID doesn't match, return error
        return ResponseHelper::error('error', 'Google ID no coincide con el usuario.', 403);
    }

    /**
     * Get user profile.
     * @param NA,
     * @return response
     */

    public function userProfile()
    {
        $user = Auth::user();
        if(!$user) {
            return ResponseHelper::error('error', 'Usuario no encontrado.', 404);
        }

        return ResponseHelper::success('success', 'Perfil de usuario', $user);
    }

    /**
     * Logout user.
     * @param NA
     * @return response
     */

    public function logout()
    {
        $user = Auth::user();
        if(!$user) {
            return ResponseHelper::error('error', 'Usuario no encontrado.', 404);
        }

        $user->currentAccessToken()->delete();
        return ResponseHelper::success('success', 'Usuario deslogueado con éxito!');
    }
}

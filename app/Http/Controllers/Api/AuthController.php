<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


     public function store(Request $request): JsonResponse
     {
         $validatedData = $request->validate([
             'data.attributes.name' => ['required', 'string', 'min:4'],
             'data.attributes.email' => ['required', 'email', 'unique:users,email'],
             'data.attributes.password' => ['required', 'confirmed'],
         ]);
     
         // Convertir el correo electrónico a minúsculas
         $email = strtolower($validatedData['data']['attributes']['email']);
     
         $user = User::create([
             'name' => $validatedData['data']['attributes']['name'],
             'email' => $email,
             'password' => Hash::make($validatedData['data']['attributes']['password']), // Asegúrate de hashear la contraseña
         ]);
     
         $token = $user->createToken('auth_token')->plainTextToken;
     
         return response()->json([
             'user' => $user,
             'token' => $token,
         ]);
     }
     


    public function login(Request $request): JsonResponse
    {

        $request->validate([
            'data.attributes.email' => ['required', 'email', 'exists:users,email'],
            'data.attributes.password' => ['required', 'string'],
        ]);
        
        $credentials = [
            'email' => $request->input('data.attributes.email'),
            'password' => $request->input('data.attributes.password')
        ];
        
        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = User::where('email', $credentials['email'])->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

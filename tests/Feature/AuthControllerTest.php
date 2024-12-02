<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    // Test para el método 'index' (listar usuarios)
    public function test_index_returns_users()
    {
        // Crea un usuario de prueba
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
        ]);

        // Crea un token para el usuario
        $token = $user->createToken('blog')->plainTextToken;

        // Realiza la solicitud GET a la ruta /api/users con el token
        $response = $this->getJson('/api/users', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Verifica que la respuesta tenga un estado 200
        $response->assertStatus(200);

        // Verifica que el usuario esté en la respuesta
        $response->assertJsonFragment(['name' => 'Test User']);
    }

    // Test para el método 'register' (registro de usuario)
    public function test_register_creates_user()
    {
        $data = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
        ];

        // Realiza la solicitud POST a la ruta /api/create-register
        $response = $this->postJson('/api/create-register', $data);

        // Verifica que la respuesta tenga un estado 201
        $response->assertStatus(201);

        // Verifica que la respuesta contenga el token y el usuario
        $response->assertJsonStructure([
            'user' => ['id', 'name', 'email'],
            'token',
        ]);

        // Verifica que el usuario haya sido creado en la base de datos
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
        ]);
    }

    // Test para el método 'register' con validación fallida
    public function test_register_fails_validation()
    {
        $data = [
            'name' => 'Invalid User', // No email y password
            'email' => 'invalidemail',
            'password' => 'short',
        ];

        // Realiza la solicitud POST a la ruta /api/create-register
        $response = $this->postJson('/api/create-register', $data);

        // Verifica que la respuesta tenga un estado 400
        $response->assertStatus(400);

        // Verifica que los errores de validación estén presentes
        $response->assertJsonValidationErrors(['email', 'password']);
    }

    // Test para el método 'login' (autenticación de usuario)
    public function test_login_returns_token()
    {
        // Crea un usuario de prueba
        $user = User::factory()->create([
            'email' => 'prueba1@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Los datos para iniciar sesión
        $data = [
            'email' => 'prueba1@example.com',
            'password' => 'password123',
        ];

        // Realiza la solicitud POST a la ruta /api/sign-in
        $response = $this->postJson('/api/sign-in', $data);

        // Verifica que la respuesta tenga un estado 200
        $response->assertStatus(200);

        // Verifica que la respuesta contenga un token
        $response->assertJsonStructure(['token']);
    }

    // Test para el método 'login' con credenciales incorrectas
    public function test_login_fails_invalid_credentials()
    {
        // Crea un usuario de prueba
        $user = User::factory()->create([
            'email' => 'prueba2@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Los datos de login con credenciales incorrectas
        $data = [
            'email' => 'prueba2@example.com',
            'password' => 'wrongpassword',
        ];

        // Realiza la solicitud POST a la ruta /api/sign-in
        $response = $this->postJson('/api/sign-in', $data);

        // Verifica que la respuesta tenga un estado 401
        $response->assertStatus(401);

        // Verifica que el mensaje de error sea el esperado
        $response->assertJson(['message' => 'Unauthorized']);
    }
}

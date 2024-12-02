<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_create_post()
    {
        // Crear un usuario y autenticarlo
        $user = User::factory()->create([
            'email' => 'prueba3@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Autenticamos al usuario usando Sanctum
        Sanctum::actingAs($user, ['create-posts']);  // Autenticamos con permisos para crear posts

        // Crear una categoría usando la fábrica
        $category = Category::factory()->create();

        // Datos para crear el post
        $postData = [
            'title' => 'Nuevo post',
            'content' => 'Contenido del post',
            'category_id' => $category->id,
        ];

        // Enviar solicitud POST para crear el post
        $response = $this->postJson('/api/create-posts', $postData);

        // Verificar que la respuesta sea 201 y que el post fue creado
        $response->assertStatus(201);
        $response->assertJsonStructure(['post' => ['id', 'title', 'content', 'user_id', 'category_id']]);

        // Verificar que el post existe en la base de datos
        $this->assertDatabaseHas('posts', [
            'title' => 'Nuevo post',
            'content' => 'Contenido del post',
            'category_id' => $category->id,
        ]);
    }

    /** @test */
    public function test_create_post_validation_error()
    {
        // Crear un usuario y autenticarlo
        $user = User::factory()->create([
            'email' => 'prueba4@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Autenticamos al usuario usando Sanctum
        Sanctum::actingAs($user, ['create-posts']);  // Autenticamos con permisos para crear posts

        // Enviar solicitud POST con datos incorrectos (falta 'title' y 'category_id')
        $response = $this->postJson('/api/create-posts', [
            'content' => 'Contenido del post',
        ]);

        // Verificar que la respuesta sea un error de validación (422)
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title', 'category_id']);
    }

    /** @test */
    public function test_get_posts_by_category()
    {
        // Crear un usuario y autenticarlo
        $user = User::factory()->create([
            'email' => 'prueba5@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Autenticamos al usuario usando Sanctum
        Sanctum::actingAs($user);  // No es necesario pasar permisos adicionales

        // Crear una categoría usando la fábrica
        $category = Category::factory()->create();

        // Crear algunos posts en esa categoría
        Post::factory()->count(3)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        // Enviar solicitud GET para obtener los posts por categoría
        $response = $this->getJson("/api/posts/{$category->id}");

        // Verificar que la respuesta sea 200 y que los posts estén presentes
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'posts');  // Verifica que se retornaron 3 posts
        $response->assertJsonFragment(['category_id' => $category->id]);
    }

    /** @test */
    public function test_create_post_requires_authentication()
    {
        // Enviar solicitud POST sin autenticación
        $response = $this->postJson('/api/create-posts', [
            'title' => 'Nuevo post',
            'content' => 'Contenido del post',
            'category_id' => 1,  // Suponiendo que la categoría con ID 1 existe
        ]);

        // Verificar que la respuesta sea un error de autenticación (401)
        $response->assertStatus(401);
    }
}


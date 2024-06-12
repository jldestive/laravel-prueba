<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsuarioControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function test_store_usuario()
    {
        $user = User::factory()->create();

        $usuario = [
            'nombre' => $this->faker->name,
            'correo' => $this->faker->unique()->safeEmail,
            'apellidos' => $this->faker->lastName,
            'sexo' => $this->faker->randomElement(['M', 'F']),
        ];

        $response = $this->actingAs($user)->postJson(route('usuarios.store'), $usuario);

        $response->assertCreated();

        $response->assertJsonStructure([
            'usuario' => [
                'nombre',
                'correo',
                'apellidos',
                'sexo',
            ],
            'message',
        ]);

        $response->assertJson([
            'usuario' => $usuario,
            'message' => 'Usuario creado con éxito',
        ]);

        $this->assertDatabaseHas('usuarios', $usuario);
    }

    public function test_show_usuario()
    {
        $user = User::factory()->create();

        $usuario = Usuario::factory()->create();

        $response = $this->actingAs($user)->getJson(route('usuarios.show', $usuario->id));

        $response->assertOk();

        $response->assertJsonStructure([
            'nombre',
            'correo',
            'apellidos',
            'sexo',
        ]);

        $response->assertJson([
            'nombre' => $usuario->nombre,
            'correo' => $usuario->correo,
            'apellidos' => $usuario->apellidos,
            'sexo' => $usuario->sexo,
        ]);
    }

    public function test_update_usuario()
    {
        $user = User::factory()->create();
        $usuario = Usuario::factory()->create();

        $newusuario = [
            'nombre' => $this->faker->name,
            'correo' => $this->faker->unique()->safeEmail,
            'apellidos' => $this->faker->lastName,
            'sexo' => $this->faker->randomElement(['M', 'F']),
        ];

        $response = $this->actingAs($user)->putJson(route('usuarios.update', $usuario->id), $newusuario);

        $response->assertOk();

        $response->assertJsonStructure([
            'usuario' => [
                'nombre',
                'correo',
                'apellidos',
                'sexo',
            ],
            'message',
        ]);

        $response->assertJson([
            'usuario' => $newusuario,
            'message' => 'Usuario actualizado con éxito',
        ]);

        $this->assertDatabaseHas('usuarios', $newusuario);
    }

    public function test_destroy_usuario()
    {
        $user = User::factory()->create();

        $usuario = Usuario::factory()->create();

        $response = $this->actingAs($user)->deleteJson(route('usuarios.destroy', $usuario->id));

        $response->assertOk();

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson([
            'message' => 'Usuario eliminado con éxito',
        ]);

        $this->assertDatabaseMissing('usuarios', $usuario->toArray());
    }
}

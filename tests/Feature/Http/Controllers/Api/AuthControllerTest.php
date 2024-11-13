<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Enums\Models\User\GenderEnum;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_registration(): void
    {
        $user = User::factory()->make();
        $password = fake()->password();

        $this->assertModelMissing($user);

        $response = $this->postJson(route('auth.registration'), [
            'email' => $user->email,
            'gender' => $user->gender,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(Response::HTTP_CREATED)->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);
        $this->assertModelExists(User::where('email', $user->email)->first());
    }

    public function test_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('auth.profile'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'email' => $user->email,
                    'gender' => $user->gender->value,
                ]
            ]);
    }
}

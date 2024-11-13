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
            'password' => $password,
            'password_confirmation' => $password,
            'gender' => fake()->randomElement(GenderEnum::cases())->value
        ]);

        $response->assertStatus(Response::HTTP_CREATED)->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);
        $this->assertModelExists(User::where('email', $user->email)->first());
    }
}

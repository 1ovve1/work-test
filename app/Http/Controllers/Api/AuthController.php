<?php

namespace App\Http\Controllers\Api;

use App\Enums\Models\User\GenderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegistrationRequest;
use App\Http\Resources\Api\Auth\RegistrationSuccessResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function registration(RegistrationRequest $request): JsonResponse
    {
        $payload = $request->validated();

        $user = new User([
            ...$payload,
            'gender' => GenderEnum::tryFrom($payload['gender']) ?? GenderEnum::UNKNOWN
        ]);
        $user->save();

        $newAccessToken = $user->createToken($payload['email']);

        return RegistrationSuccessResource::make($newAccessToken)
            ->response()->setStatusCode(Response::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: "/auth/login",
        tags: ["Auth"],
        summary: "Вход в систему",
        description: "Аутентификация по email и паролю. Возвращает JWT токен.",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email", example: "user@example.com", description: "Email пользователя"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "secret123", description: "Пароль пользователя"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Успешная авторизация",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "access_token", type: "string", example: "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
                        new OA\Property(property: "token_type", type: "string", example: "bearer"),
                        new OA\Property(property: "expires_in", type: "integer", example: 3600, description: "Время жизни токена в секундах"),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Неверные учётные данные",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Unauthorized"),
                    ]
                )
            ),
        ]
    )]
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    #[OA\Post(
        path: "/auth/me",
        tags: ["Auth"],
        summary: "Текущий пользователь",
        description: "Возвращает данные текущего авторизованного пользователя",
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Данные пользователя",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "id", type: "integer", example: 1),
                        new OA\Property(property: "name", type: "string", example: "Иван Иванов"),
                        new OA\Property(property: "email", type: "string", format: "email", example: "user@example.com"),
                        new OA\Property(property: "email_verified_at", type: "string", format: "date-time", nullable: true),
                        new OA\Property(property: "created_at", type: "string", format: "date-time"),
                        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Не авторизован / токен истёк",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Unauthorized"),
                    ]
                )
            ),
        ]
    )]
    public function me()
    {
        return response()->json(auth()->guard('api')->user());
    }

    #[OA\Post(
        path: "/auth/logout",
        tags: ["Auth"],
        summary: "Выход из системы",
        description: "Инвалидирует текущий JWT токен",
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Успешный выход",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Successfully logged out"),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Не авторизован / токен истёк",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Unauthorized"),
                    ]
                )
            ),
        ]
    )]
    public function logout()
    {
        auth()->guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    #[OA\Post(
        path: "/auth/refresh",
        tags: ["Auth"],
        summary: "Обновить токен",
        description: "Обновляет текущий JWT токен. Старый токен инвалидируется.",
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Токен успешно обновлён",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "access_token", type: "string", example: "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
                        new OA\Property(property: "token_type", type: "string", example: "bearer"),
                        new OA\Property(property: "expires_in", type: "integer", example: 3600, description: "Время жизни нового токена в секундах"),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Не авторизован / токен истёк",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Token has expired"),
                    ]
                )
            ),
        ]
    )]
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60
        ]);
    }
}

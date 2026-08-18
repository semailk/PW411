<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use App\Repositories\Genre\GenreRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Kinopoisk API",
    version: "1.0.0",
    description: "API для управления жанрами кинопоиска",
    contact: new OA\Contact(
        email: "admin@kinopoisk.com",
        name: "Kinopoisk API Support"
    )
)]
#[OA\Server(
    url: "/api",
    description: "API Server"
)]
#[OA\SecurityScheme(
    type: "apiKey",
    in: "header",
    securityScheme: "bearerAuth",
    name: "Authorization",
    description: "JWT токен авторизации. Формат: Bearer {token}"
)]
class GenreController extends Controller
{
    public function __construct(
        private GenreRepository $genreRepository
    ){}

    #[OA\Get(
        path: "/genres",
        tags: ["Genres"],
        summary: "Список всех жанров",
        description: "Возвращает пагинированный список всех жанров",
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "page",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 1),
                description: "Номер страницы"
            ),
            new OA\Parameter(
                name: "per_page",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 10),
                description: "Количество элементов на странице"
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Успешный ответ",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(ref: "#/components/schemas/Genre")
                        ),
                        new OA\Property(property: "current_page", type: "integer"),
                        new OA\Property(property: "last_page", type: "integer"),
                        new OA\Property(property: "per_page", type: "integer"),
                        new OA\Property(property: "total", type: "integer"),
                    ]
                )
            ),
            new OA\Response(response: 401, description: "Не авторизован"),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        return $this->genreRepository->index();
    }

    #[OA\Get(
        path: "/genres/{genre}",
        tags: ["Genres"],
        summary: "Получить жанр по ID",
        description: "Возвращает детальную информацию о жанре по его ID",
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "genre",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer"),
                description: "ID жанра"
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Успешный ответ",
                content: new OA\JsonContent(ref: "#/components/schemas/Genre")
            ),
            new OA\Response(
                response: 404,
                description: "Жанр не найден",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Не найдено"),
                    ]
                )
            ),
            new OA\Response(response: 401, description: "Не авторизован"),
        ]
    )]
    public function show(Genre $genre): GenreResource
    {
        return $this->genreRepository->show($genre);
    }

    #[OA\Post(
        path: "/genres",
        tags: ["Genres"],
        summary: "Создать новый жанр",
        description: "Создаёт новый жанр в системе",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "slug"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Фантастика", description: "Название жанра"),
                    new OA\Property(property: "slug", type: "string", example: "fantastika", description: "URL-slug жанра"),
                    new OA\Property(property: "description", type: "string", example: "Жанр научной фантастики", description: "Описание жанра"),
                    new OA\Property(property: "is_active", type: "boolean", example: true, description: "Активен ли жанр"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Жанр успешно создан",
                content: new OA\JsonContent(ref: "#/components/schemas/Genre")
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "The name field is required."),
                    ]
                )
            ),
            new OA\Response(response: 401, description: "Не авторизован"),
        ]
    )]
    public function store(GenreRequest $genreRequest): GenreResource
    {
        return $this->genreRepository->store($genreRequest);
    }

    #[OA\Put(
        path: "/genres/{genre}",
        tags: ["Genres"],
        summary: "Обновить жанр",
        description: "Обновляет данные существующего жанра",
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "genre",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer"),
                description: "ID жанра"
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Научная фантастика", description: "Название жанра"),
                    new OA\Property(property: "slug", type: "string", example: "nauchnaya-fantastika", description: "URL-slug жанра"),
                    new OA\Property(property: "description", type: "string", example: "Обновлённое описание", description: "Описание жанра"),
                    new OA\Property(property: "is_active", type: "boolean", example: true, description: "Активен ли жанр"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Жанр успешно обновлён",
                content: new OA\JsonContent(ref: "#/components/schemas/Genre")
            ),
            new OA\Response(
                response: 404,
                description: "Жанр не найден",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Не найдено"),
                    ]
                )
            ),
            new OA\Response(response: 422, description: "Ошибка валидации"),
            new OA\Response(response: 401, description: "Не авторизован"),
        ]
    )]
    public function update(GenreRequest $genreRequest, Genre $genre): GenreResource
    {
        return $this->genreRepository->update($genreRequest, $genre);
    }

    #[OA\Delete(
        path: "/genres/{genre}",
        tags: ["Genres"],
        summary: "Удалить жанр",
        description: "Удаляет жанр из системы вместе со связанными фильмами",
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "genre",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer"),
                description: "ID жанра"
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Жанр успешно удалён",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "data", type: "string", example: "Жанр был удален!"),
                        new OA\Property(property: "status", type: "integer", example: 200),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Жанр не найден",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Не найдено"),
                    ]
                )
            ),
            new OA\Response(response: 401, description: "Не авторизован"),
        ]
    )]
    public function destroy(Genre $genre): JsonResponse
    {
        return $this->genreRepository->destroy($genre);
    }
}

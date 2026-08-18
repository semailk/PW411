<?php

namespace App\Http\Controllers\API\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Genre",
    type: "object",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Фантастика"),
        new OA\Property(property: "is_active", type: "boolean", example: true),
        new OA\Property(property: "slug", type: "string", example: "fantastika"),
        new OA\Property(property: "description", type: "string", example: "Жанр научной фантастики"),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "18-08-2026 12:00:00"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "18-08-2026 12:00:00"),
        new OA\Property(
            property: "movies",
            type: "array",
            items: new OA\Items(type: "object", properties: [
                new OA\Property(property: "id", type: "integer"),
                new OA\Property(property: "title", type: "string"),
            ])
        ),
    ]
)]
class GenreSchema
{
    //
}

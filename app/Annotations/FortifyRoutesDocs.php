<?php

namespace App\Annotations;

use OpenApi\Attributes as OA;

class FortifyRoutesDocs
{
    #[OA\Post(
        path: '/api/login',
        summary: 'Log in user',
        tags: ['Authentication'],
        security: [],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'email', type: 'string'),
                    new OA\Property(property: 'password', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful authentication",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "access_token",
                            type: "string",
                            example: "QH0mvRZiTfOAds5Zy6B8ngJLZRfzk20nqEhoijgMe6f98fc1"
                        ),
                        new OA\Property(
                            property: "token_type",
                            type: "string",
                            example: "Bearer"
                        ),
                        new OA\Property(
                            property: "user",
                            type: "object",
                            properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "name", type: "string", example: "Admin"),
                                new OA\Property(property: "email", type: "string", example: "admin@maus.com"),
                                new OA\Property(property: "email_verified_at", type: "string", format: "date-time", nullable: true, example: null),
                                new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2026-03-17T18:31:35.000000Z"),
                                new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2026-03-17T18:31:35.000000Z"),
                                new OA\Property(property: "two_factor_secret", type: "string", nullable: true, example: null),
                                new OA\Property(property: "two_factor_recovery_codes", type: "string", nullable: true, example: null),
                                new OA\Property(property: "two_factor_confirmed_at", type: "string", format: "date-time", nullable: true, example: null),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Unprocessable Entity'),
        ]
    )]
    #[OA\SecurityScheme(
        securityScheme: "bearerAuth",
        type: "http",
        scheme: "bearer",
        bearerFormat: "JWT",
        description: "Use the access_token obtained from the /login endpoint. Example: Bearer {access_token}"
    )]
    public function login() {}

    
}

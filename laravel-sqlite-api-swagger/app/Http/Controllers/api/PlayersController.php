<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Players', description: 'Player management endpoints')]
#[OA\Schema(
    schema: 'Player',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'Name', type: 'string', example: 'Connor McDavid'),
        new OA\Property(property: 'Team', type: 'string', example: 'Edmonton Oilers'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]
#[OA\Schema(
    schema: 'PlayerRequest',
    required: ['Name', 'Team'],
    properties: [
        new OA\Property(property: 'Name', type: 'string', example: 'Connor McDavid'),
        new OA\Property(property: 'Team', type: 'string', example: 'Edmonton Oilers'),
    ]
)]
class PlayersController extends Controller
{
    #[OA\Get(
        path: '/api/players',
        tags: ['Players'],
        summary: 'Get all players',
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of all players',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/Player')
                )
            ),
        ]
    )]
    public function index()
    {
        return Player::all();
    }

    #[OA\Post(
        path: '/api/players',
        tags: ['Players'],
        summary: 'Create a new player',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/PlayerRequest')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Player created successfully',
                content: new OA\JsonContent(ref: '#/components/schemas/Player')
            ),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Team' => 'required|string|max:255',
        ]);

        return response()->json(Player::create($validated), 201);
    }

    #[OA\Get(
        path: '/api/players/{id}',
        tags: ['Players'],
        summary: 'Get a player by ID',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, description: 'Player ID', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Player details',
                content: new OA\JsonContent(ref: '#/components/schemas/Player')
            ),
            new OA\Response(response: 404, description: 'Player not found'),
        ]
    )]
    public function show(Player $player)
    {
        return $player;
    }

    #[OA\Put(
        path: '/api/players/{id}',
        tags: ['Players'],
        summary: 'Update a player',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, description: 'Player ID', schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/PlayerRequest')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Update result',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean'),
                        new OA\Property(property: 'player', ref: '#/components/schemas/Player'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Player not found'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function update(Request $request, Player $player)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Team' => 'required|string|max:255',
        ]);

        $isSuccess = $player->update($validated);

        return [
            'success' => $isSuccess,
            'player' => $player->fresh(),
        ];
    }

    #[OA\Delete(
        path: '/api/players/{id}',
        tags: ['Players'],
        summary: 'Delete a player',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, description: 'Player ID', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Delete result',
                content: new OA\JsonContent(
                    properties: [new OA\Property(property: 'success', type: 'boolean')]
                )
            ),
            new OA\Response(response: 404, description: 'Player not found'),
        ]
    )]
    public function destroy(Player $player)
    {
        $isSuccess = $player->delete();

        return [
            'success' => $isSuccess,
        ];
    }
}

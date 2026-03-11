<?php

namespace App\Http\Controllers;

use App\Services\ScryfallService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class CardController extends Controller
{
    public function __construct(protected ScryfallService $scryfall) {}

    /**
     * @OA\Get(
     *     path="/cards/search",
     *     summary="Search Magic cards",
     *     description="Search cards using the Scryfall API",
     *     tags={"Cards"},
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=true,
     *         description="Search query",
     *         @OA\Schema(type="string", example="sol ring")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Card results"
     *     )
     * )
     */
    public function search(Request $req)
    {
        $validator = Validator::make($req->all(), ['q' => 'required']);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        return $this->scryfall->search($req->q);
    }
}

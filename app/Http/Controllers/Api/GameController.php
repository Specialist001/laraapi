<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\GameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $games = Game::all();
        if ($games->isEmpty()) {
            return $this->notFoundResponse();
        }

        return $this->successResponse(GameResource::collection($games),'All games');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GameRequest $request)
    {
        try {
            $game = Game::create($request->validated());
            return $this->successResponse(GameResource::make($game),'Game Added');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::find($id);
        if (!$game) {
            return $this->notFoundResponse();
        }

        return $this->successResponse(GameResource::make($game),'Game');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(GameRequest $request, $id)
    {
        $game = Game::find($id);
        if (!$game) {
            return $this->notFoundResponse();
        }

        $game->fill($request->validated());
        $game->save();
        return $this->successResponse(GameResource::make($game),'Game updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::find($id);
        if (!$game) {
            return $this->notFoundResponse();
        }
        if($game->delete()) {
            return $this->successResponse(200,'Game deleted');
        }
        return $this->notFoundResponse();
    }
    
    private function notFoundResponse()
    {
        return $this->errorResponse('Game Not Found', 404);
    }
}

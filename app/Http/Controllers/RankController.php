<?php

namespace App\Http\Controllers;

use App\Service\Ranking;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RankController extends Controller
{
    public function index(Ranking $rank): View
    {
        $users = $rank->getTopUsers();
        return view('users.top', compact('users'));
    }

    public function show(string $id, Ranking $rank): JsonResponse
    {
        $score = $rank->getUserScore($id);
        return $score
            ? response()->json(['message' => "У пользователя ID:$id: $score очков"])
            : response()->json(['message' => "Пользователь ID:$id не найден"], 404);
    }

    public function update(Request $request, string $id, Ranking $rank): JsonResponse
    {
        $operation = $request->action ?? 'set';
        $score = $request->score ?? 0;

        match ($operation) {
            'inc'    => $rank->incrementScore($id, $score),
            'dec'    => $rank->decrementScore($id, $score),
            default  => $rank->updateScore($id, $score),
        };

        $newScore = $rank->getUserScore($id);
        return response()->json(['message' => "ID:$id обновлен. Очки: $newScore"]);
    }

    public function destroy(string $id, Ranking $rank): JsonResponse
    {
        $rank->removeUser($id);
        return response()->json(['message' => "Пользователь ID:$id удален и скоринга"]);
    }
}

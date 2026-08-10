<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UsersListRequest;
use App\Models\User;
use App\Service\Ranking;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(UsersListRequest $request, Ranking $rank): View
    {
        $sortBy = $request->validated('sort') ?? 'id';
        $direction = $request->validated('direction') ?? 'asc';
        $page = $request->validated('page', 1);
        $cacheKey = "users_list:{$page}-{$sortBy}-{$direction}";
        $newDirection = $direction === 'asc' ? 'desc' : "asc";

        $users = User::orderBy($sortBy, $direction)->paginate(10);
        $users->each(function($user) use ($rank) {
            $user->setAttribute('score', $rank->getUserScore($user->id));
        });
        
        return view('users.index', compact('users', 'sortBy', 'direction', 'newDirection'));
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $auth = Auth::attempt($credentials, true);

        return $auth
            ? redirect()->intended('/push')
            : redirect()->back()->withErrors(['email' => 'Неверный емейл или пароль']);
    }
}

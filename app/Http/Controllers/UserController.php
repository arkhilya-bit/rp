<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersListRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function index(UsersListRequest $request)
    {
        $sortBy = $request->validated('sort') ?? 'id';
        $direction = $request->validated('direction') ?? 'asc';
        $page = $request->validated('page', 1);
        $cacheKey = "users_list:{$page}-{$sortBy}-{$direction}";
        $newDirection = $direction === 'asc' ? 'desc' : "asc";

        $users = Cache::remember($cacheKey, now()->addMinutes(10),
            fn() => User::orderBy($sortBy, $direction)->paginate(10));
        
        return view('users.index', compact('users', 'sortBy', 'direction', 'newDirection'));
    }

    public function showTopUsers(Request $request)
    {
        $users = Cache::remember('top_users', now()->addMinutes(10), fn() => User::getTopUsers());
        
        return view('users.top', compact('users'));
    }
}

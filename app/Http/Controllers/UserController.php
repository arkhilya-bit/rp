<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersListRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index(UsersListRequest $request)
    {
        $sortBy = $request->validated('sort') ?? 'id';
        $direction = $request->validated('direction') ?? 'asc';
        $newDirection = $direction === 'asc' ? 'desc' : "asc";

        $users = User::orderBy($sortBy, $direction)->paginate(10);

        return view('users.index', compact('users', 'sortBy', 'direction', 'newDirection'));
    }
}

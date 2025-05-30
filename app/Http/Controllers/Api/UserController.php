<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::withCount('ads')->get();

        return $this->successResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }

    public function show(User $user): JsonResponse
    {
        $user->loadCount('ads');

        return $this->successResponse(new UserResource($user), 'User retrieved successfully.');
    }
}

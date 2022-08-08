<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{


    private UserService $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
     * get 3 users with most transactions in last 10 minutes
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getUsersWithMostTransactions(Request $request): AnonymousResourceCollection
    {
        return UserResource::collection($this->service->getUsersWithMostTransactions());
    }
}

<?php

namespace App\Http\Service;

use App\Http\Repository\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    protected UserRepository $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function getUsersWithMostTransactions(int $limit = 3): Collection
    {
        return $this->repository->getWithMostTransactions($limit);
    }
}

<?php

namespace App\Service;

use App\Entity\RegisterHash;
use App\Entity\User;
use App\Repository\RegisterHashRepository;
use App\Repository\UserRepository;

class UserService
{

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly RegisterHashService $hashService
    )
    {
    }

    public function resetPassword(User $user) {

        $user->setPassword(null);
        $this->userRepository->save($user, true);

        $this->hashService->createHash($user);

    }

    public function storePassword(User $user, string $password) {
        $this->hashService->cleanHashes($user);
    }

}
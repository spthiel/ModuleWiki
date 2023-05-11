<?php

namespace App\Service;

use App\Entity\RegisterHash;
use App\Entity\User;
use App\Repository\RegisterHashRepository;
use DateTime;

class RegisterHashService
{

    public const HASH_TIMEOUT = 24 * 60 * 60;

    public function __construct(
        private readonly RegisterHashRepository $registerHashRepository
    )
    {
    }

    public function createHash(User $user) {

        $hash = $user->getId() . "" . md5(time() . $user->getUsername());

        $registerHash = new RegisterHash();
        $registerHash->setUser($user);
        $registerHash->setHash($hash);
        $registerHash->setTimestamp(new DateTime());

        $this->clearHashes($user);
        $this->registerHashRepository->save($registerHash, true);

    }

    public function cleanHashes(User $user) {
        $this->registerHashRepository->cleanHashes($user);
    }

    public function clearHashes(User $user) {
        $this->registerHashRepository->removeByUser($user);
    }

}
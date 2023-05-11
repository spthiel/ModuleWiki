<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class FlushableRepository extends ServiceEntityRepository
{

    public function flush() {
        $this->getEntityManager()->flush();
    }

}
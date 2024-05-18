<?php

namespace App\Repository;

use App\Entity\RegisterHash;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RegisterHash>
 *
 * @method RegisterHash|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegisterHash|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegisterHash[]    findAll()
 * @method RegisterHash[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegisterHashRepository extends FlushableRepository
{

    public const HASH_LIFETIME_DAYS = 7;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegisterHash::class);
    }

    public function save(RegisterHash $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RegisterHash $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function cleanHashes() {

        $timestamp = new DateTime(sprintf("-%d days", self::HASH_LIFETIME_DAYS));

        $builder = $this->createQueryBuilder("hash");
        $builder
            ->delete()
            ->where($builder->expr()->lt('hash.timestamp',  $timestamp))
            ->getQuery()
            ->execute();
    }

    public function removeByUser(User $user) {
        $builder = $this->createQueryBuilder("hash");
        $builder
            ->delete()
            ->where($builder->expr()->eq('hash.user', $user))
            ->getQuery()
            ->execute();
    }

//    /**
//     * @return RegisterHash[] Returns an array of RegisterHash objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RegisterHash
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

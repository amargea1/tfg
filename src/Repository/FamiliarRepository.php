<?php

namespace App\Repository;

use App\Entity\FamiliarEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FamiliarEntity>
 *
 * @method FamiliarEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamiliarEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamiliarEntity[]    findAll()
 * @method FamiliarEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamiliarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamiliarEntity::class);
    }

//    /**
//     * @return FamiliarEntity[] Returns an array of FamiliarEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FamiliarEntity
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

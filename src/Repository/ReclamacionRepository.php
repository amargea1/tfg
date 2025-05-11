<?php

namespace App\Repository;

use App\Entity\ReclamacionEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReclamacionEntity>
 *
 * @method ReclamacionEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReclamacionEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReclamacionEntity[]    findAll()
 * @method ReclamacionEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReclamacionEntity::class);
    }

//    /**
//     * @return ReclamacionEntity[] Returns an array of ReclamacionEntity objects
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

//    public function findOneBySomeField($value): ?ReclamacionEntity
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

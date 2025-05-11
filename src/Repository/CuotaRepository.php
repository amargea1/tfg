<?php

namespace App\Repository;

use App\Entity\CuotaEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CuotaEntity>
 *
 * @method CuotaEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method CuotaEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method CuotaEntity[]    findAll()
 * @method CuotaEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuotaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CuotaEntity::class);
    }

//    /**
//     * @return CuotaEntity[] Returns an array of CuotaEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CuotaEntity
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

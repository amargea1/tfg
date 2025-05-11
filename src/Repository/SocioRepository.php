<?php

namespace App\Repository;

use App\Entity\SocioEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SocioEntity>
 *
 * @method SocioEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocioEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocioEntity[]    findAll()
 * @method SocioEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocioEntity::class);
    }

//    /**
//     * @return SocioEntity[] Returns an array of SocioEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SocioEntity
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

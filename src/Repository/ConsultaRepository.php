<?php

namespace App\Repository;

use App\Entity\ConsultaEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConsultaEntity>
 *
 * @method ConsultaEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConsultaEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConsultaEntity[]    findAll()
 * @method ConsultaEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsultaEntity::class);
    }

//    /**
//     * @return ConsultaEntity[] Returns an array of ConsultaEntity objects
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

//    public function findOneBySomeField($value): ?ConsultaEntity
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\NoSocioEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NoSocioEntity>
 *
 * @method NoSocioEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method NoSocioEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method NoSocioEntity[]    findAll()
 * @method NoSocioEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoSocioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NoSocioEntity::class);
    }

//    /**
//     * @return NoSocioEntity[] Returns an array of NoSocioEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NoSocioEntity
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

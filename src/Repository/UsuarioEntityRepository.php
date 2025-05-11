<?php

namespace App\Repository;

use App\Entity\UsuarioEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsuarioEntity>
 *
 * @method UsuarioEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsuarioEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsuarioEntity[]    findAll()
 * @method UsuarioEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsuarioEntity::class);
    }

//    /**
//     * @return UsuarioEntity[] Returns an array of UsuarioEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UsuarioEntity
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

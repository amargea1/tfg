<?php

namespace App\Repository;

use App\Entity\UsuarioEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UsuarioEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsuarioEntity::class);
    }

    public function findNombreById(int $id): ?string
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u.nombre')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        try {
            return $qb->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException) {
            return null;
        }
    }

}
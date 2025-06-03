<?php

namespace App\Repository;

use App\Entity\ReclamacionEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReclamacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReclamacionEntity::class);
    }


    public function contarReclamacionesAbiertas(): int
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->where('r.fechaCierre IS NULL')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllWithFamiliar(): array
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.familiar', 'f')
            ->addSelect('f')
            ->getQuery()
            ->getResult();
    }

}

<?php

namespace App\Repository;

use App\Entity\ConsultaEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ConsultaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsultaEntity::class);
    }

    public function contarConsultasAbiertas(): int
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.fechaCierre IS NULL')
            ->getQuery()
            ->getSingleScalarResult();
    }

}

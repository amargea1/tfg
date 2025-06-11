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


    public function findWithEstadoOrdered(string $estado): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.estado = :estado')
            ->setParameter('estado', $estado)
            ->orderBy('c.fechaApertura', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllOrderedByFechaDesc(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.fechaApertura', 'DESC')
            ->getQuery()
            ->getResult();
    }
}

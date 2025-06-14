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
            ->orderBy('r.fechaApertura', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByEstadoAndPrioridadWithFamiliar(?string $estado, ?string $prioridad): array
    {
        $qb = $this->createQueryBuilder('r')
            ->leftJoin('r.familiar', 'f')
            ->addSelect('f');

        if ($estado) {
            $qb->andWhere('r.estado = :estado')
                ->setParameter('estado', $estado);
        }

        if ($prioridad) {
            $qb->andWhere('r.prioridad = :prioridad')
                ->setParameter('prioridad', $prioridad);
        }

        return $qb->orderBy('r.fechaApertura', 'DESC')
            ->getQuery()
            ->getResult();
    }


}

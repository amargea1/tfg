<?php

namespace App\Repository;

use App\Entity\SocioEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SocioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocioEntity::class);
    }

    public function contarSocios(): int
    {
        return $this->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->where('s.estaActivo = :activo')
            ->setParameter('activo', true)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function contarSociosHoy(): int
    {
        $inicioDia = new \DateTime('today');
        $finDia = new \DateTime('tomorrow');

        return (int)$this->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->where('s.fechaRegistro >= :inicio')
            ->andWhere('s.fechaRegistro < :fin')
            ->setParameter('inicio', $inicioDia)
            ->setParameter('fin', $finDia)
            ->getQuery()
            ->getSingleScalarResult();
    }
}

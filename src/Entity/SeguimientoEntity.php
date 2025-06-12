<?php

namespace App\Entity;

use App\Repository\SeguimientoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SeguimientoRepository::class)]
#[ORM\Table(name: "seguimiento")]
class SeguimientoEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ReclamacionEntity::class)]
    private ?ReclamacionEntity $reclamacion = null;

    #[ORM\ManyToOne(targetEntity: AdministradorEntity::class, inversedBy: 'seguimientos')]
    private ?AdministradorEntity $admin = null;


    #[ORM\Column(type: 'datetime')]
    #[Assert\GreaterThanOrEqual("today", message: "La fecha no puede ser anterior al día actual")]
    private \DateTimeInterface $fecha;

    #[ORM\Column(type: 'text')]
    private string $comentario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReclamacion(): ?ReclamacionEntity
    {
        return $this->reclamacion;
    }

    public function setReclamacion(?ReclamacionEntity $reclamacion): void
    {
        $this->reclamacion = $reclamacion;
    }

    public function getAdmin(): ?AdministradorEntity
    {
        return $this->admin;
    }

    public function setAdmin(?AdministradorEntity $admin): void
    {
        $this->admin = $admin;
    }

    public function getFecha(): \DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getComentario(): string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): void
    {
        $this->comentario = $comentario;
    }

}

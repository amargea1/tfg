<?php

namespace App\Entity;

use App\Repository\AdministradorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdministradorRepository::class)]
#[ORM\Table(name: "administrador")]
class AdministradorEntity extends UsuarioEntity
{

    #[ORM\ManyToMany(targetEntity: ReclamacionEntity::class, inversedBy: "admins")]
    #[ORM\JoinTable(
        name: "admin_reclamaciones",
        joinColumns: [new ORM\JoinColumn(name: "admin_id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "reclamacion_id", referencedColumnName: "id")]
    )]
    private Collection $reclamaciones;

    #[ORM\ManyToMany(targetEntity: ConsultaEntity::class, inversedBy: "admins")]
    #[ORM\JoinTable(
        name: "admin_consultas",
        joinColumns: [new ORM\JoinColumn(name: "admin_id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "consulta_id", referencedColumnName: "id")]
    )]
    private Collection $consultas;

    #[ORM\OneToMany(targetEntity: SeguimientoEntity::class, mappedBy: 'admin', cascade: ['persist', 'remove'])]
    private Collection $seguimientos;

    #[ORM\Column(type: 'string', length: 255)]
    private string $username;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $fechaCreacion;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $fechaUltimoAcceso;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "El sector es obligatorio")]
    #[Assert\Choice(choices: ['Admon. Pública', 'Banca', 'Suministros', 'Comunicaciones', 'Vivienda', 'Comercio', 'Comercio online',
        'Transportes y viajes', 'Seguros', 'Sev. Profesionales', 'Otros'], message: 'Sector inválido')]
    private ?string $especialidad = null;



    public function __construct()
    {
        $this->reclamaciones = new ArrayCollection();
        $this->consultas = new ArrayCollection();
        $this->seguimientos = new ArrayCollection();
        $this->fechaCreacion = new \DateTime(); // Se establece la fecha actual al crear el objeto.
        $this->fechaUltimoAcceso = new \DateTime();
    }

    public function getReclamaciones(): ArrayCollection
    {
        return $this->reclamaciones;
    }

    public function setReclamaciones(ArrayCollection $reclamaciones): void
    {
        $this->reclamaciones = $reclamaciones;
    }

    public function getEspecialidad(): ?string
    {
        return $this->especialidad;
    }

    public function setEspecialidad(?string $especialidad): void
    {
        $this->especialidad = $especialidad;
    }


    public function getConsultas(): Collection
    {
        return $this->consultas;
    }

    public function setConsultas(Collection $consultas): void
    {
        $this->consultas = $consultas;
    }



    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


    public function getFechaCreacion(): \DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fechaCreacion): void
    {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function getFechaUltimoAcceso(): \DateTimeInterface
    {
        return $this->fechaUltimoAcceso;
    }

    public function setFechaUltimoAcceso(\DateTimeInterface $fechaUltimoAcceso): void
    {
        $this->fechaUltimoAcceso = $fechaUltimoAcceso;
    }

    public function getSeguimientos(): Collection
    {
        return $this->seguimientos;
    }

    public function setSeguimientos(Collection $seguimientos): void
    {
        $this->seguimientos = $seguimientos;
    }

    public function addReclamacion(ReclamacionEntity $reclamacion): self
    {
        if (!$this->reclamaciones->contains($reclamacion)) {
            $this->reclamaciones[] = $reclamacion;
        }

        return $this;
    }

    public function removeReclamacion(ReclamacionEntity $reclamacion): self
    {
        $this->reclamaciones->removeElement($reclamacion);

        return $this;
    }


    public function addConsulta(ConsultaEntity $consulta): self
    {
        if (!$this->consultas->contains($consulta)) {
            $this->consultas[] = $consulta;
        }

        return $this;
    }


    public function removeConsulta(ConsultaEntity $consulta): self
    {
        $this->consultas->removeElement($consulta);

        return $this;
    }

    public function addSeguimiento(SeguimientoEntity $seguimiento): self
    {
        if (!$this->seguimientos->contains($seguimiento)) {
            $this->seguimientos[] = $seguimiento;
        }

        return $this;
    }

    public function removeSeguimiento(SeguimientoEntity $seguimiento): self
    {
        $this->seguimientos->removeElement($seguimiento);

        return $this;
    }
}

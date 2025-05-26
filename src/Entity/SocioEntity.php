<?php

namespace App\Entity;

use App\Repository\SocioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocioRepository::class)]
#[ORM\Table(name: "socio")]
class SocioEntity extends UsuarioEntity
{

    #[ORM\OneToMany(targetEntity: ConsultaEntity::class, mappedBy: "socio")]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $consultas;

    #[ORM\OneToMany(targetEntity: ReclamacionEntity::class, mappedBy: "socio")]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $reclamaciones;

    #[ORM\OneToMany(targetEntity: FamiliarEntity::class, mappedBy: "socio")]
    private Collection $familiares;

    #[ORM\ManyToOne(targetEntity: CuotaEntity::class, inversedBy: "socios")]
    private ?CuotaEntity $cuota = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $fechaRegistro;

    #[ORM\Column(type: 'integer')]
    private int $ordenRegistro;

    #[ORM\Column(length: 50)]
    #[Assert\Choice(choices: ['Jubilado', 'Cta. Ajena', 'Funcionario', 'Empresario', 'Desempleado'], message: 'Colectivo inválido')]
    private ?string $colectivo = null;

    #[ORM\Column(length: 50)]
    private ?string $numSocio = null;



    public function __construct()
    {
        $this->familiares = new ArrayCollection();
        $this->consultas = new ArrayCollection();
        $this->reclamaciones = new ArrayCollection();
        $this->fechaRegistro = new \DateTime(); // Asignar fecha actual en el constructor
    }

    public function __toString(): string
    {
        return $this->getNombre() ?? 'Socio sin nombre';
    }

    public function getConsultas(): Collection
    {
        return $this->consultas;
    }

    public function setConsultas(Collection $consultas): void
    {
        $this->consultas = $consultas;
    }

    public function getReclamaciones(): Collection
    {
        return $this->reclamaciones;
    }

    public function setReclamaciones(Collection $reclamaciones): void
    {
        $this->reclamaciones = $reclamaciones;
    }

    public function getFamiliares(): Collection
    {
        return $this->familiares;
    }

    public function setFamiliares(Collection $familiares): void
    {
        $this->familiares = $familiares;
    }

    public function getCuota(): ?CuotaEntity
    {
        return $this->cuota;
    }

    public function setCuota(?CuotaEntity $cuota): void
    {
        $this->cuota = $cuota;
    }

    public function getFechaRegistro(): \DateTimeInterface
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(\DateTimeInterface $fechaRegistro): void
    {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function getOrdenRegistro(): int
    {
        return $this->ordenRegistro;
    }

    public function setOrdenRegistro(int $ordenRegistro): void
    {
        $this->ordenRegistro = $ordenRegistro;
    }

    public function getColectivo(): ?string
    {
        return $this->colectivo;
    }

    public function setColectivo(?string $colectivo): void
    {
        $this->colectivo = $colectivo;
    }

    public function getNumSocio(): ?string
    {
        return $this->numSocio;
    }

    public function setNumSocio(?string $numSocio): void
    {
        $this->numSocio = $numSocio;
    }

    public function addConsulta(ConsultaEntity $consulta): self
    {
        if (!$this->consultas->contains($consulta)) {
            $this->consultas[] = $consulta;
        }

        return $this;
    }

    public function removeConsulta(ConsultaEntity $consulta) : self
    {
        $this->consultas->removeElement($consulta);

        return $this;
    }

    public function addReclamacion(ReclamacionEntity $reclamacion): self
    {
        if (!$this->reclamaciones->contains($reclamacion)) {
            $this->reclamaciones[] = $reclamacion;
        }

        return $this;
    }

    public function removeReclamacion(ReclamacionEntity $reclamacion) : self
    {
        $this->reclamaciones->removeElement($reclamacion);

        return $this;
    }

    public function addFamiliar(FamiliarEntity $familiar): self
    {
        if (!$this->familiares->contains($familiar)) {
            $this->familiares[] = $familiar;
        }

        return $this;
    }

    public function removeFamiliar(FamiliarEntity $familiar) : self
    {
        $this->familiares->removeElement($familiar);

        return $this;
    }

}

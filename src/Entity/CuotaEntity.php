<?php

namespace App\Entity;

use App\Repository\CuotaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CuotaRepository::class)]
#[ORM\Table(name: "cuota")]
class CuotaEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "decimal", precision: 8, scale: 2)]
    #[Assert\NotBlank(message: "El importe es obligatorio.")]
    #[Assert\Type(type: 'numeric', message: 'El importe debe ser un número válido.')]
    #[Assert\Positive(message: 'El importe debe ser un número positivo.')]
    private ?string $importe;


    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "El tipo de cuota es obligatorio.")]
    #[Assert\Choice(choices: ['socio', 'familiar'], message: 'Tipo de cuota inválida.')]
    private ?string $tipo = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "La periodicidad es obligatoria.")]
    private ?string $periodicidad = null;

    #[ORM\OneToMany(targetEntity: SocioEntity::class, mappedBy: "cuota")]
    private Collection $socios;

    #[ORM\OneToMany(targetEntity: FamiliarEntity::class, mappedBy: "cuota")]
    private Collection $familiares;

    public function __construct()
    {
        $this->socios = new ArrayCollection();
        $this->familiares = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getImporte(): ?string
    {
        return $this->importe;
    }

    public function setImporte(?string $importe): void
    {
        $this->importe = $importe;
    }


    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getPeriodicidad(): ?string
    {
        return $this->periodicidad;
    }

    public function setPeriodicidad(?string $periodicidad): void
    {
        $this->periodicidad = $periodicidad;
    }


    public function getSocios(): Collection
    {
        return $this->socios;
    }

    public function setSocios(Collection $socios): void
    {
        $this->socios = $socios;
    }

    public function getFamiliares(): Collection
    {
        return $this->familiares;
    }

    public function setFamiliares(Collection $familiares): void
    {
        $this->familiares = $familiares;
    }

    public function addFamiliar(FamiliarEntity $familiar): self
    {
        if (!$this->familiares->contains($familiar)) {
            $this->familiares[] = $familiar;
            $familiar->setCuota($this);
        }

        return $this;
    }

    public function removeFamiliar(FamiliarEntity $familiar): self
    {
        if ($this->familiares->removeElement($familiar)) {
            if ($familiar->getCuota() === $this) {
                $familiar->setCuota(null);
            }
        }
        return $this;
    }

    public function addSocio(SocioEntity $socio): self
    {
        if (!$this->socios->contains($socio)) {
            $this->socios[] = $socio;
            $socio->setCuota($this);
        }

        return $this;
    }

    public function removeSocio(SocioEntity $socio): self
    {
        if ($this->socios->removeElement($socio)) {
            if ($socio->getCuota() === $this) {
                $socio->setCuota(null);
            }
        }

        return $this;
    }
}











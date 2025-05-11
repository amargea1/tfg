<?php

namespace App\Entity;

use App\Repository\CuotaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CuotaRepository::class)]
#[ORM\Table(name: "cuota")]
class CuotaEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "decimal", precision: 8, scale: 2)]
    private ?string $importe;

    #[ORM\Column(length: 50)]
    #[Assert\Choice(choices: ['efectivo', 'bizum', 'transferencia'], message: 'Modo de pago inválido')]
    private ?string $modoPago = null;

    #[ORM\Column(length: 50)]
    #[Assert\Choice(choices: ['socio', 'familiar'], message: 'Tipo de cuota inválida')]
    private ?string $tipo = null;

    #[ORM\Column(length: 50)]
    private ?string $periodicidad = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $iban = null; //hacer condicional segun modo pago
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $bizum = null; //hacer condicional segun modo pago

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $fechaPago;

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

    public function getModoPago(): ?string
    {
        return $this->modoPago;
    }

    public function setModoPago(?string $modoPago): void
    {
        $this->modoPago = $modoPago;
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

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(?string $iban): void
    {
        $this->iban = $iban;
    }

    public function getBizum(): ?string
    {
        return $this->bizum;
    }

    public function setBizum(?string $bizum): void
    {
        $this->bizum = $bizum;
    }

    public function getFechaPago(): \DateTimeInterface
    {
        return $this->fechaPago;
    }

    public function setFechaPago(\DateTimeInterface $fechaPago): void
    {
        $this->fechaPago = $fechaPago;
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

    public function removeFamiliar(FamiliarEntity $familiar) : self
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

    public function removeSocio(SocioEntity $socio) : self
    {
        if ($this->socios->removeElement($socio)) {
            if ($socio->getCuota() === $this) {
                $socio->setCuota(null);
            }
        }

        return $this;
    }


}











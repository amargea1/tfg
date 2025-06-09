<?php

namespace App\Entity;

use App\Repository\FamiliarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FamiliarRepository::class)]
#[ORM\Table(name: "familiar")]
class FamiliarEntity extends UsuarioEntity
{

    #[ORM\ManyToOne(targetEntity: SocioEntity::class, inversedBy: "familiares")]
    #[ORM\JoinColumn(nullable: false)]
    private ?SocioEntity $socio = null;

    #[ORM\ManyToOne(targetEntity: CuotaEntity::class, inversedBy: "familiares")]
    private ?CuotaEntity $cuota = null;

    #[ORM\OneToMany(targetEntity: ConsultaEntity::class, mappedBy: "familiar")]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $consultas;

    #[ORM\OneToMany(targetEntity: ReclamacionEntity::class, mappedBy: "familiar")]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $reclamaciones;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "La relación es obligatoria")]
    #[Assert\Choice(choices: ['Hijo/a', 'Cónyuge', 'Padre', 'Madre', 'Hermano/a', 'Otro'], message: 'Relación inválida')]
    private ?string $relacion = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "El modo de pago es obligatorio")]
    #[Assert\Choice(choices: ['Efectivo', 'Bizum', 'Transferencia'], message: 'Modo de pago inválido')]
    private ?string $modoPago = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Regex(
        pattern: '/^ES\d{22}$/',
        message: 'El IBAN debe comenzar por "ES" seguido de 22 dígitos numéricos.'
    )]
    private ?string $iban = null;
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Regex(
        pattern: '/^(?:\+34|0034)?\d{9}$/',
        message: 'El número de Bizum debe ser un teléfono móvil válido de 9 dígitos, con o sin prefijo internacional.'
    )]
    private ?string $bizum = null;


    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $fechaPago;

    public function __construct()
    {
        $this->consultas = new ArrayCollection();
        $this->reclamaciones = new ArrayCollection();
    }

    public function getModoPago(): ?string
    {
        return $this->modoPago;
    }

    public function setModoPago(?string $modoPago): void
    {
        $this->modoPago = $modoPago;
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


    public function getSocio(): ?SocioEntity
    {
        return $this->socio;
    }

    public function setSocio(?SocioEntity $socio): void
    {
        $this->socio = $socio;
    }

    public function getCuota(): ?CuotaEntity
    {
        return $this->cuota;
    }

    public function setCuota(?CuotaEntity $cuota): void
    {
        $this->cuota = $cuota;
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

    public function getRelacion(): ?string
    {
        return $this->relacion;
    }

    public function setRelacion(?string $relacion): void
    {
        $this->relacion = $relacion;
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



}

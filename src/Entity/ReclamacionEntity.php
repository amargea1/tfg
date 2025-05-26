<?php

namespace App\Entity;

use App\Repository\ReclamacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamacionRepository::class)]
#[ORM\Table(name: "reclamacion")]
class ReclamacionEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: FamiliarEntity::class, inversedBy: "reclamaciones")]
    #[ORM\JoinColumn(nullable: true)]
    private ?FamiliarEntity $familiar = null;

    #[ORM\ManyToOne(targetEntity: SocioEntity::class, inversedBy: "reclamaciones")]
    #[ORM\JoinColumn(nullable: true)]
    private ?SocioEntity $socio = null;


    #[ORM\ManyToMany(targetEntity: AdministradorEntity::class, mappedBy: "reclamaciones")]
    private Collection $admins;

    #[ORM\OneToMany(targetEntity: SeguimientoEntity::class, mappedBy: "reclamacion")]
    private Collection $seguimientos;


    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $fechaApertura;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $fechaCierre = null;

    #[ORM\Column(length: 50)]
    #[Assert\Choice(choices: ['online', 'telefónica', 'presencial'], message: 'Atención inválida')]
    private ?string $atencion = null;

    #[ORM\Column(type: 'boolean')]
    private bool $esFamiliar;

    #[ORM\Column(type: 'string', length: 255)]
    private string $numeroSocio;

    #[ORM\Column(length: 50)]
    #[Assert\Choice(choices: ['Admon. Pública', 'Banca', 'Suministros', 'Comunicaciones', 'Vivienda', 'Comercio', 'Comercio online',
        'Transportes y viajes', 'Seguros', 'Sev. Profesionales', 'Otros'], message: 'Sector inválido')]
    private ?string $sector = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $asunto;

    #[ORM\Column(type: 'string', length: 255)]
    private string $reclamacion;

    #[ORM\Column(type: 'string', length: 255)]
    private string $estado;

    #[ORM\Column(length: 50)]
    #[Assert\Choice(choices: ['baja', 'media', 'alta', 'urgente'], message: 'Prioridad inválida')]
    private ?string $prioridad = null;

    public function __construct()
    {
        $this->seguimientos = new ArrayCollection();
        $this->admins = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocio(): ?SocioEntity
    {
        return $this->socio;
    }

    public function setSocio(?SocioEntity $socio): void
    {
        $this->socio = $socio;
    }

    public function getFamiliar(): ?FamiliarEntity
    {
        return $this->familiar;
    }

    public function setFamiliar(?FamiliarEntity $familiar): void
    {
        $this->familiar = $familiar;
    }

    public function getAdmins(): Collection
    {
        return $this->admins;
    }

    public function setAdmins(Collection $admins): void
    {
        $this->admins = $admins;
    }

    public function getSeguimientos(): Collection
    {
        return $this->seguimientos;
    }

    public function setSeguimientos(Collection $seguimientos): void
    {
        $this->seguimientos = $seguimientos;
    }

    public function getFechaApertura(): \DateTimeInterface
    {
        return $this->fechaApertura;
    }

    public function setFechaApertura(\DateTimeInterface $fechaApertura): void
    {
        $this->fechaApertura = $fechaApertura;
    }

    public function getFechaCierre(): ?\DateTimeInterface
    {
        return $this->fechaCierre;
    }

    public function setFechaCierre(?\DateTimeInterface $fechaCierre): void
    {
        $this->fechaCierre = $fechaCierre;
    }

    public function getAtencion(): ?string
    {
        return $this->atencion;
    }

    public function setAtencion(?string $atencion): void
    {
        $this->atencion = $atencion;
    }

    public function isEsFamiliar(): bool
    {
        return $this->esFamiliar;
    }

    public function setEsFamiliar(bool $esFamiliar): void
    {
        $this->esFamiliar = $esFamiliar;
    }

    public function getNumeroSocio(): string
    {
        return $this->numeroSocio;
    }

    public function setNumeroSocio(string $numeroSocio): void
    {
        $this->numeroSocio = $numeroSocio;
    }

    public function getSector(): ?string
    {
        return $this->sector;
    }

    public function setSector(?string $sector): void
    {
        $this->sector = $sector;
    }

    public function getAsunto(): string
    {
        return $this->asunto;
    }

    public function setAsunto(string $asunto): void
    {
        $this->asunto = $asunto;
    }

    public function getReclamacion(): string
    {
        return $this->reclamacion;
    }

    public function setReclamacion(string $reclamacion): void
    {
        $this->reclamacion = $reclamacion;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getPrioridad(): ?string
    {
        return $this->prioridad;
    }

    public function setPrioridad(?string $prioridad): void
    {
        $this->prioridad = $prioridad;
    }



    public function addSeguimiento(SeguimientoEntity $seguimiento): self
    {
        if (!$this->seguimientos->contains($seguimiento)) {
            $this->seguimientos[] = $seguimiento;
            $seguimiento->setReclamacion($this);
        }

        return $this;
    }

    public function removeSeguimiento(SeguimientoEntity $seguimiento): self
    {
        if ($this->seguimientos->removeElement($seguimiento)) {
            if ($seguimiento->getReclamacion() === $this) {
                $seguimiento->setReclamacion(null);
            }
        }

        return $this;
    }

    public function addAdmin(AdministradorEntity $admin): self
    {
    if (!$this->admins->contains($admin)) {
        $this->admins[] = $admin;
    }

    return $this;
}

    public function removeAdmin(AdministradorEntity $admin): self
    {
        $this->admins->removeElement($admin);

        return $this;
    }


}

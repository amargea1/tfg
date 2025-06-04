<?php

namespace App\Entity;

use App\Repository\ConsultaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultaRepository::class)]
#[ORM\Table(name: "consulta")]
class ConsultaEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: SocioEntity::class, inversedBy: "consultas")]
    #[ORM\JoinColumn(nullable: true)]
    private ?SocioEntity $socio = null;

    #[ORM\ManyToOne(targetEntity: FamiliarEntity::class, inversedBy: "consultas")]
    #[ORM\JoinColumn(nullable: true)]
    private ?FamiliarEntity $familiar = null;

    #[ORM\ManyToMany(targetEntity: AdministradorEntity::class, mappedBy: "consultas")]
    private Collection $admins;

    #[ORM\Column(type: 'string', length: 255)]
    private String $asunto;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $fechaApertura;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $fechaCierre = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Choice(choices: ['Pendiente', 'Resuelta'], message: 'Estado inválido')]
    private string $estado;

    #[ORM\Column(type: 'string', length: 500)]
    private String $consulta;

    #[ORM\Column(type: 'string', length: 255)]
    private String $nombre;

    #[ORM\Column(type: 'string', length: 255)]
    private String $apellidos;

    #[ORM\Column(type: 'string', length: 255)]
    private String $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $telefono = null;

    public function __construct()
    {
        $this->admins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
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


    public function getAsunto(): string
    {
        return $this->asunto;
    }

    public function setAsunto(string $asunto): void
    {
        $this->asunto = $asunto;
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



    public function getConsulta(): string
    {
        return $this->consulta;
    }

    public function setConsulta(string $consulta): void
    {
        $this->consulta = $consulta;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): void
    {
        $this->telefono = $telefono;
    }



    public function addAdmin(AdministradorEntity $admin): self
    {
        if (!$this->admins->contains($admin)) {
            $this->admins[] = $admin;
        }

        return $this;
    }

    public function removeAdmin(AdministradorEntity $admin) : self
    {
        $this->admins->removeElement($admin);

        return $this;
    }


}

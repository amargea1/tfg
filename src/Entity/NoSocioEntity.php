<?php

namespace App\Entity;

use App\Repository\NoSocioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoSocioRepository::class)]
#[ORM\Table(name: "no_socio")]
class NoSocioEntity extends UsuarioEntity
{

    #[ORM\OneToMany(targetEntity: ConsultaEntity::class, mappedBy: "noSocio")]
    private Collection $consultas;

    #[ORM\Column(length: 50)]
    #[Assert\Choice(choices: ['Jubilado', 'Cta. Ajena', 'Funcionario', 'Empresario', 'Desempleado'], message: 'Colectivo inválido')]
    private ?string $colectivo = null;

    public function __construct()
    {
        $this->consultas = new ArrayCollection();
    }

    public function getConsultas(): Collection
    {
        return $this->consultas;
    }

    public function setConsultas(Collection $consultas): void
    {
        $this->consultas = $consultas;
    }

    public function getColectivo(): ?string
    {
        return $this->colectivo;
    }

    public function setColectivo(?string $colectivo): void
    {
        $this->colectivo = $colectivo;
    }


    public function addConsulta(ConsultaEntity $consulta): self
    {
        if (!$this->consultas->contains($consulta)) {
            $this->consultas[] = $consulta;
            $consulta->setNoSocio($this);
        }

        return $this;
    }

    public function removeConsulta(ConsultaEntity $consulta) : self
    {
        if ($this->consultas->removeElement($consulta)) {
            if ($consulta->getNoSocio() === $this) {
                $consulta->setNoSocio(null);
            }
        }


        return $this;
    }


}

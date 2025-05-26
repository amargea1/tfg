<?php

namespace App\Entity;

use App\Repository\UsuarioEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "usuario")]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "tipo_usuario", type: "string")] //Esta columna llamada "tipo" se usará en la tabla usuario para saber qué tipo exacto de objeto es cada fila.
//Por ejemplo: "socio", "familiar" o "no_socio".
#[ORM\DiscriminatorMap([
    "socio" => SocioEntity::class,
    "familiar" => FamiliarEntity::class,
    "no_socio" => NoSocioEntity::class,
    "admin" => AdministradorEntity::class
])]
abstract class UsuarioEntity
{

    //No pongo relaciones: Porque Usuario es una clase abstracta y no tiene relaciones directas. Las relaciones las tienen sus hijas
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\Choice(choices: ['ROLE_ADMIN', 'ROLE_SUPERADMIN'], message: 'Rol inválido')]
    private ?string $rol = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nombre;

    #[ORM\Column(type: 'string', length: 255)]
    private string $apellidos;

    #[ORM\Column(type: 'string', length: 255)]
    private string $dni;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $fechaNacimiento;

    #[ORM\Column(length: 20)]
    #[Assert\Choice(choices: ['Hombre', 'Mujer', 'Indeterminado'], message: 'Sexo inválido')]
    private ?string $sexo = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $direccion;

    #[ORM\Column(type: 'string', length: 255)]
    private string $localidad;

    #[ORM\Column(type: 'string', length: 255)]
    private string $provincia;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $codigoPostal = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $telefono;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRolAdmin(): ?string
    {
        return $this->rol;
    }

    public function setRolAdmin(?string $rol): void
    {
        $this->rol = $rol;
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

    public function getDni(): string
    {
        return $this->dni;
    }

    public function setDni(string $dni): void
    {
        $this->dni = $dni;
    }

    public function getFechaNacimiento(): \DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): void
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function getSexo(): ?string
    {
        return $this->sexo;
    }

    public function setSexo(?string $sexo): void
    {
        $this->sexo = $sexo;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    public function getLocalidad(): string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): void
    {
        $this->localidad = $localidad;
    }

    public function getProvincia(): string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): void
    {
        $this->provincia = $provincia;
    }

    public function getCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(?string $codigoPostal): void
    {
        $this->codigoPostal = $codigoPostal;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }




}

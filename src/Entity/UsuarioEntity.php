<?php

namespace App\Entity;

use App\Repository\UsuarioEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "usuario")]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "tipo_usuario", type: "string")] //Esta columna llamada "tipo" se usará en la tabla usuario para saber qué tipo exacto de objeto es cada fila.
//Por ejemplo: "socio", "familiar" o "no_socio".
#[ORM\DiscriminatorMap([
    "socio" => SocioEntity::class,
    "familiar" => FamiliarEntity::class,
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
    #[Assert\NotBlank(message: 'El nombre es obligatorio')]
    #[Assert\Length(min: 2, max: 255)]
    #[Assert\Regex(
        pattern: '/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u',
        message: 'El nombre solo puede contener letras y espacios'
    )]
    private string $nombre;


    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Los apellidos son obligatorios')]
    #[Assert\Length(min: 2, max: 255)]
    #[Assert\Regex(
        pattern: '/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u',
        message: 'Los apellidos solo pueden contener letras y espacios'
    )]
    private string $apellidos;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'El DNI es obligatorio')]
    #[Assert\Regex(
        pattern: '/^[0-9]{8}[A-Za-z]$/',
        message: 'El DNI debe tener 8 números seguidos de una letra'
    )]
    private string $dni;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull(message: 'La fecha de nacimiento es obligatoria')]
    #[Assert\LessThan('today', message: 'La fecha de nacimiento debe ser anterior al día actual')]
    private \DateTimeInterface $fechaNacimiento;

    #[ORM\Column(length: 20)]
    #[Assert\Choice(choices: ['Hombre', 'Mujer', 'Indeterminado'], message: 'Sexo inválido')]
    private ?string $sexo = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'La dirección es obligatoria')]
    private string $direccion;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'La localidad es obligatoria')]
    private string $localidad;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'La provincia es obligatoria')]
    private string $provincia;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Regex(
        pattern: '/^\d{5}$/',
        message: 'El código postal debe tener 5 dígitos'
    )]
    private ?string $codigoPostal = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'El teléfono es obligatorio')]
    #[Assert\Regex(
        pattern: '/^(?:\+34|0034)?\d{9}$/',
        message: 'El teléfono debe ser un número válido español de 9 dígitos, con o sin prefijo internacional'
    )]
    private string $telefono;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "El email es obligatorio")]
    #[Assert\Email(message: "El email '{{ value }}' no es válido")]
    #[Assert\Length(
        max: 255,
        maxMessage: "El email no puede tener más de {{ limit }} caracteres"
    )]
    #[Assert\Regex(
        pattern: "/^[^@\s]+@(?:hotmail\.com|gmail\.com|outlook\.com|yahoo\.com)$/i",
        message: "El email debe pertenecer a dominios válidos: hotmail.com, gmail.com, outlook.com o yahoo.com"
    )]
    private string $email;

    #[ORM\Column(type: 'boolean')]
    private bool $estaActivo;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(?string $rol): void
    {
        $this->rol = $rol;
    }

    public function isEstaActivo(): bool
    {
        return $this->estaActivo;
    }

    public function setEstaActivo(bool $estaActivo): void
    {
        $this->estaActivo = $estaActivo;
    }
}

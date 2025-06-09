<?php

namespace App\Form;

use App\Entity\AdministradorEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rol')
            ->add('nombre')
            ->add('apellidos')
            ->add('dni')
            ->add('fechaNacimiento')
            ->add('sexo')
            ->add('direccion')
            ->add('localidad')
            ->add('provincia')
            ->add('codigoPostal')
            ->add('telefono')
            ->add('email')
            ->add('estaActivo')
            ->add('username')
            ->add('password')
            ->add('fechaCreacion')
            ->add('fechaUltimoAcceso')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdministradorEntity::class,
        ]);
    }
}

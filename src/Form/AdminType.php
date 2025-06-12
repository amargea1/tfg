<?php

namespace App\Form;

use App\Entity\AdministradorEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['mostrar_rol']) {
            $builder->add('rol', ChoiceType::class, [
                'choices' => [
                    'ROLE_SUPERADMIN' => 'ROLE_SUPERADMIN',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                ],
                'placeholder' => 'Seleccionar rol',
            ]);
        }

        $builder
            ->add('nombre')
            ->add('apellidos')
            ->add('dni')
            ->add('fechaNacimiento', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('sexo', ChoiceType::class, [
                'choices' => [
                    'Hombre' => 'Hombre',
                    'Mujer' => 'Mujer',
                    'Indeterminado' => 'Indeterminado',

                ],
                'placeholder' => 'Seleccionar sexo',
            ])
            ->add('direccion')
            ->add('localidad')
            ->add('provincia')
            ->add('codigoPostal')
            ->add('telefono')
            ->add('email')
            ->add('username')
            ;
            if ($options['mostrar_fecha_creacion']) {
                $builder->add('fechaCreacion', DateType::class, [
                    'widget' => 'single_text',
                    'html5' => true,
                    'disabled' => true,
                ]);
            }

        if ($options['mostrar_password']) {
        $builder->add('password', PasswordType::class, [
        'label' => 'Contraseña',
        'required' => true,
        ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdministradorEntity::class,
            'mostrar_rol' => true,
            'mostrar_fecha_creacion' => true,
            'mostrar_password' => true,
        ]);
    }
}

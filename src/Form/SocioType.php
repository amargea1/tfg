<?php

namespace App\Form;

use App\Entity\SocioEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            ->add('fechaRegistro', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'disabled' => true,
            ])
            ->add('ordenRegistro', null, [
                'label' => 'Orden registro',
                'disabled' => true,
            ])
            ->add('colectivo', ChoiceType::class, [
                'choices' => [
                    'Jubilado' => 'Jubilado',
                    'Cta. Ajena' => 'Cta. Ajena',
                    'Funcionario' => 'Funcionario',
                    'Empresario' => 'Empresario',
                    'Desempleado' => 'Desempleado',

                ],
                'placeholder' => 'Seleccionar colectivo',
            ])
            ->add('numSocio', null, [
                'label' => 'Número de socio',
                'disabled' => true,
            ])

            ->add('modoPago', ChoiceType::class, [
                'choices' => [
                    'Efectivo' => 'efectivo',
                    'Bizum' => 'bizum',
                    'Transferencia' => 'transferencia'
                ],
                'placeholder' => 'Seleccionar forma de pago',
            ])
            ->add('iban')
            ->add('bizum')
            ->add('fechaPago', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SocioEntity::class,
        ]);
    }
}

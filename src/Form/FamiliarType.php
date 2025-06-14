<?php

namespace App\Form;

use App\Entity\FamiliarEntity;
use App\Entity\SocioEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FamiliarType extends AbstractType
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
                'placeholder' => 'Sexo del familiar',
            ])
            ->add('direccion')
            ->add('localidad')
            ->add('provincia')
            ->add('codigoPostal')
            ->add('telefono')
            ->add('email')
            ->add('relacion', ChoiceType::class, [
                'choices' => [
                    'Hijo/a' => 'Hijo/a',
                    'Cónyuge' => 'Cónyuge',
                    'Padre' => 'Padre',
                    'Madre' => 'Madre',
                    'Hermano/a' => 'Hermano/a',
                    'Otro' => 'Otro',

                ],
                'placeholder' => 'Relación con el socio',
            ])
            ->add('socio', EntityType::class, [
                'class' => SocioEntity::class,
                'choice_label' => function ($socio) {
                    return $socio->getNombre() . ' ' . $socio->getApellidos();
                },

                'label' => 'Socio',
                'placeholder' => 'Selecciona un socio',
                'attr' => [
                    'class' => 'js-socio-select',
                ],
            ])
            ->add('modoPago', ChoiceType::class, [
                'choices' => [
                    'Efectivo' => 'Efectivo',
                    'Bizum' => 'Bizum',
                    'Transferencia' => 'Transferencia',

                ],
                'placeholder' => 'Elegir modo de pago',
            ])
            ->add('iban')
            ->add('bizum')
            ->add('fechaPago', DateType::class, [
                'data' => new \DateTimeImmutable(),
                'widget' => 'single_text',
                'html5' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FamiliarEntity::class,
        ]);
    }
}

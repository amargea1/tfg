<?php

namespace App\Form;

use App\Entity\FamiliarEntity;
use App\Entity\ReclamacionEntity;
use App\Entity\SocioEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fechaApertura', DateType::class, [
                'widget' => 'single_text',
                'data' => new \DateTimeImmutable(),
                'html5' => true,
            ])
            ->add('atencion', ChoiceType::class, [
                'choices' => [
                    'Online' => 'online',
                    'Telefónica' => 'telefónica',
                    'Presencial' => 'presencial',
                ],
                'placeholder' => 'Tipo de atención',
            ])
            ->add('socio', EntityType::class, [
                'class' => SocioEntity::class,
                'choice_label' => function ($socio) {
                    return $socio->getNombre() . ' ' . $socio->getApellidos();
                },

                'label' => 'Socio',
                'required' => false,
                'placeholder' => 'Selecciona un socio',
                'attr' => [
                    'class' => 'js-socio-select',
                ],

            ])
            ->add('esFamiliar', CheckboxType::class, [
                'label' => '¿Es familiar?',
                'required' => false,
                'mapped' => false,
            ])
            ->add('familiar', EntityType::class, [
                'class' => FamiliarEntity::class,
                'choice_label' => function ($familiar) {
                    return $familiar->getNombre() . ' ' . $familiar->getApellidos();
                },
                'label' => 'Nombre del familiar',
                'placeholder' => 'Selecciona un familiar',
                'required' => false,
                'attr' => [
                    'class' => 'js-familiar-select',
                ],
            ])
            ->add('sector', ChoiceType::class, [
                'choices' => [
                    'Admon. Pública' => 'Admon. Pública',
                    'Banca' => 'Banca',
                    'Suministros' => 'Suministros',
                    'Comunicaciones' => 'Comunicaciones',
                    'Vivienda' => 'Vivienda',
                    'Comercio' => 'Comercio',
                    'Comercio online' => 'Comercio online',
                    'Transportes y viajes' => 'Transportes y viajes',
                    'Seguros' => 'Seguros',
                    'Sev. Profesionales' => 'Sev. Profesionales',
                    'Otros' => 'Otros'
                ],
                'placeholder' => 'Sector al que pertenece',
            ])
            ->add('prioridad', ChoiceType::class, [
                'choices' => [
                    'Baja' => 'Baja',
                    'Media' => 'Media',
                    'Alta' => 'Alta',
                    'Urgente' => 'Urgente',
                ],
                'placeholder' => 'Nivel de prioridad',
            ])
            ->add('asunto')
            ->add('reclamacion', TextareaType::class, [
                'label' => 'Reclamación',
                'required' => true,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReclamacionEntity::class,
        ]);
    }
}

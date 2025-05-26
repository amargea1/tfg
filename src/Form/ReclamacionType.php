<?php

namespace App\Form;

use App\Entity\ReclamacionEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fechaApertura', DateType::class, [
                'widget' => 'single_text', // muestra un <input type="date">
                'data' => new \DateTimeImmutable(), // fecha actual por defecto
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
            ->add('numeroSocio', TextType::class, [
                'mapped' => false,  // NO está mapeado a la entidad, solo para buscar
                'label' => 'Número de Socio',
            ])

            ->add('esFamiliar', CheckboxType::class, [
                'label' => '¿Es familiar?',
                'required' => false,
                'mapped' => false,
            ])
            ->add('familiar', FamiliarType::class, [
                'label' => false,
                'required' => false,
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
                    'Baja' => 'baja',
                    'Media' => 'media',
                    'Alta' => 'alta',
                    'Urgente' => 'urgente',
                ],
                'placeholder' => 'Nivel de prioridad',
            ])
            ->add('asunto')
            ->add('reclamacion')
            ->add('submit', SubmitType::class, [
                'label' => 'Enviar reclamación',
                'attr' => ['class' => 'btn btn-primary']
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReclamacionEntity::class,
        ]);
    }
}

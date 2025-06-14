<?php

namespace App\Form;

use App\Entity\SocioEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('modoPago', ChoiceType::class, [
                'choices' => [
                    'Efectivo' => 'efectivo',
                    'Bizum' => 'bizum',
                    'Transferencia' => 'transferencia'
                ],
                'placeholder' => 'Seleccionar forma de pago',
                'required' => true,
            ])
            ->add('iban', TextType::class, [
                'required' => false,
            ])
            ->add('bizum', TextType::class, [
                'required' => false,
            ])

            ->add('fechaPago', DateType::class, [
                'widget' => 'single_text',
                'data' => new \DateTimeImmutable(),
                'html5' => true,
                'label' => 'Fecha de pago',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SocioEntity::class,
        ]);
    }
}

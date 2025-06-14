<?php

namespace App\Form;

use App\Entity\CuotaEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class CuotaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('importe', MoneyType::class, [
                'currency' => 'EUR',
                'scale' => 2,
                'label' => 'Importe',
            ])
            ->add('tipo', ChoiceType::class, [
                'choices' => [
                    'Socio' => 'socio',
                    'Familiar' => 'familiar',
                ],
                'label' => 'Tipo de cuota',
                'placeholder' => 'Seleccione un tipo',
            ])
            ->add('periodicidad');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CuotaEntity::class,
        ]);
    }
}

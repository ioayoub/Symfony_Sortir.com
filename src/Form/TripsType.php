<?php

namespace App\Form;

use App\Entity\Trips;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TripsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('dateStart', DateTimeType::class, [
                'data' => new \DateTime('now + 4 hours'),
            ])
            ->add('duration', ChoiceType::class, [
                'choices' => [
                    '30' => '30',
                    '60' => '60',
                    '90' => '90',
                    '120' => '120',
                    '180' => '180',
                    '240' => '240'
                ]
            ])

            ->add('limitRegisterDate', DateType::class, [
                'data' => new \DateTime('now'),
            ])
            ->add('maxRegistrations')
            ->add('tripInformations', TextareaType::class, [
                'label' => 'Description'
                // ])
                // ->add('state', EntityType::class, [
                //     'class' => 'App\Entity\State',
                //     'choice_label' => 'name',
                //     'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trips::class,
        ]);
    }
}

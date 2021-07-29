<?php

namespace App\Form;

use App\Entity\Trips;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TripsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('dateStart')
            ->add('duration')
            ->add('limitRegisterDate')
            ->add('maxRegistrations')
            ->add('tripInformations')
            ->add('state', EntityType::class, [
                'class' => 'App\Entity\State',
                'choice_label' => 'name',
                'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trips::class,
        ]);
    }
}

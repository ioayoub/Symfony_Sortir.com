<?php

namespace App\Form;

use App\Entity\TripSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class TripSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('campusSearch', EntityType::class, [
                'class' => \App\Entity\Campus::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false,
                'label' => 'Campus',
            ])
            ->add('manualSearch', TextType::class, [
                'label' => 'Le nom de la sortie contient',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Recherche',
                ]
            ])
            ->add('startDateSearch', DateTimeType::class, [
                'label' => 'Entre',
                'required' => false,
                'data' => new \DateTime('now + 2 hours'),
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Entre',
                ]



            ])
            ->add('endDateSearch', DateTimeType::class, [
                'label' => 'et',
                'required' => false,
                'data' => new \DateTime('now + 1 day + 2 hours'),
                'widget' => 'single_text',

            ])
            ->add('isOrganizerSearch', CheckboxType::class, [
                'label' => 'Sorties dont je suis l\'organisateur/trice.',
                'required' => false,
                'mapped' => false
            ])
            ->add('isSubscribedSearch', CheckboxType::class, [
                'label' => 'Sorties auxquelles inscrit/e.',
                'required' => false,
                'mapped' => false
            ])
            ->add('isNotSubscribedSearch', CheckboxType::class, [
                'label' => 'Sorties auxquelles je ne suis pas inscrit/e.',
                'required' => false,
                'mapped' => false
            ])
            ->add('isOutdatedSearch', CheckboxType::class, [
                'label' => 'Sorties passées.',
                'required' => false,
                'mapped' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TripSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}

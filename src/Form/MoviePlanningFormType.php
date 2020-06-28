<?php

namespace App\Form;

use App\Entity\MoviePlanning;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MoviePlanningFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startingTime')
            ->add('endingTime')
            ->add('planning')
            ->add('movie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MoviePlanning::class,
        ]);
    }
}

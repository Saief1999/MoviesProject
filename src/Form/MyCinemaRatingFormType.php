<?php

namespace App\Form;

use App\Entity\CinemaRating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyCinemaRatingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rating', \Brokoskokoli\StarRatingBundle\Form\StarRatingType::class,
                [
                    'label' => false,
                    'required' => true,
                    'stars' => 5,
                ]
            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CinemaRating::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\RegisteredUser;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisteredUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',RegistrationFormType::class)
            ->add('favoriteGenres',EntityType::class,
                ['class'=>'App\Entity\MovieGenre',
                    'choice_label'=>'name',
                    'multiple'=>true,
                    'expanded'=>false,
                    'attr'=>[
                    'class'=> 'selectpicker',
                    'data-live-search'=> 'true'
                    ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegisteredUser::class,
            'cascade_validation' => true
        ]);


    }
}

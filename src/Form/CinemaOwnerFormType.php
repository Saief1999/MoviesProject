<?php

namespace App\Form;

use App\Entity\CinemaOwner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CinemaOwnerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',RegistrationFormType::class)
            ->add('cinema',CinemaFormType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CinemaOwner::class,
        ]);
    }
}

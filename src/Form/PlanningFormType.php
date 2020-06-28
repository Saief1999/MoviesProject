<?php

namespace App\Form;

use App\Entity\Planning;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanningFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startingDate', \Symfony\Component\Form\Extension\Core\Type\DateType::class,[
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'years' => range(date("Y")-1,date("Y")+3),
                ])
            ->add("Add",SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Planning::class,
        ]);
    }
}

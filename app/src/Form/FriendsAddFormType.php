<?php

namespace App\Form;

use App\Entity\Friends;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FriendsAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        dd($options['choices']);
        $builder
            ->add(
                'email',
                ChoiceType::class,
                [
                    'choices'  => [
                        'Maybe' => 3,
                        'Yes' => 4,
                        'No' => 5,
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Friends::class,
            'choices' => [],
        ]);
    }
}

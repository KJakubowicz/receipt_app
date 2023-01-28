<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                TextType::class,
                [
                    'row_attr' => [
                        'class' => 'input-box',
                    ],
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'e-mail',
                        'class' => 'input-area'
                    ],
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'row_attr' => [
                        'class' => 'input-box',
                    ],
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'hasło',
                        'class' => 'input-area'
                    ]
                ]
            )
            ->add(
                '_csrf_token',
                HiddenType::class
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'row_attr' => [
                        'class' => 'submit-box',
                    ],
                    'label' => 'Zaloguj się',
                    'attr' => [
                        'class' => 'submit-button hover'
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

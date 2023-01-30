<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegistrationFormType extends AbstractType
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
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'row_attr' => [
                    'class' => 'checkbox-content',
                ],
                'attr' => [
                    'class' => 'input-checkbox'
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'label' => false,
                'row_attr' => [
                    'class' => 'input-box',
                ],
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => 'hasło',
                    'class' => 'input-area'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add(
                'save',
                SubmitType::class,
                [
                    'row_attr' => [
                        'class' => 'submit-box',
                    ],
                    'label' => 'Zarejestruj się',
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
            'data_class' => User::class,
        ]);
    }
}

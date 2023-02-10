<?php

namespace App\Form;

use App\Entity\Friends;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FriendsAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'id_user',
                ChoiceType::class,
                [
                    'choices' => $options['choices'],
                    'label' => 'Wybierz znajomego',
                    'required' => true,
                    'row_attr' => [
                        'class' => 'select-box',
                    ],
                ]
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'row_attr' => [
                        'class' => 'submit-box',
                    ],
                    'label' => 'Dodaj znajomego',
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
            'data_class' => Friends::class,
            'choices' => [],
        ]);
    }
}

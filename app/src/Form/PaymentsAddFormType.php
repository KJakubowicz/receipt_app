<?php

namespace App\Form;

use App\Entity\Payments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PaymentsAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nazwa płatności',
                    'required' => true,
                    'row_attr' => [
                        'class' => 'basic-box',
                    ],
                ]
            )
            ->add(
                'price',
                NumberType::class,
                [
                    'label' => 'Koszt',
                    'required' => true,
                    'row_attr' => [
                        'class' => 'basic-box',
                    ],
                ]
            )
            ->add(
                'id_friend',
                ChoiceType::class,
                [
                    'choices' => $options['choices'],
                    'label' => 'Wybierz znajomego',
                    'required' => true,
                    'row_attr' => [
                        'class' => 'select-box',
                        'data-controller' => 'select'
                    ],
                ]
            )
            ->add(
                'status',
                CheckboxType::class,
                [
                    'mapped' => true,
                    'row_attr' => [
                        'class' => 'checkbox-content',
                    ],
                    'attr' => [
                        'class' => 'input-checkbox'
                    ],
                    'required' => false
                ]
            )->add(
                'save',
                SubmitType::class,
                [
                    'row_attr' => [
                        'class' => 'submit-box',
                    ],
                    'label' => 'Dodaj płatność',
                    'attr' => [
                        'class' => 'submit-button hover'
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payments::class,
            'choices' => [],
        ]);
    }
}

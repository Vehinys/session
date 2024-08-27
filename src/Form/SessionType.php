<?php

namespace App\Form;


use App\Entity\Unit;
use App\Entity\Session;
use App\Entity\Trainee;
use App\Entity\Programme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control text-uppercase',
                    'minlength' => 2,
                    'maxlength' => 100,
                    'placeholder' => 'Entrez votre session'
                ],
                'label' => 'nom de la session',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('start_session', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control', 
                ],
                'label' => 'Début de la session',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])

            ->add('end_session', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control', 
                ],
                'label' => 'fin de la session',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])

            ->add('nb_places', IntegerType::class, [
                'label' => 'Nombre de places',
                'attr' => [
                    'class' => 'form-control', 
                ],
            ])

            ->add('nb_places_reserved', IntegerType::class, [
                'label' => 'Nombre de places réservées',
                'attr' => [
                    'class' => 'form-control', 
                ],
            ])

            ->add('trainees', EntityType::class, [
                'class' => Trainee::class,
                'attr' => [
                    'class' => 'form-control', 
                ],
                'choice_label' => function (Trainee $trainee) {
                    return $trainee->getName() . ' ' . $trainee->getFirstName();
                },
                'multiple' => true,
                'expanded' => false
            ])

            // ->add('programmes', EntityType::class, [
            //     'class' => Unit::class,
            //     'attr' => [
            //         'class' => 'form-control', 
            //     ],
            //     'choice_label' => function (Unit $unit) {
            //         return $unit->getName();
            //     },
            //     'multiple' => true,
            //     'expanded' => false
            // ])

            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}

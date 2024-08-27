<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Trainee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints as Assert;

class TraineeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control text-uppercase',
                    'minlength' => 2,
                    'maxlength' => 100,
                    'placeholder' => 'Entrez votre nom'
                ],
                'label' => 'nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('first_name', TextType::class, [
                'attr' => [
                    'class' => 'form-control tex-lowercase',
                    'minlength' => 1,
                    'maxlength' => 100,
                    'placeholder' => 'Entrez votre prénom'
                ],
                'label' => 'prénom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 1, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('sex', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control', 
                ],
                'choices' => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                ],
                'label' => 'Sexe',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])

            ->add('date_birth', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control', 
                ],
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])

            ->add('town', TextType::class, [
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    'minlength' => 1,
                    'maxlength' => 100
                ],
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => 60,
                    'placeholder' => 'Entrez le nom de la ville'
                ],
                'constraints' => [
                    new Assert\NotBlank([
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\'\-]+$/u',
                    ]),
                    new Assert\Length([
                        'min' => 1,
                        'max' => 60,
                    ]),
                ],
            ])

            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control', 
                    'minlength' => 2,
                    'maxlength' => 180
                ],
                'label' => 'Adresse email',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 180]),
                    new Assert\Email(),
                    new Assert\NotBlank()
                ]
            ])

            ->add('telephone', TextType::class, [
        
                'attr' => [
                    'class' => 'form-control', 
                    'minlength' => 9,
                    'maxlength' => 15,  
                    'pattern' => '^[\d\s\+\-\(\)]*$',
                    'inputmode' => 'tel', 
                    'placeholder' => 'Ex: +33 6 12 34 56 78'
                ],
                'label' => 'Téléphone',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank([
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[\d\s\+\-\(\)]{10,15}$/',
                        'message' => 'Veuillez entrer un numéro de téléphone valide.'
                    ]),
                    new Assert\Length(['min' => 9,'max' => 15]),
                ],
            ])

            ->add('sessions', EntityType::class, [
                'class' => Session::class,
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Sessions',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
            ])


            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
                'label' => 'Valider',
            ])
        
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trainee::class,
        ]);
    }
}

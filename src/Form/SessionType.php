<?php

namespace App\Form;


use App\Entity\Unit;
use App\Entity\Session;
use App\Entity\Trainee;
use App\Form\ProgrammeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
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

            ->add('programmes', CollectionType::class, [
                // La collection attend l'élément qu'elle entrera dans le form
                //Ce n'est pas obligatoire que ce soit un autre form
                'entry_type' => ProgrammeType::class,
                'prototype'  => true,
                // Autoriser l'ajout de nouveau élément dans Session 
                // qui seront persister grace au cascade persist sur l'element programme  
                // et qu'il va activer un data prototype qui sera un attribut HTML qu'on pourra manipuler en JS
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false, // Il est obligatoire car Session n'a pas de SetProgramme mais c'est Programme qui contient setSession
                // c'est Programme qui est propriétaire de la relation
                // pour eviter un mapping false on est obligé de rajouter un by_reference

            ])

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

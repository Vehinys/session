<?php

namespace App\Form;

use App\Entity\Programme;
use App\Entity\Session;
use App\Entity\Unit;
use PhpParser\Node\Name;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('session', HiddenType::class)

            ->add('unit', EntityType::class, [
                'label'=> 'Module',
                'class' => Unit::class,
                'Choice_label'=> 'name'
            ])

            ->add('nb_days',IntegerType::class,[
                'label' => 'Durée en jour(s)',
                'attr' => [
                    'min' => 1,
                    'max'=> 100]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}

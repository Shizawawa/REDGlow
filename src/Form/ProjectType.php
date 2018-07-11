<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\User;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', TextType::class, array('label'=>'Nom du projet'))
            ->add('description', TextareaType::class, array('attr'=>array('row'=>10)))
            ->add('users', EntityType::class, array(
                'placeholder' => 'Choix des participants',
                'multiple' => true,
                'expanded' => true,
                'class' => User::class,
                'choice_label' => function ($user) {
                    return $user->getUsername();
                }
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}

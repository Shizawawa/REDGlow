<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label'=>'Nom de la tâche'))
            ->add('description', TextareaType::class, array('attr'=>array('row'=>10)))
            ->add('start_at', DateType::class, array('label'=>'Début de la tâche'))
            ->add('planned_end_at', DateType::class, array('label'=>'Fin théorique de la tâche'))
            ->add('contributor', EntityType::class, array(
                'class' => User::class,
                'placeholder' => 'Choisir un ou plusieurs contributeur',
                'choice_label' => 'username',
                'multiple' => true))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}

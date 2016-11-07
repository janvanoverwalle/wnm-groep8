<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ChooseHabitsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('habit1', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:Habit',

                // use the User.username property as the visible option string
                'choice_label' => 'description',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
                'label' => 'Habit 1',
            ))
            ->add('habit2', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:Habit',

                // use the User.username property as the visible option string
                'choice_label' => 'description',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
                'label' => 'Habit 2',
            ))
            ->add('habit3', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle:Habit',

                // use the User.username property as the visible option string
                'choice_label' => 'description',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
                'label' => 'Habit 3',
            ))
            ->add('save', SubmitType::class, array(
                'label'  => 'Opslaan',
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null
        ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}

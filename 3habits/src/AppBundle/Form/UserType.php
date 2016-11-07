<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Naam',
                'attr'   =>  array(
                    'class'   => 'form-group')
            ))
            ->add('surname', TextType::class, array(
                'label' => 'Achternaam',
                'attr'   =>  array(
                    'class'   => 'form-group')
            ))
            ->add('username', TextType::class, array(
                'label' => 'Gebruikersnaam',
                'disabled' => true,
                'attr'   =>  array(
                    'class'   => 'form-group')
            ))
            ->add('email', TextType::class, array(
                'label' => 'E-mail',
                'attr'   =>  array(
                    'class'   => 'form-group')
            ))
            //->add('roles')
            ->add('role', ChoiceType::class, array(
                'choices' => array(
                    'Gebruiker' => 'ROLE_USER',
                    'Coach' => 'ROLE_COACH',
                    'Admin' => 'ROLE_ADMIN',
                ),
                'mapped' => false,
                'data' => $builder->getData()->getHighestRole(),
                'attr'   =>  array(
                    'class'   => 'form-group')
            ))
            ->add('enabled', CheckboxType::class, array(
                'label' => 'Actief',
                'attr'   =>  array(
                    'class'   => 'form-group')
            ))
            ->add('save', SubmitType::class, array(
                'label'  => 'Opslaan',
                'attr'   =>  array(
                    'class'   => 'btn btn-primary')
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}

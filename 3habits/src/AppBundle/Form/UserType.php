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
                'label' => 'Naam'
            ))
            ->add('surname', TextType::class, array(
                'label' => 'Achternaam'
            ))
            ->add('username', TextType::class, array(
                'label' => 'Gebruikersnaam',
                'disabled' => true
            ))
            ->add('email', TextType::class, array(
                'label' => 'E-mail'
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
            ))
            ->add('enabled', CheckboxType::class, array(
                'label' => 'Actief'
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

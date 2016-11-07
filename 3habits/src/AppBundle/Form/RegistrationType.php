<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType
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
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Paswoord'),
                'second_options' => array('label' => 'Herhaal paswoord'),
                'invalid_message' => 'Paswoorden zijn niet hetzelfde',
            ))
            ->add('email', TextType::class, array(
                'label' => 'E-mail'
            ))
            ->add('role', ChoiceType::class, array(
                'choices' => array(
                    'Gebruiker' => 'ROLE_USER',
                    'Coach' => 'ROLE_COACH',
                    'Admin' => 'ROLE_ADMIN',
                ),
                'mapped' => false,
            ))
            ->add('enabled', CheckboxType::class, array(
                'label' => 'Actief'
            ))
            ->add('save', SubmitType::class, array(
                'label'  => 'Toevoegen',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'allow_extra_fields' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }


}

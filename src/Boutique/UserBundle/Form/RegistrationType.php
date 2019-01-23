<?php

namespace Boutique\UserBundle\Form ;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class,array('label' => 'user.name'))
            ->add('prenom', TextType::class, array('label' => 'user.fname'))
            ->add('adresse', TextType::class, array('label' => 'user.address'))
            ->add('ville', TextType::class, array('label' => 'user.city'))
            ->add('codePostal', TextType::class, array('label' => 'user.zipcode')
            );
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'boutique_user_registration';
    }
}

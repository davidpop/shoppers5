<?php

namespace Boutique\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom',array('label' => 'user.name'))
            ->add('prenom',array('label' => 'user.fname'))
            ->add('adresse', array('label' => 'user.address'))
            ->add('ville', array('label' => 'user.city'))
            ->add('codePostal', array('label' => 'user.zipcode')
            );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Boutique\UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'boutique_userbundle_user';
    }


}

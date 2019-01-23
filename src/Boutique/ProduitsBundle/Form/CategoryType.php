<?php

namespace Boutique\ProduitsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class,
                array(
                    'label' => 'category.name',
                    'required' => true,
                    'constraints' => array(
                            new Length(array('min' => 3))
                            )
                    )
                )
            ->add('trad', TextType::class,
                array(
                    'label' => 'category.nameEn',
                    'required' => true,
                    'constraints' => array(
                        new Length(array('min' => 3))
                    )
                )
            )
            ->add('description', TextareaType::class,
                array(
                    'label' => 'category.description',
                    'required'=>false
                )
            );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Boutique\ProduitsBundle\Entity\Category'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'boutique_produitsbundle_category';
    }


}

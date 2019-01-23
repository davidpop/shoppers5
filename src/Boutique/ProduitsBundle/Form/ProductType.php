<?php

namespace Boutique\ProduitsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class,
                        array(
                            'required' => true,
                            'label' => 'product.name',
                            'constraints' => array(new Length(array('min' => 3)))
                        )
                )
            ->add('description', TextType::class,
                        array('label' => 'product.description')
            )
            ->add('categorys',null, array('label' => 'product.categories'))
            ->add('prix', MoneyType::class, array('label' => 'product.price'))
            ->add('quantite',IntegerType::class,
                array('label' => 'product.qte','constraints' => array(new Length(array('min' => 1)))))
            ->add('photoPrincipale', PhotoPrincipaleType::class,
                array('label' => 'product.imgMain')
                )
            ->add('images', CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'entry_options' => array('label' => false),
                    'allow_add' => true
                ])

            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Boutique\ProduitsBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'boutique_produitsbundle_product';
    }


}

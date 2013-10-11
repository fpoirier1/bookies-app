<?php

namespace Bookies\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt')
            ->add('customerName')
            ->add('customerFirstname')
            ->add('customerAddress')
            ->add('total')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bookies\CoreBundle\Entity\Order'
        ));
    }

    public function getName()
    {
        return 'bookies_corebundle_ordertype';
    }
}

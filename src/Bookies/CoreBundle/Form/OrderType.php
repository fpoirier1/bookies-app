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
            ->add('customerName')
            ->add('customerAddress')
            ->add('lines', 'collection', array(
                'type' => new OrderLineType(),
                'allow_add' => true,
                'by_reference' => false)
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bookies\CoreBundle\Entity\Order',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return 'order';
    }
}

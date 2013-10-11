<?php

namespace Bookies\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('unitCost')
            ->add('order')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bookies\CoreBundle\Entity\OrderLine'
        ));
    }

    public function getName()
    {
        return 'bookies_corebundle_orderlinetype';
    }
}

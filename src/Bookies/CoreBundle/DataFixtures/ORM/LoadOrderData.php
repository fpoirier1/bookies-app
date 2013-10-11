<?php

namespace Bookies\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Bookies\CoreBundle\Entity\Order;
use Bookies\CoreBundle\Entity\OrderLine;

class LoadOrderData implements FixtureInterface {

    public function load( ObjectManager $manager ) {
        // Load un produit
        $product1 = $manager->getRepository("BookiesCoreBundle:Product")->find(1);
        
        // Creation d'une ligne de facture
        $orderLine1 = new OrderLine();
        $orderLine1->setQuantity(2);
        $orderLine1->setUnitCost(12.00);
        $orderLine1->setProduct($product1);
        
        $product2 = $manager->getRepository("BookiesCoreBundle:Product")->find(2);
        
        $orderLine2 = new OrderLine();    
        $orderLine2->setQuantity(1);
        $orderLine2->setUnitCost(42.00);
        $orderLine2->setProduct($product2);
        
        $order = new Order();
        $order->setTotal(120);
        $order->setCustomerFirstname("John");
        $order->setCustomerName("Doe");
        $order->setCustomerAddress("123 rue St-Catherine, Montréal, Qc, Canada, H3C 0L9");
        $order->addLine($orderLine1);
        $order->addLine($orderLine2);
        
        $orderLine1->setOrder($order);
        $orderLine2->setOrder($order);
        
        $manager->persist($order);
        
        $manager->flush();
    }

}

?>

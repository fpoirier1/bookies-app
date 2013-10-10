<?php

namespace Bookies\CoreBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;

class OrdersController extends Controller implements ClassResourceInterface
{
    public function cgetAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $orders = $em->getRepository("BookiesCoreBundle:Order")->findAll();
        
        /* @var $view View */
        $view = View::create();
        $view->setStatusCode( 200 );
        $view->setData( $orders );        
        $view->setSerializationContext( $this->getContext( array("order") ) );
        return $this->get( 'fos_rest.view_handler' )->handle( $view );
    }
    
    private function getContext( $groups ){
        $context = new SerializationContext();
        $context->setVersion("0");
        $context->setGroups($groups);
        
        return $context;
    }
}
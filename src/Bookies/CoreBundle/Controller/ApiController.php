<?php

namespace Bookies\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use JMS\Serializer\SerializationContext;
use Bookies\CoreBundle\Entity\Inventory;
use Bookies\CoreBundle\Entity\Product;

class ApiController extends Controller
{
    /**
    * GET Order list
    * @Get("/orders")
    */
    public function ordersAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $orders = $em->getRepository("BookiesCoreBundle:Order")->findAll();
        
        /* @var $view View */
        $view = View::create();
        $view->setStatusCode( 200 );
        $view->setData( $orders );        
        $view->setSerializationContext( $this->getContext( array("order") ) );
        return $this->get( 'fos_rest.view_handler' )->handle( $view );
    }
    
    
    /**
    * GET Categories
    * @Get("/categories")
    */
    public function categoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $categories = $em->getRepository("BookiesCoreBundle:Category")->findAll();
        
        /* @var $view View */
        $view = View::create();
        $view->setStatusCode( 200 );
        $view->setData( $categories );        
        $view->setSerializationContext( $this->getContext( array("category") ) );
        return $this->get( 'fos_rest.view_handler' )->handle( $view );
    }
    
    
    /**
    * GET Product Catalogue
    * @Get("/products")
    */
    public function productsAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $inventory = $em->getRepository("BookiesCoreBundle:Product")->findAll();
        
        $inventory = array_filter($inventory, function(Product $p) {
            return $p->getCategory()->isActive();
        });
        
        /* @var $view View */
        $view = View::create();
        $view->setStatusCode( 200 );
        $view->setData( $inventory );        
        $view->setSerializationContext( $this->getContext( array("product") ) );
        return $this->get( 'fos_rest.view_handler' )->handle( $view );
    }
    
    /**
    * GET Product
    * @Get("/product_{id}")
    */
    public function productAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        /**
         * @var Inventory $inventory
         */
        $inventory = $em->getRepository("BookiesCoreBundle:Inventory")->find( 1 );
        
        $product = $this->findProduct($inventory, $id);
                
        /* @var $view View */
        $view = View::create();
        $view->setStatusCode( 200 );
        $view->setData( $product );        
        $view->setSerializationContext( $this->getContext( array("product") ) );
        return $this->get( 'fos_rest.view_handler' )->handle( $view );
    }    
    
    /**
    * GET Product
    * @Get("/product_{id}/rate/{score}", requirements={"id" = "\d+", "score" = "\d+"})
    */
    public function rateProductAction($id, $score){
        
        $em = $this->getDoctrine()->getManager();
        
        /**
         * @var Inventory $inventory
         */
        $inventory = $em->getRepository("BookiesCoreBundle:Inventory")->find( 1 );
                
        /**
         * @var Product $product
         */
        $product = $this->findProduct($inventory, $id);
        
        $product->addRating($score);
        
        $em->persist($product);
        $em->flush();
         
        /* @var $view View */
        $view = View::create();
        $view->setStatusCode( 200 );
        $view->setData( $product );        
        $view->setSerializationContext( $this->getContext( array("product") ) );
        return $this->get( 'fos_rest.view_handler' )->handle( $view );
    }
    
    private function findProduct( Inventory $inventory, $idProduct ){
        foreach( $inventory->getItems() as $key=>$item){
            if($item->getProduct()->getId() == $idProduct )
                return $item->getProduct();
        }
    }
    
    private function getContext( $groups ){
        $context = new SerializationContext();
        $context->setVersion("0");
        //$context->setGroups($groups);
        
        return $context;
    }
}

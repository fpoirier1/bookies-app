<?php

namespace Bookies\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use JMS\Serializer\SerializationContext;

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
    * POST Order
    * @Post("/order")
    */
    public function orderAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $order  = new Order();
        $form = $this->createForm(new OrderType(), $order);
        $form->bind($request);

        /* @var $view View */
        $view = View::create();
        $view->setSerializationContext( $this->getContext( array("order") ) );
        $view->setStatusCode( 400 );
        
        if ( $form->isValid() ) {
            // Aller chercher pour chaque produit le cout 
            // Faire baisser la quantité
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            $view->setStatusCode( 200 );
            $view->setData( $order );    
        }
            
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
        
        $products = $em->getRepository("BookiesCoreBundle:Product")->createQueryBuilder('p')
                    ->join('p.stockMove', 'sm')
                    ->where("p.active = true")
                    ->getQuery()->getResult();
        
        /* @var $view View */
        $view = View::create();
        $view->setStatusCode( 200 );
        $view->setData( $products );        
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
        
        $product = $em->getRepository("BookiesCoreBundle:Product")->createQueryBuilder('p')
                    ->join('p.stockMove', 'sm')
                    ->where("p.active = true")
                    ->andWhere("p.id = ?1")
                     ->setParameter(1, $id)
                    ->getQuery()->getOneorNullResult();
                
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
        
        
        $product = $em->getRepository("BookiesCoreBundle:Product")->createQueryBuilder('p')
                    ->join('p.stockMove', 'sm')
                    ->where("p.active = true")
                    ->andWhere("p.id = ?1")
                     ->setParameter(1, $id)
                    ->getQuery()->getOneorNullResult();
        
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
        
    private function getContext( $groups ){
        $context = new SerializationContext();
        $context->setVersion("0");
        //$context->setGroups($groups);
        
        return $context;
    }
}
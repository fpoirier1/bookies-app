<?php

namespace Bookies\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use JMS\Serializer\SerializationContext;
use Bookies\CoreBundle\Entity\Order;
use Bookies\CoreBundle\Form\OrderType;

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
            
            $em = $this->getDoctrine()->getManager();
            
            $total = 0;
            
            if( $order->getLines()->count() <= 0  )
                throw new \Exception( 'Une commande doit comporter au moins un article.');
            
            foreach( $order->getLines() as $line){
                $line->setOrder($order);
                
                /**
                 * Augmenter le total
                 * @var \Bookies\CoreBundle\Entity\Product
                 */
                $product = $line->getProduct();
                $total += $product->getPrice();
                
                /**
                 * Faire baisser l'inventaire
                 * @var \Bookies\CoreBundle\Entity\StockMove
                 */
                $stockMove = $em->getRepository("BookiesCoreBundle:StockMove")->findOneBy(
                    array( "product" => $product )
                );
                
                $quantity = $stockMove->getQuantity();
                if( $quantity < $line->getQuantity()  )
                    throw new \Exception( 'Not enough books left for '. $product->getName() );
                
                $stockMove->setQuantity($quantity - $line->getQuantity());
                
                $em->flush();
                                
            }
            
            $order->setTotal($total);
            
            $em->persist($order);
            $em->flush();

            $view->setStatusCode( 200 );
            $view->setData( $order );    
        }else{
            $view->setData($form);
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
        
        $categories = $em->getRepository("BookiesCoreBundle:Category")->findBy(array("active" => true));
        
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
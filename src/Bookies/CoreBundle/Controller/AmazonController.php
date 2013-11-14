<?php

namespace Bookies\CoreBundle\Controller;

use Bookies\CoreBundle\Amazon\Api;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;

class AmazonController extends Controller
{
    /**
    * @Get("/{slug}")
    */
    public function amazonAction($slug = null)
    {
        $api = new Api(
        'com',
        'AKIAI7W62SHCNT2IJPOQ',
        'ak4YyfFGY8fT+ZxiZq1iEaxU8vNn5iwCtukJ9xm0',
        'testapi0f-20');

        $author = $slug;
        
        $r = $api->searchByAuthor($author);
        
        /*echo "result for $author" . PHP_EOL;
        foreach($r['Items']['Item'] as $itm) {
            echo $itm['ItemAttributes']['ProductGroup'] . ' ' . $itm['ItemAttributes']['Title'] . "\n";
        }

        $title = "The House of Hades";
        $r = $api->searchByTitle($title);
        echo "result for $title" . PHP_EOL;
        foreach($r['Items']['Item'] as $itm) {
            echo $itm['ItemAttributes']['ProductGroup'] . ' ' . $itm['ItemAttributes']['Title'] . "\n";
        }*/


        /* @var $view View */
        $view = View::create();
        $view->setStatusCode( 200 );
        $view->setData( $r );        
        $view->setSerializationContext( $this->getContext( array() ) );
        return $this->get( 'fos_rest.view_handler' )->handle( $view );
    }
    private function getContext( $groups ){
        $context = new SerializationContext();
        $context->setVersion("0");
        //$context->setGroups($groups);
        
        return $context;
    }
    
    
}
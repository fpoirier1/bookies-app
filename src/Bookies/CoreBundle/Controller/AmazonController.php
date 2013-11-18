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
    * @Get("/{author}/{title}", defaults={"title" = null}))
    */
    public function amazonAction($author, $title)
    {
        $api = new Api(
            'com',
            'AKIAI7W62SHCNT2IJPOQ',
            'ak4YyfFGY8fT+ZxiZq1iEaxU8vNn5iwCtukJ9xm0',
            'testapi0f-20');
        
        $r = array();
        
        $api_r = $api->searchByAuthor($author);
        $r = array_merge($r, $api_r['Items']['Item']);
        
        if ($title) {
            $api_r = $api->searchByTitle($title);
            $r = array_merge($r, $api_r['Items']['Item']);
        }

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

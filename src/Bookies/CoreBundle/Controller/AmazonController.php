<?php

namespace Bookies\CoreBundle\Controller;

use Bookies\CoreBundle\Amazon\Api;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;

class AmazonController extends Controller
{
    protected function getApi()
    {
        return new Api(
            'com',
            'AKIAI7W62SHCNT2IJPOQ',
            'ak4YyfFGY8fT+ZxiZq1iEaxU8vNn5iwCtukJ9xm0',
            'testapi0f-20');
    }
    
    /**
    * @Get("/search/{author}/{title}", defaults={"title" = null}))
    */
    public function searchAction($author, $title)
    {
        $api = $this->getApi();
        
        $r = array();
        
        $api_r = $api->searchByAuthor($author);
        $r = array_merge($r, $api_r['Items']['Item']);
        
        if ($title) {
            $api_r = $api->searchByTitle($title);
            $r = array_merge($r, $api_r['Items']['Item']);
        }
        
        $r = array_map(function($itm) {
            $author = isset($itm['ItemAttributes']['Author']) ? $itm['ItemAttributes']['Author'] : 'Unknown';
            $title = isset($itm['ItemAttributes']['Title']) ? $itm['ItemAttributes']['Title'] : null;
            $url = isset($itm['DetailPageURL']) ? $itm['DetailPageURL'] : null;
            return array(
                'url' => $url,
                'author' => $author,
                'title' => $title,
            );
        }, $r);
        
        $r = array_filter($r, function($i) {
            return $i['url'] != null and $i['title'] != null;
        });

        /* @var $view View */
        $view = View::create();
        $view->setStatusCode( 200 );
        $view->setData( $r );        
        $view->setSerializationContext( $this->getContext( array() ) );
        return $this->get( 'fos_rest.view_handler' )->handle( $view );
    }
    
    /**
    * @Get("/similarityLookup")
    */
    public function similarityLookupAction()
    {
        $author = $this->getRequest()->query->get('author');
        $title = $this->getRequest()->query->get('title');
        
        $asin = null;
        
        $api = $this->getApi();
        
        $api_r = $api->searchByTitle($title);
        if (!isset($api_r['Items']['Item']) or count($api_r['Items']['Item']) < 1) {
            $api_r = $api->searchByAuthor($author);
        }
        
        if (isset($api_r['Items']['Item']) and count($api_r['Items']['Item']) >= 1) {
            $asin = $api_r['Items']['Item'][0]['ASIN'];
        }
        
        return $this->similarityLookupByAisinAction($asin);
    }
    
    /**
    * @Get("/similarityLookupByAsin/{asin}")
    */
    public function similarityLookupByAisinAction($asin = null)
    {
        if ($asin == null) {
            $r = array();
        }
        else {
            $api = $this->getApi();
            
            $api_r = $api->similarityLookup($asin);
            
            $r = array_map(function($itm) {
                $author = isset($itm['ItemAttributes']['Author']) ? $itm['ItemAttributes']['Author'] : 'Unknown';
                $title = isset($itm['ItemAttributes']['Title']) ? $itm['ItemAttributes']['Title'] : null;
                $url = isset($itm['DetailPageURL']) ? $itm['DetailPageURL'] : null;
                $img = isset($itm['ImageSets']) ? $itm['ImageSets'] : null;
                return array(
                    'url' => $url,
                    'author' => $author,
                    'title' => $title,
                    'img' => $img,
                );
            }, $api_r['Items']['Item']);
            
            
            $r = array_filter($r, function($i) {
                return $i['url'] != null and $i['title'] != null and $i['img'] != null;
            });
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

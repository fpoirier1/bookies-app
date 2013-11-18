<?php

namespace Bookies\CoreBundle\Amazon;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;


class Api
{
    protected $apaiIO;

    
    public function __construct($country, $access_key, $secret_key, $associate_tag)
    {
        
        $conf = new GenericConfiguration();
        $conf
            ->setCountry($country)
            ->setAccessKey($access_key)
            ->setSecretKey($secret_key)
            ->setAssociateTag($associate_tag);
        $this->apaiIO = new ApaiIO($conf);
    }
    
    public function searchByTitle($title)
    {
        $search = $this->createSearch();
        $search->setTitle($title);
        return $this->runOperation($search);
    }
    
    public function searchByAuthor($author)
    {
        $search = $this->createSearch();
        $search->setAuthor($author);
        return $this->runOperation($search);
    }
    
    protected function createSearch()
    {
        $search = new Search();
        //$search->setCategory('KindleStore');
        $search->setCategory('Books');
        $search->setSort('salesrank');
        return $search;
    }
    
    protected function runOperation($op)
    {
        $formattedResponse = $this->apaiIO->runOperation($op);
        $xml = @simplexml_load_string($formattedResponse);
        $json = json_encode($xml);
        $r = json_decode($json, true);
        
        if ($r['Items']['TotalResults'] == 0) {
            $r['Items']['Item'] = array();
        }
        else if ($r['Items']['TotalResults'] == 1) {
            $r['Items']['Item'] = array($r['Items']['Item']);
        }
        
        return $r;
    }
}


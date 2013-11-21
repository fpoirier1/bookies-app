<?php

namespace Bookies\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * StockMove
 *
 * @ORM\Table(name="stock_move")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("none")
 */
class StockMove
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\OneToOne(targetEntity="Product", inversedBy="stockMove")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;
    
    /**
     * 
     * @ORM\Column(name="product_qty", type="float")
     */
    private $quantity;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * 
     * @return Product
     */
    public function getProduct(){
        return $this->product;
    }
    
    /**
     * @param integer $value
     * @return StockMove
     */
    public function setQuantity( $value ){
        $this->quantity = $value;
        
        return $this;
    }
    
    /**
     * @return float
     */
    public function getQuantity(){
        return $this->quantity;
    }
}

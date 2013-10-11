<?php

namespace Bookies\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * OrderLine
 *
 * @ORM\Table(name="bookies_order_line")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("none")
 */
class OrderLine
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     * 
     * @Serializer\Expose
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="unit_cost", type="decimal")
     */
    private $unitCost;
        
    /**
     * @var Order $order
     * 
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="lines", cascade={"persist"})
     * 
     * @Serializer\Exclude
     */
    private $order;
      
    /**
     * @var Order $order
     * 
     * @ORM\ManyToOne(targetEntity="Product", cascade={"persist"})
     */
    private $product;

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
     * Set quantity
     *
     * @param integer $quantity
     * @return OrderLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set unitCost
     *
     * @param float $unitCost
     * @return OrderLine
     */
    public function setUnitCost($unitCost)
    {
        $this->unitCost = $unitCost;
    
        return $this;
    }

    /**
     * Get unitCost
     *
     * @return float 
     */
    public function getUnitCost()
    {
        return $this->unitCost;
    }

    /**
     * Set order
     *
     * @param \Bookies\CoreBundle\Entity\Order $order
     * @return OrderLine
     */
    public function setOrder(\Bookies\CoreBundle\Entity\Order $order = null)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return \Bookies\CoreBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product
     *
     * @param \Bookies\CoreBundle\Entity\Product $product
     * @return OrderLine
     */
    public function setProduct(\Bookies\CoreBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \Bookies\CoreBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}
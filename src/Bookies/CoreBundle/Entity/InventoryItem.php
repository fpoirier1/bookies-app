<?php

namespace Bookies\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * InventoryItem
 *
 * @ORM\Table(name="stock_inventory_line")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("none")
 */
class InventoryItem
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
     * @var string
     *
     * @ORM\Column(name="product_qty", type="float", length=255)
     */
    private $quantity;

    /**
     * @var Inventory $inventory
     * 
     * @ORM\ManyToOne(targetEntity="Inventory", inversedBy="items")
     * @Serializer\Exclude()
     */
    private $inventory;
    
    /**
     * @ORM\OneToOne(targetEntity="Product", inversedBy="inventoryItem")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
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
     * @param string $quantity
     * @return InventoryItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return string 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set inventory
     *
     * @param \Bookies\CoreBundle\Entity\Inventory $inventory
     * @return InventoryItem
     */
    public function setInventory(\Bookies\CoreBundle\Entity\Inventory $inventory = null)
    {
        $this->inventory = $inventory;
    
        return $this;
    }

    /**
     * Get inventory
     *
     * @return \Bookies\CoreBundle\Entity\Inventory 
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Set product
     *
     * @param \Bookies\CoreBundle\Entity\Product $product
     * @return InventoryItem
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
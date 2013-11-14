<?php

namespace Bookies\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Inventory
 *
 * @ORM\Table(name="stock_inventory")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("none")
 */
class Inventory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Exclude()
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $items
     * 
     * @ORM\OneToMany(targetEntity="InventoryItem", mappedBy="inventory")
     * @Serializer\Exclude()
     */
    private $items;

    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add items
     *
     * @param \Bookies\CoreBundle\Entity\InventoryItem $items
     * @return Inventory
     */
    public function addItem(\Bookies\CoreBundle\Entity\InventoryItem $items)
    {
        $this->items[] = $items;
    
        return $this;
    }

    /**
     * Remove items
     *
     * @param \Bookies\CoreBundle\Entity\InventoryItem $items
     */
    public function removeItem(\Bookies\CoreBundle\Entity\InventoryItem $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }
    
    /**
     * Get items
     *
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("products")
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts(){
        return $this->items->map(function(InventoryItem $item){
            return $item->getProduct();
        });
    }
}
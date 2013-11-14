<?php

namespace Bookies\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Product
 *
 * @ORM\Table(name="product_product")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("none")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @var ProductTemplate
     *
     * @ORM\OneToOne(targetEntity="ProductTemplate")
     * @ORM\JoinColumn(name="product_tmpl_id", referencedColumnName="id")
     * @Serializer\Exclude()
     * 
     */
    private $template;
    
    
    /**
     * @var InventoryItem
     *
     * @ORM\OneToOne(targetEntity="InventoryItem", mappedBy="product")
     * @Serializer\Exclude()
     * 
     */
    private $inventoryItem;
        
    /**
     * @var rating
     * 
     * @ORM\OneToOne(targetEntity="Rating", mappedBy="product", cascade={"persist", "remove"})
     * @Serializer\Exclude()
     */
    private $rating;

    
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
     * Get name
     *
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("name")
     *
     * @return string 
     */
    public function getName()
    {
        return $this->template->getName();
    }

    /**
     * Get price
     *
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("price")
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->template->getPrice();
    }
    
    /**
     * Get items
     *
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("quantity")
     * @return 
     */
    public function getQuantity(){
        return $this->inventoryItem->getQuantity();
    }

    /**
     * Get category
     *
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("category")
     *
     * @return \Bookies\CoreBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->template->getCategory();
    }

    /**
     * Set template
     *
     * @param ProductTemplate $template
     * @return Product
     */
    public function setTemplate(ProductTemplate $template = null)
    {
        $this->template = $template;
    
        return $this;
    }

    /**
     * Get template
     *
     * @return ProductTemplate 
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set inventoryItem
     *
     * @param \Bookies\CoreBundle\Entity\InventoryItem $inventoryItem
     * @return Product
     */
    public function setInventoryItem(\Bookies\CoreBundle\Entity\InventoryItem $inventoryItem = null)
    {
        $this->inventoryItem = $inventoryItem;
    
        return $this;
    }

    /**
     * Get inventoryItem
     *
     * @return \Bookies\CoreBundle\Entity\InventoryItem 
     */
    public function getInventoryItem()
    {
        return $this->inventoryItem;
    }

    /**
     * Set rating
     *
     * @param integer
     * @return Product
     */
    public function addRating($score)
    {
        if( !$this->rating ){
            $this->rating = new Rating();
            $this->rating->setProduct($this);
        }
        
        $this->rating->addScore( $score );
    
        return $this;
    }

    /**
     * Get rating
     *
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("rating")
     * 
     * @return \Bookies\CoreBundle\Entity\Rating 
     */
    public function getRating()
    {
        if( !$this->rating ){
            $this->rating = new Rating();
            $this->rating->setProduct($this);
        }
        
        return $this->rating;
    }
    

    /**
     * Get rating
     *
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("rating")
     * 
     * @return \Bookies\CoreBundle\Entity\Rating 
     */
    public function getRate()
    {
        if( !$this->rating ){
            $this->rating = new Rating();
            $this->rating->setProduct($this);
        }
        
        return $this->rating->getRate();
    }
}
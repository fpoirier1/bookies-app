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
     *
     * @ORM\OneToOne(targetEntity="StockMove", mappedBy="product")
     * @Serializer\Exclude()
     */
    private $stockMove;
            
    /**
     * @var rating
     * 
     * @ORM\OneToOne(targetEntity="Rating", mappedBy="product", cascade={"persist", "remove"})
     */
    private $rating;

    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;
    
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
     * Get name
     *
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("description")
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->template->getDescription();
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
     * @Serializer\SerializedName("stock_quantity")
     * @return 
     */
    public function getQuantity(){
        if( !$this->stockMove )
            return null;

        return $this->stockMove->getQuantity();
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
    
    public function isActive(){
        return $this->active;
    }
    
    public function getStockMove(){
        return $this->stockMove;
    }
}
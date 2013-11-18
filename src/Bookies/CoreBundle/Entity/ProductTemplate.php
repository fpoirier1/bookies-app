<?php

namespace Bookies\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * ProductTemplate
 *
 * @ORM\Table(name="product_template")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("none")
 */
class ProductTemplate
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="list_price", type="decimal")
     */
    private $price;
    
    /**
     * @var Category
     * 
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="categ_id", referencedColumnName="id")
     */
    private $category;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="description", type="string")
     */
    private $raw_description;
    private $description = null;
    private $author = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return ProductTemplate
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return ProductTemplate
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set category
     *
     * @param \Bookies\CoreBundle\Entity\Category $category
     * @return ProductTemplate
     */
    public function setCategory(\Bookies\CoreBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Bookies\CoreBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
    

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        if ($this->description === null) {
            $this->parseDescription();
        }
        return $this->description;
    }
    
    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        if ($this->author === null) {
            $this->parseDescription();
        }
        return $this->author;
    }
    
    protected function parseDescription()
    {
        $pattern = '/^Author:(.*?)\*Description:(.*)/';
        $matches = array();
        $r = preg_match($pattern , $this->raw_description, $matches);
        if ($r) {
            $this->author = trim($matches[1]);
            $this->description = trim($matches[2]);
        }
        else {
            $this->author = "Unknown";
            $this->description = "No description available";
        }
    }
}

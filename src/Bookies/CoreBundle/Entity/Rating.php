<?php

namespace Bookies\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="bookies_rating")
 * @ORM\Entity
 */
class Rating
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

    /**
     * @var rating
     * 
     * @ORM\OneToOne(targetEntity="Product", inversedBy="rating")
     */
    private $product;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nb", type="integer")
     */
    private $nb = 0;

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
     * Set score
     *
     * @param integer $score
     * @return Rating
     */
    public function addScore($score)
    {
        $this->score += $score;
        $this->nb++;
        
        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Get nb
     *
     * @return integer 
     */
    public function getNb()
    {
        return $this->nb;
    }

    /**
     * Set product
     *
     * @param \Bookies\CoreBundle\Entity\Product $product
     * @return Rating
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
    
    /**
     * Get Rate
     * @return integer
     */
    public function getRate(){
        if($this->nb <= 0)
            return 0;
        
        return round($this->score / $this->nb);
    }
}
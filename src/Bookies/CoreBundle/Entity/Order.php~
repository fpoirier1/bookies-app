<?php

namespace Bookies\CoreBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Order
 *
 * @ORM\Table(name="bookies_order")
 * @ORM\Entity
 * 
 * @Serializer\ExclusionPolicy("none")
 */
class Order
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_name", type="string", length=255)
     * 
     */
    private $customerName;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_address", type="string", length=255)
     * 
     */
    private $customerAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="decimal", length=255)
     * 
     */
    private $total;
    
    /**
     * @var ArrayCollection $lines
     * 
     * @ORM\OneToMany(targetEntity="OrderLine", mappedBy="order", cascade={"persist", "remove"})
    */
    private $lines;
    
    public function __construct()
    {
        $this->lines = new ArrayCollection();
        $this->createdAt = new \DateTime();
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
     * Set createdAt
     *
     * @param DateTime $createdAt
     * @return Order
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     * @return Order
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
    
        return $this;
    }

    /**
     * Get customerName
     *
     * @return string 
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set customerFirstname
     *
     * @param string $customerFirstname
     * @return Order
     */
    public function setCustomerFirstname($customerFirstname)
    {
        $this->customerFirstname = $customerFirstname;
    
        return $this;
    }

    /**
     * Get customerFirstname
     *
     * @return string 
     */
    public function getCustomerFirstname()
    {
        return $this->customerFirstname;
    }

    /**
     * Set customerAddress
     *
     * @param string $customerAddress
     * @return Order
     */
    public function setCustomerAddress($customerAddress)
    {
        $this->customerAddress = $customerAddress;
    
        return $this;
    }

    /**
     * Get customerAddress
     *
     * @return string 
     */
    public function getCustomerAddress()
    {
        return $this->customerAddress;
    }

    /**
     * Set total
     *
     * @param double $total
     * @return Order
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return double 
     */
    public function getTotal()
    {
        return $this->total;
    }
    
    public function __toString(){
        return "order #".$this->id;
    }

    /**
     * Add lines
     *
     * @param \Bookies\CoreBundle\Entity\OrderLine $lines
     * @return Order
     */
    public function addLine(\Bookies\CoreBundle\Entity\OrderLine $lines)
    {
        $this->lines[] = $lines;
    
        return $this;
    }

    /**
     * Remove lines
     *
     * @param \Bookies\CoreBundle\Entity\OrderLine $lines
     */
    public function removeLine(\Bookies\CoreBundle\Entity\OrderLine $lines)
    {
        $this->lines->removeElement($lines);
    }

    /**
     * Get lines
     *
     * @return Collection 
     */
    public function getLines()
    {
        return $this->lines;
    }
}
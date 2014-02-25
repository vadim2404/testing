<?php

namespace Bstu\Bundle\TestOrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Variant
 *
 * @ORM\Table(name="variant")
 * @ORM\Entity(repositoryClass="Bstu\Bundle\TestOrganizationBundle\Repository\VariantRepository")
 */
class Variant
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
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     * 
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="variants")
     */
    private $test;

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
     * Set number
     *
     * @param integer $number
     * @return Variant
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }
    
    /**
     * Get test
     * 
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set Test
     * 
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\Test $test
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Variant
     */
    public function setTest(Test $test)
    {
        $this->test = $test;
        
        return $this;
    }

}

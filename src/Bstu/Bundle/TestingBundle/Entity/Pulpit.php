<?php

namespace Bstu\Bundle\TestingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pulpit
 *
 * @ORM\Table(name="pulpit")
 * @ORM\Entity(repositoryClass="Bstu\Bundle\TestingBundle\Repository\PulpitRepository")
 */
class Pulpit
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
     * @ORM\ManyToOne(targetEntity="Faculty", inversedBy="pulpits", cascade={"all"})
     *
     * @var \Bstu\Bundle\TestingBundle\Entity\Faculty $faculty
    */
    private $faculty;
    
    /**
     * Get faculty
     * 
     * @return \Bstu\Bundle\TestingBundle\Entity\Faculty
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * Set faculty
     *
     * @param \Bstu\Bundle\TestingBundle\Entity\Faculty $faculty
     * @return \Bstu\Bundle\TestingBundle\Entity\Pulpit
     */
    public function setFaculty($faculty)
    {
        $this->faculty = $faculty;

        return $this;
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
     * @return Pulpit
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


}

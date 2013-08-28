<?php

namespace Bstu\Bundle\TestOrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Theme
 *
 * @ORM\Table(name="theme")
 * @ORM\Entity(repositoryClass="Bstu\Bundle\TestOrganizationBundle\Repository\ThemeRepository")
 */
class Theme
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
     * Theme for subject
     *
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="themes")
     * @var \Bstu\Bundle\TestOrganizationBundle\Entity\Subject $subject
     */
    private $subject;

    /**
     * Get subject
     *
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set subject
     *
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\Subject $subject
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Theme
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \Bstu\Bundle\UserBundle\Entity\User
     */
    public function getTeacher()
    {
        return $this->getSubject()->getTeacher();
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
     * @return Theme
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

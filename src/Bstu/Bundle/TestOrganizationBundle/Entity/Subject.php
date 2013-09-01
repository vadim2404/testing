<?php

namespace Bstu\Bundle\TestOrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Subject
 *
 * @ORM\Table(name="subject")
 * @ORM\Entity(repositoryClass="Bstu\Bundle\TestOrganizationBundle\Repository\SubjectRepository")
 */
class Subject
{
    public function __construct()
    {
        $this->themes = new ArrayCollection();
    }

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
     * @ORM\ManyToOne(targetEntity="\Bstu\Bundle\UserBundle\Entity\User", inversedBy="subjects")
     *
     * @var \Bstu\Bundle\UserBundle\Entity\User $teacher
    */
    private $teacher;

    /**
     * Themes that relates to this subject
     *
     * @ORM\OneToMany(targetEntity="Theme", mappedBy="subject", cascade={"all"})
     * @var \Doctrine\Common\Collections\Collection
     */
    private $themes;

    /**
     * Get themes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Set themes
     *
     * @param \Doctrine\Common\Collections\Collection $themes
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Subject
     */
    public function setThemes(Collection $themes)
    {
        $this->themes = $themes;

        return $this;
    }


    /**
     * Set teacher
     *
     * @return \Bstu\Bundle\UserBundle\Entity\Use
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set teacher
     *
     * @param \Bstu\Bundle\UserBundle\Entity\User $teacher
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Subject
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;

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
     * @return Subject
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
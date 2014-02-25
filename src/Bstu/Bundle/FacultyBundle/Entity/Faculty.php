<?php

namespace Bstu\Bundle\FacultyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Faculty
 *
 * @ORM\Table(name="faculty")
 * @ORM\Entity(repositoryClass="Bstu\Bundle\FacultyBundle\Repository\FacultyRepository")
 */
class Faculty
{
    public function __construct()
    {
        $this->pulpits = new ArrayCollection();
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
     * @Assert\NotBlank(message="Название должно обязательно быть заполненным")
     * @Assert\Length(min="0", max="255", maxMessage="Название не может быть больше 255 символов")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Pulpit", mappedBy="faculty", cascade={"all"})
     */
    private $pulpits;

    /**
     * Get pulpits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPulpits()
    {
        return $this->pulpits;
    }

    /**
     * Set pulpits
     *
     * @param \Doctrine\Common\Collections\Collection $pulpits
     * @return \Bstu\Bundle\TestingBundle\Entity\Faculty
     */
    public function setPulpits(Collection $pulpits)
    {
        $this->pulpits = $pulpits;

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
     * @return Faculty
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

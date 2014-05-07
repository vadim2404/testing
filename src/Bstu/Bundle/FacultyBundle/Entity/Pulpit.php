<?php

namespace Bstu\Bundle\FacultyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pulpit
 *
 * @ORM\Table(name="pulpit")
 * @ORM\Entity(repositoryClass="Bstu\Bundle\FacultyBundle\Repository\PulpitRepository")
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
     * @Assert\NotBlank(message="Название должно обязательно быть заполненным")
     * @Assert\Length(min="0", max="255", maxMessage="Название не может быть больше 255 символов")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Faculty", inversedBy="pulpits")
     *
     * @var \Bstu\Bundle\FacultyBundle\Entity\Faculty $faculty
    */
    private $faculty;

    /**
     * Get faculty
     *
     * @return \Bstu\Bundle\FacultyBundle\Entity\Faculty
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * Set faculty
     *
     * @param  \Bstu\Bundle\FacultyBundle\Entity\Faculty $faculty
     * @return \Bstu\Bundle\FacultyBundle\Entity\Pulpit
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
     * @param  string $name
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

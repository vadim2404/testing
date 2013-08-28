<?php

namespace Bstu\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    public function __construct()
    {
        parent::__construct();

        $this->subjects = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * First Name
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     * @var string $firstName
     */
    private $firstName = '';

    /**
     * Last Name
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     * @var string $lastName
     */
    private $lastName = '';

    /**
     * Middle Name
     *
     * @ORM\Column(name="middle_name", type="string", length=255, nullable=true)
     * @var string $middleName
     */
    private $middleName;

    /**
     * Pulpit
     *
     * @ORM\ManyToOne(targetEntity="\Bstu\Bundle\FacultyBundle\Entity\Pulpit")
     * @var \Bstu\Bundle\FacultyBundle\Entity\Pulpit $pulpit
     */
    private $pulpit;

     /**
      * Subjects. (For users with teacher role)
      *
      * @ORM\OneToMany(targetEntity="\Bstu\Bundle\TestOrganizationBundle\Entity\Subject", mappedBy="teacher", cascade={"all"})
      * @var \Doctrine\Common\Collections\Collection
      */
    private $subjects;

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
     * Get subjects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * Set subjects
     *
     * @param \Doctrine\Common\Collections\Collection $subjects
     * @return \Bstu\Bundle\UserBundle\Entity\User
     */
    public function setSubjects(Collection $subjects)
    {
        $this->subjects = $subjects;

        return $this;
    }


    /**
     * Get first name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set first name
     *
     * @param string $firstName
     * @return \Bstu\Bundle\UserBundle\Entity\User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set last name
     *
     * @param string $lastName
     * @return \Bstu\Bundle\UserBundle\Entity\User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get middle name
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set middle name
     *
     * @param string $middleName
     * @return \Bstu\Bundle\UserBundle\Entity\User
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get pulpit
     *
     * @return \Bstu\Bundle\FacultyBundle\Entity\Pulpit
     */
    public function getPulpit()
    {
        return $this->pulpit;
    }

    /**
     * Set pulpit
     *
     * @param \Bstu\Bundle\FacultyBundle\Entity\Pulpit $pulpit
     * @return \Bstu\Bundle\UserBundle\Entity\User
     */
    public function setPulpit($pulpit)
    {
        $this->pulpit = $pulpit;

        return $this;
    }

    /**
     * Group
     *
     * @var \Bstu\Bundle\UserBundle\Entity\Group $group
     *
     * @ORM\ManyToOne(targetEntity="Group")
     */
    private $group;

    /**
     * Get group
     *
     * @return \Bstu\Bundle\UserBundle\Entity\Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set group
     *
     * @param \Bstu\Bundle\UserBundle\Entity\Group $group
     * @return \Bstu\Bundle\UserBundle\Entity\User
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getGroups()
    {
        return $this->group ? new ArrayCollection([$this->group]) : new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function getGroupNames()
    {
        return $this->group ? new ArrayCollection([$this->group->getName()]) : new ArrayCollection();
    }
}
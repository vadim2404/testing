<?php

namespace Bstu\Bundle\TestOrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Theme
 *
 * @ORM\Table(name="theme")
 * @ORM\Entity(repositoryClass="Bstu\Bundle\TestOrganizationBundle\Repository\ThemeRepository")
 */
class Theme
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->tests = new ArrayCollection();
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
     * @Assert\NotBlank(message="Название темы не может быть пустым")
     * @Assert\Length(min="0", max="255", maxMessage="Название не может быть больше 255 символов")
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
     * Questions
     *
     * @ORM\OneToMany(targetEntity="Question", mappedBy="theme", cascade={"all"})
     * @var \Doctrine\Common\Collections\Collection $questions
     */
    private $questions;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="Test", inversedBy="themes")
     * @ORM\JoinTable(name="test_theme")
     */
    private $tests;

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

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set questions
     *
     * @param \Doctrine\Common\Collections\Collection $questions
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Theme
     */
    public function setQuestions(Collection $questions)
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * Get tests
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTests() 
    {
        return $this->tests;
    }

    /**
     * Set tests
     * 
     * @param \Doctrine\Common\Collections\Collection $tests
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Theme
     */
    public function setTests(Collection $tests) 
    {
        $this->tests = $tests;
        
        return $this;
    }
}

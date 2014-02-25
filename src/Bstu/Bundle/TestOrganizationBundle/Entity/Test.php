<?php

namespace Bstu\Bundle\TestOrganizationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="Bstu\Bundle\TestOrganizationBundle\Repository\TestRepository")
 */
class Test
{      
    const TYPE_VARIANT = 1;
    const TYPE_RANDOM = 2;
    const TYPE_RANDOM_VARIANT = 3;
    const TYPE_RANDOM_BY_THEME = 4;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->themes = new ArrayCollection();
        $this->variants = new ArrayCollection();
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
     * @var integer
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Название теста не может быть пустым")
     * @Assert\Length(min="0", max="255", maxMessage="Название теста не может быть больше 255 символов")
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    /**
     * @var \Bstu\Bundle\TestOrganizationBundle\Entity\Subject
     * 
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="tests")
     */
    private $subject;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="Question", mappedBy="tests")
     */
    private $questions;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="Theme", mappedBy="tests")
     */
    private $themes;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Variant", mappedBy="test")
     */
    private $variants;
    
    /**
     * @var integer 
     * 
     * @Assert\GreaterThan(value="0", message="Максимальное число вопросов должно быть больше 0")
     * @ORM\Column(name="max_questions", type="integer")
     */
    private $maxQuestions = 0;

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
     * Set type
     *
     * @param integer $type
     * @return Test
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Test
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    
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
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function setSubject(Subject $subject) 
    {
        $this->subject = $subject;
        
        return $this;
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
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function setQuestions(Collection $questions)
    {
        $this->questions = $questions;
        
        return $this;
    }
    
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
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function setThemes(Collection $themes)
    {
        $this->themes = $themes;
        
        return $this;
    }
    
    /**
     * Get variants
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * Set variants
     * 
     * @param \Doctrine\Common\Collections\Collection $variants
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function setVariants(Collection $variants)
    {
        $this->variants = $variants;
        
        return $this;
    }
    
    /**
     * Get Max Questions
     * 
     * @return integer
     */
    public function getMaxQuestions() 
    {
        return $this->maxQuestions;
    }

    /**
     * Set Max Questions
     * 
     * @param integer $maxQuestions
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function setMaxQuestions($maxQuestions)
    {
        $this->maxQuestions = $maxQuestions;
        
        return $this;
    }
}

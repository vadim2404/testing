<?php

namespace Bstu\Bundle\TestOrganizationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use \ReflectionObject;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="Bstu\Bundle\TestOrganizationBundle\Repository\QuestionRepository")
 */
class Question
{
    const QUESTION_TEXT = 1;
    const QUESTION_TEXTAREA = 2;
    const QUESTION_CHECKBOX = 3;
    const QUESTION_RADIO = 4;

    /**
     * Constructor
     */
    public function __construct()
    {
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
     * @ORM\Column(name="question", type="text")
     * @Assert\NotBlank(message="Название вопроса не может быть пустым")
     */
    private $question;

    /**
     * @var array
     *
     * @ORM\Column(name="variants", type="array")
     */
    private $variants = [];

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="text")
     */
    private $answer = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="smallint")
     */
    private $rate = 1;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type = 1;

    /**
     * Question theme
     *
     * @ORM\ManyToOne(targetEntity="Theme", inversedBy="questions")
     * @var \Bstu\Bundle\TestOrganizationBundle\Entity\Theme $theme
     */
    private $theme;

    /**
     * Theme for subject
     *
     * @ORM\ManyToOne(targetEntity="\Bstu\Bundle\UserBundle\Entity\User", inversedBy="questions")
     * @var \Bstu\Bundle\UserBundle\Entity\User $teacher
     */
    private $teacher;

    /**
     * Check question type
     *
     * @Assert\True(message="Неправильный тип вопроса")
     * @return boolean
     */
    public function isQuestionTypeLegal()
    {
        return in_array($this->type, (new ReflectionObject($this))->getConstants());
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
     * Set question
     *
     * @param string $question
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set variants
     *
     * @param array $variants
     * @return Question
     */
    public function setVariants(array $variants)
    {
        $this->variants = $variants;
    
        return $this;
    }

    /**
     * Get variants
     *
     * @return array 
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return Question
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    
        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     * @return Question
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    
        return $this;
    }

    /**
     * Get rate
     *
     * @return integer 
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Get theme
     *
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set theme
     *
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\Theme $theme
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Question
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \Bstu\Bundle\UserBundle\Entity\User
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set teacher
     *
     *
     * @param \Bstu\Bundle\UserBundle\Entity\User $teacher
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Question
     */
    public function setTeacher( $teacher)
    {
        $this->teacher = $teacher;

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
     * Set type
     *
     * @param integer $type
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Question
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}

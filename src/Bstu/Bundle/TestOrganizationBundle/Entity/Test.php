<?php

namespace Bstu\Bundle\TestOrganizationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Bstu\Bundle\UserBundle\Entity\User;
use Bstu\Bundle\PlanBundle\Entity\Plan;

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
    const TYPE_RANDOM_WITH_COMPLEXITY = 3;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->themes = new ArrayCollection();
        $this->variants = new ArrayCollection();
        $this->plans = new ArrayCollection();
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
     * @ORM\ManyToMany(targetEntity="Theme")
     * @ORM\JoinTable(name="test_theme")
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
     * @var integer
     *
     * @Assert\GreaterThanOrEqual(value="0", message="Максимальная сложность теста не должна быть отрицательным числом")
     * @ORM\Column(name="complexity", type="integer")
     */
    private $complexity = 0;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\Bstu\Bundle\PlanBundle\Entity\Plan", mappedBy="test")
     */
    private $plans;

    /**
     * @var \Bstu\Bundle\UserBundle\Entity\User $teacher
     *
     * @ORM\ManyToOne(targetEntity="\Bstu\Bundle\UserBundle\Entity\User", inversedBy="tests")
     */
    private $teacher;

    /**
     * @var bool $automatic
     *
     * @ORM\Column(name="automatic", type="boolean")
     */
    private $automatic = false;

    /**
     * Get automatic
     *
     * @return bool
     */
    public function getAutomatic()
    {
        return $this->automatic;
    }

    /**
     * Set automatic
     *
     * @param  bool                                            $automatic
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function setAutomatic($automatic)
    {
        $this->automatic = (bool) $automatic;

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
     * Set type
     *
     * @param  integer $type
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
     * @param  string $title
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
     * @param  \Bstu\Bundle\TestOrganizationBundle\Entity\Subject $subject
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;

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
     * @param  \Doctrine\Common\Collections\Collection         $themes
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
     * @param  \Doctrine\Common\Collections\Collection         $variants
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
     * Get complexity
     *
     * @return integer
     */
    public function getComplexity()
    {
        return $this->complexity;
    }

    /**
     * Set Complexity
     *
     * @param  integer                                         $complexity
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function setComplexity($complexity)
    {
        $this->complexity = $complexity;

        return $this;
    }

    /**
     * Set Max Questions
     *
     * @param  integer                                         $maxQuestions
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function setMaxQuestions($maxQuestions)
    {
        $this->maxQuestions = $maxQuestions;

        return $this;
    }

    /**
     * Get plans
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlans()
    {
        return $this->plans;
    }

    /**
     * Set plans
     *
     * @param  \Doctrine\Common\Collections\Collection         $plans
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function setPlans(Collection $plans)
    {
        $this->plans = $plans;

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
     * @param  \Bstu\Bundle\UserBundle\Entity\User             $teacher
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function setTeacher(User $teacher)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Check test complexity
     *
     * @Assert\True(message="Неверная общая сложность теста")
     * @return boolean
     */
    public function isTestComplexityValid()
    {
        return Question::COMPLEXITY_HARD * $this->maxQuestions >= $this->complexity &&
            (
                $this->type !== self::TYPE_RANDOM_WITH_COMPLEXITY ||
                Question::COMPLEXITY_EASY * $this->maxQuestions <= $this->complexity
            );
    }

    /**
     * One or greater themes must be selected
     *
     * @Assert\True(message="Не выбраны темы")
     * @return boolean
     */
    public function isThemesSelected()
    {
        return !$this->themes->isEmpty();
    }

    /**
     * Add themes
     *
     * @param  \Bstu\Bundle\TestOrganizationBundle\Entity\Theme $theme
     * @return Test
     */
    public function addTheme(\Bstu\Bundle\TestOrganizationBundle\Entity\Theme $theme)
    {
        $this->themes[] = $theme;

        return $this;
    }

    /**
     * Remove themes
     *
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\Theme $theme
     */
    public function removeTheme(Theme $theme)
    {
        $this->themes->removeElement($theme);
    }

    /**
     * Add variants
     *
     * @param  \Bstu\Bundle\TestOrganizationBundle\Entity\Variant $variant
     * @return Test
     */
    public function addVariant(\Bstu\Bundle\TestOrganizationBundle\Entity\Variant $variant)
    {
        $this->variants[] = $variant;

        return $this;
    }

    /**
     * Remove variants
     *
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\Variant $variant
     */
    public function removeVariant(Variant $variant)
    {
        $this->variants->removeElement($variant);
    }

    /**
     * Add plans
     *
     * @param  \Bstu\Bundle\PlanBundle\Entity\Plan $plan
     * @return Test
     */
    public function addPlan(Plan $plan)
    {
        $this->plans[] = $plan;

        return $this;
    }

    /**
     * Remove plans
     *
     * @param \Bstu\Bundle\PlanBundle\Entity\Plan $plans
     */
    public function removePlan(Plan $plan)
    {
        $this->plans->removeElement($plan);
    }

    /**
     * Test type is equal to variant?
     *
     * @return bool
     */
    public function isTestByVariants()
    {
        return self::TYPE_VARIANT === $this->type;
    }
}

<?php

namespace Bstu\Bundle\TestOrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Variant
 *
 * @ORM\Table(name="variant", uniqueConstraints={
 *   @ORM\UniqueConstraint(name="test_variant", columns={"test_id", "number"})
 * })
 * @ORM\Entity(repositoryClass="Bstu\Bundle\TestOrganizationBundle\Repository\VariantRepository")
 */
class Variant
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new ArrayCollection();
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
     * @Assert\GreaterThan(value = 0, message = "Номер варианта должен быть положительным числом")
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     *
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="variants")
     */
    private $test;

    /**
     * @var \Doctrine\Common\Collections\Collection $questions
     *
     * @ORM\ManyToMany(targetEntity="Question")
     * @ORM\JoinTable(name="variant_question")
     */
    private $questions;

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
     * Set number
     *
     * @param  integer $number
     * @return Variant
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get test
     *
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set Test
     *
     * @param  \Bstu\Bundle\TestOrganizationBundle\Entity\Test    $test
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Variant
     */
    public function setTest(Test $test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Add question
     *
     * @param  \Bstu\Bundle\TestOrganizationBundle\Entity\Question $questions
     * @return Variant
     */
    public function addQuestion(Question $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\Question $question
     */
    public function removeQuestion(Question $question)
    {
        $this->questions->removeElement($question);
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
     * @param  \Doctrine\Common\Collections\Collection            $questions
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Variant
     */
    public function setQuestions(Collection $questions)
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * @Assert\True(message="Число выбранных вопросов не соответствует тому, что указано в тесте")
     */
    public function isValidNumberOfQuestions()
    {
        return $this->test->getMaxQuestions() === $this->questions->count();
    }
}

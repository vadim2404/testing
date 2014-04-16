<?php

namespace Bstu\Bundle\TestOrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Bstu\Bundle\UserBundle\Entity\User;
use Bstu\Bundle\PlanBundle\Entity\Plan;

/**
 * ResultTest
 *
 * @ORM\Table(name="result_test")
 * @ORM\Entity(repositoryClass="Bstu\Bundle\TestOrganizationBundle\Repository\ResultTestRepository")
 */
class ResultTest
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resultQuestions = new ArrayCollection();
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
     * @var \Doctrine\Common\Collections\Collection $resultQuestions
     *
     * @ORM\OneToMany(targetEntity="ResultQuestion", mappedBy="resultTest", cascade={"persist"})
     * @ORM\JoinColumn(name="id", referencedColumnName="result_test_id")
     */
    private $resultQuestions;

    /**
     * @var \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     *
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     */
    private $test;

    /**
     * @var \Bstu\Bundle\PlanBundle\Entity\Plan
     *
     * @ORM\ManyToOne(targetEntity="\Bstu\Bundle\PlanBundle\Entity\Plan")
     * @ORM\JoinColumn(name="plan_id", referencedColumnName="id")
     */
    private $plan;

    /**
     * @var \Bstu\Bundle\UserBundle\Entity\User $student
     *
     * @ORM\ManyToOne(targetEntity="\Bstu\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;

    /**
     * @var float $rating
     *
     * @ORM\Column(name="rating", type="float")
     */
    private $rating = 0.0;

    /**
     * @var bool $verified
     *
     * @ORM\Column(name="verified", type="boolean")
     */
    private $verified = false;

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
     * Add resultQuestions
     *
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\ResultQuestion $resultQuestions
     * @return ResultTest
     */
    public function addResultQuestion(ResultQuestion $resultQuestions)
    {
        $this->resultQuestions[] = $resultQuestions;

        return $this;
    }

    /**
     * Remove resultQuestions
     *
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\ResultQuestion $resultQuestions
     */
    public function removeResultQuestion(ResultQuestion $resultQuestions)
    {
        $this->resultQuestions->removeElement($resultQuestions);
    }

    /**
     * Get resultQuestions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResultQuestions()
    {
        return $this->resultQuestions;
    }


    /**
     * Set test
     *
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\Test $test
     * @return ResultTest
     */
    public function setTest(Test $test = null)
    {
        $this->test = $test;

        return $this;
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
     * Set student
     *
     * @param \Bstu\Bundle\UserBundle\Entity\User $student
     * @return ResultTest
     */
    public function setStudent(User $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \Bstu\Bundle\UserBundle\Entity\User 
     */
    public function getStudent()
    {
        return $this->student;
    }
    
    /**
     * Set plan
     *
     * @param \Bstu\Bundle\PlanBundle\Entity\Plan $plan
     * @return ResultTest
     */
    public function setPlan(Plan $plan = null)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return \Bstu\Bundle\PlanBundle\Entity\Plan 
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * Set rating
     *
     * @param float $rating
     * @return ResultTest
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return float 
     */
    public function getRating()
    {
        return round($this->rating, 2);
    }

    /**
     * Set verified
     *
     * @param bool $verified
     * @return ResultTest
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;

        return $this;
    }

    /**
     * Get verified
     *
     * @return bool
     */
    public function getVerified()
    {
        return $this->verified;
    }
}

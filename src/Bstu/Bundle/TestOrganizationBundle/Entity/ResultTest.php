<?php

namespace Bstu\Bundle\TestOrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Bstu\Bundle\UserBundle\Entity\User;

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
     * @ORM\OneToMany(targetEntity="ResultQuestion", mappedBy="resultTest")
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
     * @var \Bstu\Bundle\UserBundle\Entity\User $student
     *
     * @ORM\ManyToOne(targetEntity="\Bstu\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;


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
}

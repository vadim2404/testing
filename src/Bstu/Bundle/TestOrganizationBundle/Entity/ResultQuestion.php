<?php

namespace Bstu\Bundle\TestOrganizationBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * ResultQuestion
 *
 * @ORM\Table("result_question")
 * @ORM\Entity(repositoryClass="Bstu\Bundle\TestOrganizationBundle\Repository\ResultQuestionRepository")
 */
class ResultQuestion
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
     *
     * @ORM\Column(name="answer", type="text", nullable=true)
     */
    private $answer;

    /**
     * @var float
     *
     * @Assert\Range(
     *  min = 0,
     *  max = 1
     * )
     * @ORM\Column(name="result", type="float")
     */
    private $result = 0.0;

    /**
     * @var \Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest $resultTest
     * 
     * @ORM\ManyToOne(targetEntity="ResultTest", inversedBy="resultQuestions")
     * @ORM\JoinColumn(name="result_test_id", referencedColumnName="id")
     */
    private $resultTest;

    /**
     * @var \Bstu\Bundle\TestOrganizationBundle\Entity\Question $question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;

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
     * Set resultTest
     *
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest $resultTest
     * @return ResultQuestion
     */
    public function setResultTest(ResultTest $resultTest = null)
    {
        $this->resultTest = $resultTest;

        return $this;
    }

    /**
     * Get resultTest
     *
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest 
     */
    public function getResultTest()
    {
        return $this->resultTest;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return ResultQuestion
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
     * Set result
     *
     * @param float $result
     * @return ResultQuestion
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return float 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set question
     *
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\Question $question
     * @return ResultQuestion
     */
    public function setQuestion(Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}

<?php

namespace Bstu\Bundle\TestOrganizationBundle\Verifier;

use Bstu\Bundle\TestOrganizationBundle\Entity\Question;
use Bstu\Bundle\TestOrganizationBundle\Entity\ResultQuestion;
use Bstu\Bundle\TestOrganizationBundle\Distance\DistanceCalculatorInterface;

class QuestionVerifier
{
    /**
     * Damerau-Levenshtein distance calculator
     *
     * @var \Bstu\Bundle\TestOrganizationBundle\Distance\DistanceCalculatorInterface $dld
     */
    protected $dld;
    
    /**
     * Constructor
     * 
     * @param \Bstu\Bundle\TestOrganizationBundle\Distance\DistanceCalculatorInterface $dld
     */
    public function __construct(DistanceCalculatorInterface $dld)
    {
        $this->dld = $dld;
    }
    
    /**
     * check the answer
     * 
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\ResultQuestion $resultQuestion
     * @return real
     */
    public function verify(ResultQuestion $resultQuestion)
    {
        $studentAnswer = $resultQuestion->getAnswer();
        $question = $resultQuestion->getQuestion();
        $realAnswer = $question->getAnswer();
        
        switch ($question->getType()) {
            case Question::TYPE_TEXT:
                $distance = $this->dld->calculate($realAnswer, $studentAnswer);
                $realAnswerLength = strlen($realAnswer);
                if ($distance < $realAnswerLength && $distance / $realAnswerLength <= 0.3) {
                    return 1 - $distance / $realAnswerLength;
                }
                return 0.0;
        }
        
        return floatval($studentAnswer === $realAnswer);
    }
}

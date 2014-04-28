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
                
            case Question::TYPE_LOGIC_SEQUENCE:
                $result = 0;
                $variants = array_values($question->getVariants());
                foreach (json_decode($studentAnswer) as $id => $answer) {
                    $result += intval($answer === $variants[$id]);
                }
                return $result / intval($realAnswer);
                
            case Question::TYPE_CHECKBOX:
                $realAnswerArray = explode(',', $question->getAnswer());
                $studentAnswerArray = explode(',', $question->getAnswer());
                if (count($studentAnswerArray) > $cntRealAnswer = count($realAnswerArray)) {
                    return 0.0;
                }
                foreach ($studentAnswer as $ans) {
                    $idx = array_search($ans, $realAnswerArray, true);
                    if (false === $idx) {
                        return 0.0;
                    }              
                    unset($realAnswerArray[$idx]);
                }
                return ($cntRealAnswer - count($realAnswerArray)) / $cntRealAnswer;
        }
        
        return floatval($studentAnswer === $realAnswer);
    }
}

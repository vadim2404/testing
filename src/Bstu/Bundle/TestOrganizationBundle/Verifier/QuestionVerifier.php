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
     * @param  \Bstu\Bundle\TestOrganizationBundle\Entity\ResultQuestion $resultQuestion
     * @return real
     */
    public function verify(ResultQuestion $resultQuestion)
    {
        $studentAnswer = $resultQuestion->getAnswer();
        $question = $resultQuestion->getQuestion();
        $realAnswer = $question->getAnswer();

        if (is_null($studentAnswer)) {
            return 0.0;
        }

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
                $studentAnswerArray = explode(',', $studentAnswer);
                $cntRightAnswer = count($realAnswerArray);
                $cntWrongAnswer = count($question->getVariants()) - $cntRightAnswer;
                $wrong = $right = 0;
                foreach ($studentAnswerArray as $ans) {
                    if (in_array($ans, $realAnswerArray, true)) {
                        ++$right;
                    } else {
                        ++$wrong;
                    }
                }
                $tmpResult = $right / $cntRightAnswer - $wrong / $cntWrongAnswer;
                return 0 > $tmpResult ? 0 : $tmpResult;

            case Question::TYPE_PAIRED:
                $variants = [];
                foreach ($question->getVariants() as $variant) {
                    $row = json_decode($variant, true);
                    $variants[key($row)] = current($row);
                }
                $studentAnswerDecoded = json_decode($studentAnswer, true);
                $result = 0;
                foreach ($studentAnswerDecoded['keys'] as $idx => $key) {
                    $result += intval($variants[$key] === $studentAnswerDecoded['values'][$idx]);
                }

                return $result / count($variants);
        }

        return floatval($studentAnswer === $realAnswer);
    }
}

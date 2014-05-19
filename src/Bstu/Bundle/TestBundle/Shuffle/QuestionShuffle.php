<?php

namespace Bstu\Bundle\TestBundle\Shuffle;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Bstu\Bundle\PlanBundle\Entity\Plan;
use Bstu\Bundle\TestOrganizationBundle\Entity\Test;
use Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest;
use Bstu\Bundle\TestOrganizationBundle\Entity\ResultQuestion;

class QuestionShuffle
{
    const COMPLEXITY_ITERATIONS = 10;

    /**
     * Security context
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface $securityContext
     */
    private $securityContext;

    /**
     * Entity repository
     *
     * @var \Doctrine\ORM\EntityManagerInterface $em
     */
    private $em;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $security
     * @param \Doctrine\ORM\EntityManagerInterface                      $em
     */
    public function __construct(SecurityContextInterface $security, EntityManagerInterface $em)
    {
        $this->securityContext = $security;
        $this->em = $em;
    }

    /**
     * shuffle questions from test
     *
     * @param  \Bstu\Bundle\TestOrganizationBundle\Entity\Plan       $plan
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest
     * @throws AccessDeniedException
     */
    public function shuffle(Plan $plan)
    {
        if (!$this->securityContext->isGranted('ROLE_STUDENT')) {
            throw new AccessDeniedException('Only students can use question shuffle');
        }

        $test = $plan->getTest();
        $questions = [];
        foreach ($test->getThemes() as $theme) {
            foreach ($theme->getQuestions() as $question) {
                $questions[] = $question;
            }
        }

        $result = new ResultTest();
        $result->setStudent($this->securityContext->getToken()->getUser())
            ->setTest($test)
            ->setPlan($plan)
        ;

        switch ($test->getType()) {
            case Test::TYPE_RANDOM:
                shuffle($questions);
                for ($i = 0, $cm = $test->getMaxQuestions(); $i < $cm; ++$i) {
                    $resultQuestion = new ResultQuestion();
                    $resultQuestion->setQuestion($questions[$i])
                        ->setResultTest($result)
                    ;
                    $result->addResultQuestion($resultQuestion);
                }
                break;

            case Test::TYPE_RANDOM_WITH_COMPLEXITY:
                $heap = new \SplMinHeap();
                $saved = [];
                for ($iteration = 0; $iteration < self::COMPLEXITY_ITERATIONS; ++$iteration) {
                    shuffle($questions);
                    $complexity = 0;
                    $saved[$iteration] = [];
                    for ($i = 0, $cm = $test->getMaxQuestions(); $i < $cm; ++$i) {
                        $complexity += $questions[$i]->getRate();
                        $saved[$iteration][] = $questions[$i];
                    }
                    $heap->insert([abs($test->getComplexity() - $complexity), $iteration]);
                }
                $minNode = $heap->extract();
                foreach ($saved[$minNode[1]] as $question) {
                    $resultQuestion = new ResultQuestion();
                    $resultQuestion->setQuestion($question)
                        ->setResultTest($result)
                    ;
                    $result->addResultQuestion($resultQuestion);
                }
                break;

            case Test::TYPE_VARIANT:
                $variants = $test->getVariants()->toArray();
                shuffle($variants);
                foreach ($variants[0]->getQuestions() as $question) {
                    $resultQuestion = new ResultQuestion();
                    $resultQuestion->setQuestion($question)
                        ->setResultTest($result)
                    ;
                    $result->addResultQuestion($resultQuestion);
                }
                break;
        }

        $this->em->persist($result);
        $this->em->flush();

        return $result;
    }

}

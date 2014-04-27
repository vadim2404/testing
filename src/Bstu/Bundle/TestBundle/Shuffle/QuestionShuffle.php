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
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(SecurityContextInterface $security, EntityManagerInterface $em)
    {
        $this->securityContext = $security;
        $this->em = $em;
    }


    /**
     * shuffle questions from test
     *
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\Plan $plan
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

        if (Test::TYPE_RANDOM === $test->getType()) {
            shuffle($questions);
            for ($i = 0; $i < $test->getMaxQuestions(); ++$i) {
                $resultQuestion = new ResultQuestion();
                $resultQuestion->setQuestion($questions[$i])
                    ->setResultTest($result)
                ;
                $result->addResultQuestion($resultQuestion);
            }
        }

        $this->em->persist($result);
        $this->em->flush();

        return $result;
    }

}

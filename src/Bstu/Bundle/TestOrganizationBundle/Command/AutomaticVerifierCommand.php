<?php

namespace Bstu\Bundle\TestOrganizationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AutomaticVerifierCommand extends ContainerAwareCommand
{
    const INTERVAL_IN_SECONDS = 10;
    
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('bstu:test-org:verify')
            ->setDescription('Daemon that verified results in automatic mode')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        
        $verifier = $container->get('bstu_test_organization.verifier.question_verifier');
        $formFactory = $container->get('form.factory');
        $em = $container->get('doctrine.orm.entity_manager');
        
        $repository = $em->getRepository('BstuTestOrganizationBundle:ResultTest');
        
        while (true) {
            $results = $repository->findUnverifiedAutomaticTest()
                ->getQuery()
                ->execute()
            ;
            foreach ($results as $result) {
                $form = $formFactory->create('bstu_bundle_testorganizationbundle_resulttest', $result, [
                    'csrf_protection' => false,
                ]);
                
                $input = [
                    'resultQuestions' => [],
                ];
                
                foreach ($result->getResultQuestions() as $resultQuestion) {
                    $input['resultQuestions'][] = [
                        'result' => 100 * $verifier->verify($resultQuestion),
                    ];
                }
                
                $form->submit($input);
                
                if ($form->isValid()) {
                    $em->persist($result);
                }
            }
            $em->flush();
            
            sleep(self::INTERVAL_IN_SECONDS);
        }
    }

}

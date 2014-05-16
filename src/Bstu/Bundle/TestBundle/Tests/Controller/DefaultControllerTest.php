<?php

namespace Bstu\Bundle\TestBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $controller;
    protected $container;
    protected $request;
    protected $form;
    protected $doctrine;
    protected $em;
    protected $resultTest;
    protected $plan;
    
    protected function setUp()
    {
        $this->container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        
        $this->request = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        
        $this->form = $this->getMock('Symfony\Component\Form\FormInterface');

        $this->doctrine = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        
        $this->em = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $this->resultTest = $this->getMockBuilder('Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->plan = $this->getMockBuilder('Bstu\Bundle\PlanBundle\Entity\Plan')
            ->disableOriginalConstructor()
            ->getMock()
        ;


        $this->controller = $this->getMockBuilder('Bstu\Bundle\TestBundle\Controller\DefaultController')
            ->setMethods(['createResultForm'])
            ->disableOriginalConstructor()
            ->getMock()
        ;
        
        $this->controller->setContainer($this->container);
    }
    
    public function testCatchAnswerAction()
    {
        $this->request->expects($this->once())
            ->method('isXmlHttpRequest')
            ->will($this->returnValue(true))
        ;

        $this->resultTest->expects($this->once())
            ->method('getPlan')
            ->will($this->returnValue($this->plan))
        ;

        $this->plan->expects($this->once())
            ->method('isFinished')
            ->will($this->returnValue(false))
        ;

        $this->controller->expects($this->once())
            ->method('createResultForm')
            ->with($this->identicalTo($this->resultTest))
            ->will($this->returnValue($this->form))
        ;

        $this->form->expects($this->once())
            ->method('handleRequest')
            ->with($this->identicalTo($this->request))
        ;

        $this->form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true))
        ;

        $this->container->expects($this->once())
            ->method('has')
            ->with($this->equalTo('doctrine'))
            ->will($this->returnValue(true))
        ;

        $this->container->expects($this->once())
            ->method('get')
            ->with($this->equalTo('doctrine'))
            ->will($this->returnValue($this->doctrine))
        ;

        $this->doctrine->expects($this->once())
            ->method('getManager')
            ->will($this->returnValue($this->em))
        ;

        $this->em->expects($this->once())
            ->method('persist')
            ->with($this->identicalTo($this->resultTest))
        ;

        $this->em->expects($this->once())
            ->method('flush')
        ;

        $response = $this->controller->catchAnswerAction($this->request, $this->resultTest);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('', $response->getContent());
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

}

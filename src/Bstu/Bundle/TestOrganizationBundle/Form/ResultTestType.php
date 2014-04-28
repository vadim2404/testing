<?php

namespace Bstu\Bundle\TestOrganizationBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Bstu\Bundle\TestBundle\Form\ResultTestType as BaseResultTestType;

class ResultTestType extends BaseResultTestType
{
    const RESULT_QUESTIONT_TYPE = 'bstu_bundle_testorganizationbundle_resultquestion';
    
    protected $router;
    
    /**
     * Constructor
     * 
     * @param \Symfony\Component\Routing\Generator\UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }
    
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->setAction($this->router->generate('teacher_submit_result_verify_test', [
                'id' => $options['data']->getId(),
            ]))
            ->add('submit', 'submit', [
                'label' => 'Verify',
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                $resultTest = $event->getData();
                $sum = $cnt = 0;
                foreach ($resultTest->getResultQuestions() as $resultQuestion) {
                    $rate = $resultQuestion->getQuestion()->getRate();
                    $sum += $rate * $resultQuestion->getResult();
                    $cnt += $rate;
                }
                $resultTest->setRating($sum / $cnt);
                $resultTest->setVerified(true);
            })
        ;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        
        $resolver->setDefaults([
            'csrf_protection' => true,
            'method' => 'POST',
        ]);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'bstu_bundle_testorganizationbundle_resulttest';
    }
}

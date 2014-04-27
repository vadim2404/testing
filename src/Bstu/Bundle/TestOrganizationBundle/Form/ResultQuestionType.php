<?php

namespace Bstu\Bundle\TestOrganizationBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Bstu\Bundle\TestBundle\Form\ResultQuestionType as BaseResultQuestionType;
use Bstu\Bundle\TestOrganizationBundle\Verifier\QuestionVerifier;

class ResultQuestionType extends BaseResultQuestionType
{
    /**
     * Question verifier
     *
     * @var \Bstu\Bundle\TestOrganizationBundle\Verifier\QuestionVerifier $verifier
     */
    protected $verifier;
    
    /**
     * Constructor
     * 
     * @param \Bstu\Bundle\TestOrganizationBundle\Verifier\QuestionVerifier $verifier
     */
    public function __construct(QuestionVerifier $verifier)
    {
        parent::__construct();
        
        $this->verifier = $verifier;
    }

    
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $item = $this->getItem($options);
        $builder
            ->add('result', 'percent', [
                'precision' => 2,
                'data' => $this->verifier->verify($item),
            ])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'bstu_bundle_testorganizationbundle_resultquestion';
    }
}

<?php

namespace Bstu\Bundle\TestOrganizationBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Bstu\Bundle\TestBundle\Form\ResultQuestionType as BaseResultQuestionType;

class ResultQuestionType extends BaseResultQuestionType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $item = $this->getItem($options);
        $builder
            ->add('result', 'percent', [
                'precision' => 2,
                'data' => $item->getQuestion()->verify($item->getAnswer()),
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

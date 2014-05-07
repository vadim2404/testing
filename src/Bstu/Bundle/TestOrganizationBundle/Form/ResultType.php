<?php

namespace Bstu\Bundle\TestOrganizationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResultType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'question',
            'real_answer',
            'student_answer',
            'question_type',
        ])->setOptional([
            'variants',
        ])->setAllowedTypes([
            'question' => 'string',
            'real_answer' => 'string',
            'student_answer' => ['null', 'string'],
            'variants' => ['null', 'array'],
            'question_type' => 'integer',
        ])->setDefaults([
            'variants' => null,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['question'] = $options['question'];
        $view->vars['real_answer'] = $options['real_answer'];
        $view->vars['student_answer'] = $options['student_answer'];
        $view->vars['variants'] = $options['variants'];
        $view->vars['question_type'] = $options['question_type'];
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'percent';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'result';
    }
}

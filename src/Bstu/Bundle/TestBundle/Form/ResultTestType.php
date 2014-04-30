<?php

namespace Bstu\Bundle\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResultTestType extends AbstractType
{
    const RESULT_QUESTIONT_TYPE = 'bstu_bundle_testbundle_resultquestion';
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('resultQuestions', 'collection', [
                'label' => ' ',
                'type' => static::RESULT_QUESTIONT_TYPE,
                'options' => [
                    'items' => $options['data']->getResultQuestions(),
                ],
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest',
            'csrf_protection' => false,
        ))->setRequired([
            'data'
        ])->setAllowedTypes([
            'data' => 'Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bstu_bundle_testbundle_resulttest';
    }
}

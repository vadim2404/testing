<?php

namespace Bstu\Bundle\PlanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start', 'datetime', [
                'data' => new \DateTime('now'),
                'label' => 'Начало теста',
            ])
            ->add('end', 'datetime', [
                'data' => (new \DateTime('now'))->modify('+15 minute'),
                'label' => 'Конец теста',
            ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bstu\Bundle\PlanBundle\Entity\Plan'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bstu_bundle_planbundle_plan';
    }
}

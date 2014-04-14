<?php

namespace Bstu\Bundle\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Doctrine\Common\Collections\ArrayCollection;

class ResultQuestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $accessor = new PropertyAccessor();
        $item = $accessor->getValue($options['items'], $options['property_path']);
        $builder
            ->add('answer', null, [
                'label' => $item->getQuestion()->getQuestion(),
            ])
            ->add('send', 'button', [
                'attr' => [
                    'class' => 'js-answer-button',
                ]
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bstu\Bundle\TestOrganizationBundle\Entity\ResultQuestion',
            'csrf_protection' => false,
            'items' => new ArrayCollection(),
        ))->setRequired([
            'items',
        ])->setAllowedTypes([
            'items' => 'Doctrine\Common\Collections\Collection',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bstu_bundle_testorganizationbundle_resultquestion';
    }
}

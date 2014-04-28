<?php

namespace Bstu\Bundle\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Doctrine\Common\Collections\ArrayCollection;
use Bstu\Bundle\TestOrganizationBundle\Entity\Question;

class ResultQuestionType extends AbstractType
{
    protected $accessor;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->accessor = new PropertyAccessor();
    }
    
    /**
     * Get Result question
     * 
     * @param array $options
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\ResultQuestion
     */
    protected function getItem(array $options)
    {
        return $this->accessor->getValue($options['items'], $options['property_path']);
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $item = $this->getItem($options);
        
        $question = $item->getQuestion();
        
        switch ($question->getType()) {
            case Question::TYPE_TEXT:
                $builder->add('answer', 'text', [
                    'label' => $question->getQuestion(),
                ]);
                break;
            
            case Question::TYPE_TEXTAREA:
                $builder->add('answer', 'textarea', [
                    'label' => $question->getQuestion(),
                ]);
                break;
                
            case Question::TYPE_CHECKBOX:
                $builder->add('answer', 'choice', [
                    'label' => $question->getQuestion(),
                    'choices' => $question->getVariants(),
                    'multiple' => true,
                    'expanded' => true,
                ]);
                break;
            
            case Question::TYPE_RADIO:
                $builder->add('answer', 'choice', [
                    'label' => $question->getQuestion(),
                    'choices' => $question->getVariants(),
                    'multiple' => false,
                    'expanded' => true,
                ]);
                break;
            
            case Question::TYPE_LOGIC_SEQUENCE:
                $items = $question->getVariants();
                shuffle($items);
                $builder->add('answer', 'text', [
                    'label' => $question->getQuestion(),
                    'data' => $item->getAnswer() ? $item->getAnswer() : json_encode($items),
                    'attr' => [
                        'class' => 'js-logic-sequence',
                    ],
                ]);
                break;
        }         
        
        $builder ->add('send', 'button', [
            'attr' => [
                'class' => 'js-answer-button',
            ]
        ]);
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
        return 'bstu_bundle_testbundle_resultquestion';
    }
}

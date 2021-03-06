<?php

namespace Bstu\Bundle\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
     * @param  array                                                     $options
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\ResultQuestion
     */
    protected function getItem(array $options)
    {
        return $this->accessor->getValue($options['items'], $options['property_path']);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $item = $this->getItem($options);

        $question = $item->getQuestion();

        $defaultOptions = [
            'label' => $question->getQuestion(),
            'has_answer' => !is_null($item->getAnswer()),
        ];

        switch ($question->getType()) {
            case Question::TYPE_TEXT:
                $builder->add('answer', 'text', $defaultOptions);
                break;

            case Question::TYPE_TEXTAREA:
                $builder->add('answer', 'textarea', $defaultOptions);
                break;

            case Question::TYPE_CHECKBOX:
                $builder->add('answer', 'choice', array_merge($defaultOptions, [
                    'choices' => $question->getVariants(),
                    'multiple' => true,
                    'expanded' => true,
                    'data' => !is_null($item->getAnswer()) ? explode(',', $item->getAnswer()) : [],
                ]))->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                    $resultQuestion = $event->getData();
                    $resultQuestion->setAnswer(implode(',', $resultQuestion->getAnswer()));
                });
                break;

            case Question::TYPE_RADIO:
                $builder->add('answer', 'choice', array_merge($defaultOptions, [
                    'choices' => $question->getVariants(),
                    'multiple' => false,
                    'expanded' => true,
                    'data' => $item->getAnswer(),
                ]));
                break;

            case Question::TYPE_LOGIC_SEQUENCE:
                $items = $question->getVariants();
                shuffle($items);
                $builder->add('answer', 'text', array_merge($defaultOptions, [
                    'data' => $item->getAnswer() ? $item->getAnswer() : json_encode($items),
                    'attr' => [
                        'class' => 'js-logic-sequence',
                    ],
                ]));
                break;

            case Question::TYPE_PAIRED:
                $variants = $question->getVariants();
                $keys = $values = [];
                foreach ($variants as $variant) {
                    $obj = json_decode($variant, true);
                    $keys[] = key($obj);
                    $values[] = current($obj);
                }
                shuffle($keys);
                shuffle($values);
                $items = [
                    'keys' => $keys,
                    'values' => $values,
                ];
                $builder->add('answer', 'text', array_merge($defaultOptions, [
                    'data' => $item->getAnswer() ? $item->getAnswer() : json_encode($items),
                    'attr' => [
                        'class' => 'js-paired',
                    ],
                ]));
                break;
        }

        $builder ->add('send', 'button', [
            'label' => 'Отправить',
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

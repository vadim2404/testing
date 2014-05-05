<?php

namespace Bstu\Bundle\TestOrganizationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Bstu\Bundle\TestOrganizationBundle\Entity\Question;

class QuestionType extends AbstractType
{
    /**
     * Teacher instance
     *
     * @var \Bstu\Bundle\UserBundle\Entity\User $user
     */
    private $user;

    /**
     * User for form
     *
     * @param \Bstu\Bundle\UserBundle\Entity\User $user
     */
    public function __construct($user = null)
    {
        $this->user = $user;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $user = $this->user;
        $builder
            ->add('type', 'choice', [
                'label' => 'Тип вопроса',
                'multiple' => false,
                'expanded' => true,
                'required' => true,
                'choices' => [
                    Question::TYPE_TEXT => 'Однострочный ответ',
                    Question::TYPE_TEXTAREA => 'Многострочный ответ',
                    Question::TYPE_CHECKBOX => 'Выбор нескольких правильных ответов',
                    Question::TYPE_RADIO => 'Выбор одного правильного ответа',
                    Question::TYPE_LOGIC_SEQUENCE => 'Составление логической последовательности',
                    Question::TYPE_PAIRED => 'Парное соответствие',
                ],
                'attr' => [
                    'onchange' => 'rerenderCreateForm()',
                ],
            ])
            ->add('question', null, [
                'label' => 'Вопрос',
                'required' => true,
            ])
            ->add('rate', 'choice', [
                'label' => 'Сложность',
                'choices' => [
                    Question::COMPLEXITY_EASY => 'Простой',
                    Question::COMPLEXITY_MEDIUM => 'Средний',
                    Question::COMPLEXITY_HARD => 'Сложный',
                ],
                'multiple' => false,
                'expanded' => false,
                'required' => true,
            ])
            ->add('theme', null, [
                'label' => 'Тема',
                'required' => true,
                'property' => 'name',
                'query_builder' => function (EntityRepository $er) use($user) {
                    return $er->createQueryBuilder('t')
                        ->join('t.subject', 's')
                        ->where('s.teacher = ?1')
                        ->setParameter(1, $user)
                    ;
                },
                'group_by' => 'subject.name',
            ])
        ;

        if (!in_array($options['data']->getType(), [Question::TYPE_TEXT, Question::TYPE_TEXTAREA])) {
            $builder->add('variants', 'collection', [
                    'label' => 'Возможные варианты',
                    'required' => true,
                    'allow_delete' => true,
                    'allow_add' => true,
                ])
                ->add('answer', 'hidden', [
                    'required' => true,
                ])
            ;
        } else {
            $builder->add('answer', 'text', [
                'label' => 'Ответ',
                'required' => true,
            ]);
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Bstu\Bundle\TestOrganizationBundle\Entity\Question',
        ])->setRequired([
            'data',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bstu_bundle_testorganizationbundle_question';
    }
}

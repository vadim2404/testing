<?php

namespace Bstu\Bundle\TestOrganizationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Bstu\Bundle\TestOrganizationBundle\Form\EventListener\QuestionVariantsSubscriber;

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
        $constants = array_map(function ($item) {
            return strtolower(preg_replace('/^QUESTION_/', '', $item));
        }, array_flip((new \ReflectionClass('Bstu\Bundle\TestOrganizationBundle\Entity\Question'))
            ->getConstants()
        ));
        
        $user = $this->user;
        $builder
            ->add('question', null, [
                'required' => true,
            ])
            ->add('rate', 'choice', [
                'choices' => [
                    1 => 'Простой',
                    2 => 'Средний',
                    3 => 'Сложный',
                ],
                'multiple' => false,
                'expanded' => false,
                'required' => true,
            ])
            ->add('type', 'choice', [
                'multiple' => false,
                'expanded' => true,
                'required' => true,
                'choices' => $constants,
                'attr' => [
                    'onchange' => 'rerenderCreateForm()',
                ],
            ])
            ->add('theme', null, [
                'required' => true,
                'property' => 'name',
                'query_builder' => function (EntityRepository $er) use($user) {
                    return $er->createQueryBuilder('t')
                        ->join('t.subject', 's')
                        ->where('s.teacher = ?1')
                        ->setParameter(1, $user)
                    ;
                }
            ])
        ;

        $builder->addEventSubscriber(new QuestionVariantsSubscriber());
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bstu\Bundle\TestOrganizationBundle\Entity\Question'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bstu_bundle_testorganizationbundle_question';
    }
}

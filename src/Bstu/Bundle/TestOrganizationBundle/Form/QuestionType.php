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
        $user = $this->user;
        $builder
            ->add('question')
            ->add('answer')
            ->add('rate')
            ->add('type', 'hidden')
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

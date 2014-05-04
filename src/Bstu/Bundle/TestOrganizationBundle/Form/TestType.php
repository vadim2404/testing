<?php

namespace Bstu\Bundle\TestOrganizationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Bstu\Bundle\TestOrganizationBundle\Entity\Test;

class TestType extends AbstractType
{
    /**
     * Teacher object
     * 
     * @var \Bstu\Bundle\UserBundle\Entity\User $user
     */
    private $teacher;
    
    /**
     * Constructor
     * 
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $security
     */
    public function __construct(SecurityContextInterface $security)
    {
        $this->teacher = $security->getToken()->getUser();
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', [
                'label' => 'Тип теста',
                'required' => true,
                'choices' => [
                    Test::TYPE_VARIANT => 'Тест по вариантам',
                    Test::TYPE_RANDOM => 'Тест со случайными вопросами',
                    Test::TYPE_RANDOM_WITH_COMPLEXITY => 'Тест со случайными вопросами с учетом их сложности',
                ],
            ])
            ->add('title', null, [
                'label' => 'Название',
                'required' => true,
            ])
            ->add('automatic', null, [
                'label' => 'Тест будет проверен автоматически',
                'required' => false,
            ])
            ->add('maxQuestions', 'integer', [
                'label' => 'Максимальное число вопросов',
                'required' => true,
            ])
            ->add('complexity', 'integer', [
                'label' => 'Средняя сложность',
                'required' => true,
            ])
            ->add('subject', 'entity', [
                'label' => 'Предмет',
                'required' => true,
                'class' => 'BstuTestOrganizationBundle:Subject',
                'property' => 'name',
                'choices' => $this->teacher->getSubjects(),
                'attr' => [
                    'data-route' => 'subject_themes',
                    'data-test' => $options['data']->getId(),
                ]
            ])
            ->add('themes', null, [
                'label' => 'Темы',
                'required' => true,
                'property' => 'name',
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bstu\Bundle\TestOrganizationBundle\Entity\Test'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bstu_bundle_testorganizationbundle_test';
    }
}

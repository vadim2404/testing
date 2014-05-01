<?php

namespace Bstu\Bundle\TestOrganizationBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class FilterType extends AbstractType
{
    /**
     * Teacher
     *
     * @var \Bstu\Bundle\UserBundle\Entity\User $teacher
     */
    protected $teacher;
    
    /**
     * Router
     * 
     * @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface $router
     */
    protected $router;
    
    /**
     * Constructor
     * 
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $security
     * @param \Symfony\Component\Routing\Generator\UrlGeneratorInterface $router
     */
    public function __construct(SecurityContextInterface $security, UrlGeneratorInterface $router)
    {
        $this->teacher = $security->getToken()->getUser();
        $this->router = $router;
    }
    
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $teacher = $this->teacher;
        $builder->setAction($this->router->generate('teacher_result_verified'))
            ->add('test', 'entity', [
                'class' => 'Bstu\Bundle\TestOrganizationBundle\Entity\Test',
                'property' => 'title',
                'query_builder' => function (EntityRepository $er) use($teacher){
                    return $er->createQueryBuilder('t')
                        ->where('t.teacher = :teacher')
                        ->setParameter('teacher', $teacher)
                    ;
                },
                'label' => 'Тест',
                'required' => false,
            ])
            ->add('student', 'entity', [
                'class' => 'Bstu\Bundle\UserBundle\Entity\User',
                'property' => 'firstName',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.group', 'g')
                        ->where('g.name = :name')
                        ->setParameter('name', 'Студент')
                    ;
                },
                'label' => 'Студент',
                'required' => false,
            ])
            ->add('submit', 'submit', [
                'label' => 'Отфильтровать',
            ])
        ;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'bstu_bundle_testorganizationbundle_filter';
    }
}

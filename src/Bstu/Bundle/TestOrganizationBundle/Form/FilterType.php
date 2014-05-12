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
    const SEPTEMBER = 9;
    
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
     * @param \Symfony\Component\Security\Core\SecurityContextInterface  $security
     * @param \Symfony\Component\Routing\Generator\UrlGeneratorInterface $router
     * @param int $startedAt
     */
    public function __construct(SecurityContextInterface $security, UrlGeneratorInterface $router, $startedAt)
    {
        $this->teacher = $security->getToken()->getUser();
        $this->router = $router;
        $this->startedAt = $startedAt;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $teacher = $this->teacher;
        
        $now = new \DateTime('now');
        $currentYear = (int) $now->format('Y');
        
        $currentYear += (int) (self::SEPTEMBER <= (int) $now->format('m'));
        
        for ($i = $this->startedAt, $years = []; $i < $currentYear; ++$i) {
            $years[sprintf('%d-01-01 00:00:00/%d-08-31 23:59:59', $i, 1 + $i)] = sprintf('%d-%d', $i, 1 + $i);
        }
        
        $builder->setAction($this->router->generate('teacher_result_verified'))
            ->add('test', 'entity', [
                'class' => 'Bstu\Bundle\TestOrganizationBundle\Entity\Test',
                'property' => 'title',
                'query_builder' => function (EntityRepository $er) use ($teacher) {
                    return $er->createQueryBuilder('t')
                        ->where('t.teacher = :teacher')
                        ->setParameter('teacher', $teacher)
                    ;
                },
                'label' => 'Тест',
                'group_by' => 'subject.name',
                'required' => false,
            ])
            ->add('student', 'genemu_jqueryautocomplete_text', [
                'route_name' => 'user_students',
                'label' => 'Студент',
                'required' => false,
            ])
            ->add('period', 'choice', [
                'choices' => $years,
                'label' => 'Учебный год',
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

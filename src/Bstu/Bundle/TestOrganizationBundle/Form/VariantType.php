<?php

namespace Bstu\Bundle\TestOrganizationBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Bstu\Bundle\TestOrganizationBundle\Entity\Theme;

class VariantType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $test = $options['data']->getTest();
        
        $builder
            ->add('number', null, [
                'label' => 'Номер варианта',
            ])
            ->add('questions', 'entity', [
                'label' => 'Вопросы',
                'property' => 'question',
                'class' => 'Bstu\Bundle\TestOrganizationBundle\Entity\Question',
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) use ($test) {
                    return $er->createQueryBuilder('q')
                        ->where('q.teacher = :teacher')
                        ->andWhere('q.theme IN (:themes)')
                        ->setParameters([
                            'teacher' => $test->getTeacher(),
                            'themes' => $test->getThemes()->map(function (Theme $theme) {
                                return $theme->getId();
                            })->toArray(),
                        ])
                    ;
                },
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Bstu\Bundle\TestOrganizationBundle\Entity\Variant',
        ])->setRequired([
            'data',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bstu_bundle_testorganizationbundle_variant';
    }
}

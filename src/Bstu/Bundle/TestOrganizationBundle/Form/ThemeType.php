<?php

namespace Bstu\Bundle\TestOrganizationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ThemeType extends AbstractType
{
    /**
     * User
     * 
     * @var \Bstu\Bundle\UserBundle\Entity\User $user
     */
    private $user;

    /**
     * Set user for this form
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
            ->add('name')
            ->add('subject', null, [
                'property' => 'name',
                'required' => true,
                'query_builder' => function (EntityRepository $er) use($user) {
                    return $er->createQueryBuilder('s')
                        ->where('s.teacher = ?1')
                        ->setParameter(1, $user)
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
        $resolver->setDefaults(array(
            'data_class' => 'Bstu\Bundle\TestOrganizationBundle\Entity\Theme'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bstu_bundle_testorganizationbundle_theme';
    }
}

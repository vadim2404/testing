<?php

namespace Bstu\Bundle\FacultyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PulpitType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'required' => true,
                'label' => 'Название',
            ])
            ->add('faculty', null, [
                'property' => 'name',
                'required'  => true,
                'label' => 'Факультет',
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bstu\Bundle\FacultyBundle\Entity\Pulpit'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bstu_bundle_facultybundle_pulpit';
    }
}

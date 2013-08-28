<?php

namespace Bstu\Bundle\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class UserType extends BaseType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('firstName')
            ->add('lastName')
            ->add('middleName')
            ->add('pulpit', null, [
                'property' => 'name',
                'required' => true,
                'group_by' => 'faculty.name',
            ])
            ->add('group', null, [
                'property' => 'name',
                'required' => true,
            ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'bstu_bundle_userbundle_user';
    }
}

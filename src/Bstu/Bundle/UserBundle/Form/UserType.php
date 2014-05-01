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

        $builder->add('firstName', null, [
                'label' => 'Фамилия:',
            ])
            ->add('lastName', null, [
                'label' => 'Имя:',
            ])
            ->add('middleName', null, [
                'label' => 'Отчество:',
            ])
            ->add('pulpit', null, [
                'label' => 'Кафедра:',
                'property' => 'name',
                'required' => true,
                'group_by' => 'faculty.name',
            ])
            ->add('group', null, [
                'label' => 'Роль:',
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

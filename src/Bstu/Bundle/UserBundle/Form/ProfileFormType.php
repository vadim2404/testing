<?php

namespace Bstu\Bundle\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseProfileFormType;

class ProfileFormType extends BaseProfileFormType
{
    /**
     * {@inheritDoc}
     */
    protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildUserForm($builder, $options);

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
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'bstu_bundle_userbundle_profile';
    }

}

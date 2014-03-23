<?php

namespace Bstu\Bundle\TestOrganizationBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Bstu\Bundle\TestOrganizationBundle\Entity\Question;

class QuestionVariantsSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
        ];
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if ($data && !in_array($data->getType(), [Question::TYPE_TEXT, Question::TYPE_TEXTAREA])) {
            $form->add('variants', 'collection', [
                    'required' => true,
                    'allow_delete' => true,
                    'allow_add' => true,
                ])
                ->add('answer', 'hidden', [
                    'required' => true,
                ])
            ;
        } else {
            $form->add('answer', null, [
                'required' => true,
            ]);
        }
    }
}

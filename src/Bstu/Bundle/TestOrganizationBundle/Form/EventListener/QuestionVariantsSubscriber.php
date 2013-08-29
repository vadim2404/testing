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
        
        if ($data && !in_array($data->getType(), [Question::QUESTION_TEXT, Question::QUESTION_TEXTAREA])) {
            $form->add('variants');
        }
    }
}

<?php

namespace Bstu\Bundle\PlanBundle\Listener;

use Bstu\Bundle\PlanBundle\Entity\Plan;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\SecurityContextInterface;

class PlanListener
{
    /**
     * Security inteface for user getting
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface 
     */
    private $security;
    
    /**
     * Constructor
     * 
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $security
     */
    public function __construct(SecurityContextInterface $security)
    {
        $this->security = $security;
    }
    
    /**
     * Pre Persist action
     * 
     * @param \Bstu\Bundle\PlanBundle\Entity\Plan $plan
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     */
    public function prePersist(Plan $plan, LifecycleEventArgs $event)
    {
        $plan->setPlanedBy($this->security->getToken()->getUser());
    }
}

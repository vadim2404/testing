<?php

namespace Bstu\Bundle\TestOrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plan
 *
 * @ORM\Table(name="plan")
 * @ORM\Entity(repositoryClass="Bstu\Bundle\TestOrganizationBundle\Repository\PlanRepository")
 */
class Plan
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @Assert\DateTime(message="Дата и время заданы в неверном формате")
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var integer
     *
     * @Assert\Range(min="15", max="90", minMessage="Тест не может быть меньше 15 минут", maxMessage="Тест не может быть больше 90 минут")
     * @ORM\Column(name="period", type="smallint")
     */
    private $period;

    /**
     * @var \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     * 
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="plans")
     */
    private $test;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     * @return Plan
     */
    public function setStart(\DateTime $start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set period
     *
     * @param integer $period
     * @return Plan
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return integer 
     */
    public function getPeriod()
    {
        return $this->period;
    }
    
    /**
     * Get test
     * 
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set Test
     * 
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\Test $test
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Plan
     */
    public function setTest(Test $test)
    {
        $this->test = $test;
        
        return $this;
    }
}

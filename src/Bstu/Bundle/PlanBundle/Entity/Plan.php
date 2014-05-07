<?php

namespace Bstu\Bundle\PlanBundle\Entity;

use Bstu\Bundle\UserBundle\Entity\User;
use Bstu\Bundle\TestOrganizationBundle\Entity\Test;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plan
 *
 * @ORM\Table(
 *   name="plan",
 *   indexes = {
 *     @ORM\Index(name="plan_end", columns = { "end" })
 *  }
 * )
 * @ORM\Entity(repositoryClass="Bstu\Bundle\PlanBundle\Repository\PlanRepository")
 * @ORM\EntityListeners({ "Bstu\Bundle\PlanBundle\Listener\PlanListener" })
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
     * @Assert\DateTime(message="Дата и время заданы в неверном формате")
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;

    /**
     * @var \Bstu\Bundle\TestOrganizationBundle\Entity\Test
     *
     * @ORM\ManyToOne(targetEntity="\Bstu\Bundle\TestOrganizationBundle\Entity\Test", inversedBy="plans")
     */
    private $test;

    /**
     * @var \Bstu\Bundle\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\Bstu\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="planedby_id", referencedColumnName="id")
     */
    private $planedBy;

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
     * @param  \DateTime $start
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
     * Set end
     *
     * @param  \DateTime $end
     * @return Plan
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
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
     * @param  \Bstu\Bundle\TestOrganizationBundle\Entity\Test $test
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Plan
     */
    public function setTest(Test $test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Set planedBy
     *
     * @param  \Bstu\Bundle\UserBundle\Entity\User             $planedBy
     * @return \Bstu\Bundle\TestOrganizationBundle\Entity\Plan
     */
    public function setPlanedBy(User $planedBy)
    {
        $this->planedBy = $planedBy;

        return $this;
    }

    /**
     * Get planedBy
     *
     * @return \Bstu\Bundle\UserBundle\Entity\User
     */
    public function getPlanedBy()
    {
        return $this->planedBy;
    }

    /**
     * Is test finished?
     *
     * @return bool
     */
    public function isFinished()
    {
        return $this->end < new \DateTime('now');
    }

    /**
     * @Assert\True(message="Дата окончания теста должна быть больше даты начала теста минимум на 15 минут")
     *
     * @return bool
     */
    public function isEndGteStartAbove15()
    {
        return 15 <= $this->end->diff($this->start)->i;
    }

    /**
     * @Assert\True(message="Дата окончания теста должна быть больше даты начала теста максимум на 1,5 часа")
     *
     * @return bool
     */
    public function isEndGteStartBelow90()
    {
        return 90 >= $this->end->diff($this->start)->i;
    }

    /**
     * @Assert\True(message="В тесте недостаточное число вопросов")
     *
     * @return bool
     */
    public function isTestHasQuestions()
    {
        if (!$this->test->isTestByVariants()) {
            $maxQuestions = $this->test->getMaxQuestions();
            foreach ($this->test->getThemes() as $theme) {
                $maxQuestions -= $theme->getQuestions()->count();
            }

            return 0 >= $maxQuestions;
        }

        return true;
    }

    /**
     * @Assert\True(message="В тесте нет вариантов")
     *
     * @return bool
     */
    public function isTestHasVariants()
    {
        if ($this->test->isTestByVariants()) {
            return !$this->test->getVariants()->isEmpty();
        }

        return true;
    }
}

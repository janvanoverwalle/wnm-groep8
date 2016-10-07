<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 30/09/16
 * Time: 16:01
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="habit_reached")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HabitReachedRepository")
 */
class HabitReached
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="user",
     *
    inversedBy="habit_reached")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="habit",
     *
    inversedBy="habit_reached")
     */
    private $habit_id;

    /**
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\Column(name="is_reached", type="boolean", nullable=false)
     */
    private $is_reached;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return HabitReached
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set isReached
     *
     * @param boolean $isReached
     *
     * @return HabitReached
     */
    public function setIsReached($isReached)
    {
        $this->is_reached = $isReached;

        return $this;
    }

    /**
     * Get isReached
     *
     * @return boolean
     */
    public function getIsReached()
    {
        return $this->is_reached;
    }

    /**
     * Set userId
     *
     * @param \AppBundle\Entity\user $userId
     *
     * @return HabitReached
     */
    public function setUserId(\AppBundle\Entity\user $userId = null)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \AppBundle\Entity\user
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set habitId
     *
     * @param \AppBundle\Entity\habit $habitId
     *
     * @return HabitReached
     */
    public function setHabitId(\AppBundle\Entity\habit $habitId = null)
    {
        $this->habit_id = $habitId;

        return $this;
    }

    /**
     * Get habitId
     *
     * @return \AppBundle\Entity\habit
     */
    public function getHabitId()
    {
        return $this->habit_id;
    }
}

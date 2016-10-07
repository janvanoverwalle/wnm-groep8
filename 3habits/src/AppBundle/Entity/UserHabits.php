<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 30/09/16
 * Time: 16:23
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserHabits
 *
 * @ORM\Table(name="user_habits", indexes={@ORM\Index(name="user_id", columns={"user_id"}), @ORM\Index(name="habit_id", columns={"habit_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserHabitsRepository")
 */
class UserHabits
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Habit
     *
     * @ORM\ManyToOne(targetEntity="Habit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="habit_id", referencedColumnName="id")
     * })
     */
    private $habit;

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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserHabits
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set habit
     *
     * @param \AppBundle\Entity\Habit $habit
     *
     * @return UserHabits
     */
    public function setHabit(\AppBundle\Entity\Habit $habit = null)
    {
        $this->habit = $habit;

        return $this;
    }

    /**
     * Get habit
     *
     * @return \AppBundle\Entity\Habit
     */
    public function getHabit()
    {
        return $this->habit;
    }
}

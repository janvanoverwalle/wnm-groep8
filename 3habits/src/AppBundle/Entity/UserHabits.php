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
}
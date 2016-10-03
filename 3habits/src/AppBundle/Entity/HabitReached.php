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
}
<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 30/09/16
 * Time: 16:00
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="calories")
 */
class Calories
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="user",
     *
    inversedBy="calories")
     */
    private $user_id;

    /**
     * @ORM\Column(name="calories", type="integer", nullable=false)
     */
    private $calories;

    /**
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;
}
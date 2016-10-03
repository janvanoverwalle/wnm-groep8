<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 30/09/16
 * Time: 15:48
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="habit")
 */
class Habit
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;
}
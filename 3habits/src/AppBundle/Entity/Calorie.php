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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CalorieRepository")
 */
class Calorie
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
     * @ORM\Column(name="calories", type="float", nullable=false)
     */
    private $calories;

    /**
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

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
     * Set calories
     *
     * @param integer $calories
     *
     * @return Calorie
     */
    public function setCalories($calories)
    {
        $this->calories = $calories;

        return $this;
    }

    /**
     * Get calories
     *
     * @return integer
     */
    public function getCalories()
    {
        return $this->calories;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Calorie
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
     * Set userId
     *
     * @param \AppBundle\Entity\user $userId
     *
     * @return Calorie
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
}

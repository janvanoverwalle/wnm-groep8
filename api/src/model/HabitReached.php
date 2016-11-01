<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 1/11/16
 * Time: 10:40
 */

namespace model;


class HabitReached
{
    private $id;
    private $habitId;
    private $description;
    private $date;
    private $isReached;

    /**
     * HabitReached constructor.
     * @param $id
     * @param $habitId
     * @param $date
     * @param $isReached
     */
    public function __construct($id = NULL, $habitId = NULL, $description = NULL, $date = NULL, $isReached = NULL)
    {
        $this->id = $id;
        $this->habitId = $habitId;
        $this->description = $description;
        $this->date = $date;
        $this->isReached = $isReached;
    }

    /**
     * @return mixed
     * @description access for JSON
     */
    public function expose() {
        return get_object_vars($this);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getHabitId()
    {
        return $this->habitId;
    }

    /**
     * @param mixed $habitId
     */
    public function setHabitId($habitId)
    {
        $this->habitId = $habitId;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getIsReached()
    {
        return $this->isReached;
    }

    /**
     * @param mixed $isReached
     */
    public function setIsReached($isReached)
    {
        $this->isReached = $isReached;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}
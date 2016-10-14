<?php

/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 11/10/16
 * Time: 21:47
 */
class Habit
{
    private $id;
    private $description;

    /**
     * Habit constructor.
     * @param $id
     * @param $description
     */
    public function __construct($id = NULL, $description = NULL)
    {
        $this->id = $id;
        $this->description = $description;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }



}
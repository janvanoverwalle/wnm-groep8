<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 11/10/16
 * Time: 21:49
 */
 
namespace model;

class Calories
{
    private $id;
    private $calories;
    private $date;

    /**
     * Calories constructor.
     * @param $id
     * @param $calories
     * @param $date
     */
    public function __construct($id = NULL, $calories = NULL, $date = NULL)
    {
        $this->id = $id;
        $this->calories = $calories;
        $this->date = $date;
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
    public function getCalories()
    {
        return $this->calories;
    }

    /**
     * @param mixed $calories
     */
    public function setCalories($calories)
    {
        $this->calories = $calories;
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


}
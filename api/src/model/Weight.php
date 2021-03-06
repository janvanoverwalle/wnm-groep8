<?php

/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 11/10/16
 * Time: 21:58
 */
 
 namespace model;
 
class Weight
{
    private $id;
    private $weight;
    private $date;

    /**
     * Weight constructor.
     * @param $id
     * @param $weight
     * @param $date
     */
    public function __construct($id = NULL, $weight = NULL, $date = NULL)
    {
        $this->id = $id;
        $this->weight = $weight;
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
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
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
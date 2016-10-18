<?php

/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 11/10/16
 * Time: 21:45
 */
 
namespace model;

class User
{
    private $id;
    private $name;

    /**
     * User constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id = NULL, $name = NULL, $habits = NULL)
    {
        $this->id = $id;
        $this->name = $name;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
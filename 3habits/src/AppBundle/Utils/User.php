<?php

namespace AppBundle\Utils;

class User {
	private $id, $name;
	
	public function __construct()
	{
		$this->id = -1;
		$this->name = "";
	}
	
	public function __toString()
	{
		return $this->name;
	}

	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function setId($id)
	{
		$this->id=$id;
	}
	
	public function setName($name)
	{
		$this->name=$name;
	}
}

?>
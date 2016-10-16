<?php

namespace model;

interface UserRepository
{
    public function findUserById($id);
	public function findAllUsers();
	public function insertUser($user);
}

?>
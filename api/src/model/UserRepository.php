<?php

namespace model;

interface UserRepository
{
    public function findUserById($id);
	public function findAllUsers();
	public function insertUser(User $user);
    public function deleteUserById($id);
    public function updateUserById(User $user);
}
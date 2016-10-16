<?php

namespace controller;

use model\UserRepository;
use view\View;

class UserController {
	
	private $userRepository;
    private $view;
	
	public function __construct(UserRepository $userRepository, View $view) {
        $this->userRepository = $userRepository;
        $this->view = $view;
    }
	
	public function handleFindUserById($id = null) {
		if ($id == null) {
			return;
		}
		
		$user = $this->userRepository->findUserById($id);
		
		if ($user != null) {
			$this->view->show(array('user' => $user));
		}
    }
	
	public function handleFindAllUsers() {
		$users = $this->userRepository->findAllUsers();
		
		if ($users != null) {
			$this->view->show(array('users' => $users));
		}
	}
	
	public function handleInsertUser($user = null) {
		if ($user == null) {
			return;
		}
		
		//TODO: implement
	}
	
}

?>
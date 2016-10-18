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
		
		$this->view->show(array('user' => $user));
    }
	
	public function handleFindAllUsers() {
		$users = $this->userRepository->findAllUsers();
		
		$this->view->show(array('users' => $users));
	}
	
	public function handleInsertUser($user = null) {
		if ($user == null) {
			return;
		}
		
		$user = $this->userRepository->insertUser($user);
		
		$this->view->show(array('new_user' => $user));
	}
	
	public function handleDeleteUserById($id = null) {
		if ($id == null) {
			return;
		}
		
		$user = $this->userRepository->deleteUserById($id);
		
		$this->view->show(array('deleted_user' => $user));
	}
	
	public function handleUpdateUserById($user = null) {
		if ($user == null) {
			return;
		}
		
		$user = $this->userRepository->updateUserById($user);
		
		$this->view->show(array('updated_user' => $user));
	}
}

?>
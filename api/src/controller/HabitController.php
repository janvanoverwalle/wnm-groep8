<?php

namespace controller;

use model\HabitRepository;
use view\View;

class HabitController {
	
	private $habitRepository;
    private $view;
	
	public function __construct(HabitRepository $habitRepository, View $view) {
        $this->habitRepository = $habitRepository;
        $this->view = $view;
    }
	
	public function handleFindHabitById($id = null) {
		if ($id == null) {
			return;
		}
		
		$habit = $this->habitRepository->findHabitById($id);
		
		$this->view->show(array('habit' => $habit));
    }
	
	public function handleFindAllHabits() {
		$habits = $this->habitRepository->findAllHabits();
		
		$this->view->show(array('habits' => $habits));
    }
	
	public function handleFindHabitsByUserId($uid) {
		$habits = $this->habitRepository->findHabitsByUserId($uid);
		
		$this->view->show(array('habits' => $habits));
	}
	
	public function handleFindHabitByIdAndUserId($hid, $uid) {
		$habit = $this->habitRepository->findHabitByIdAndUserId($hid, $uid);
		
		$this->view->show(array('habit' => $habit));
	}
	
	public function handleFindHabitsReachedByUserId($uid) {
		
	}
}

?>
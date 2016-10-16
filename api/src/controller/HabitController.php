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
	
	public function handleFindAllHabits() {
		$habits = $this->habitRepository->findAllHabits();
		
		if ($habits != null) {
			$this->view->show(array('habits' => $habits));
		}
    }
	
	public function handleFindHabitsByUserId($uid) {
		
	}
	
	public function handleFindHabitsReachedByUserId($uid) {
		
	}
}

?>
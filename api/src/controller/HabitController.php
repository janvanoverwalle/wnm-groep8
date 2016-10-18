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
	
	public function handleInsertHabit($habit = null) {
		if ($habit == null) {
			return;
		}
		
		$habit = $this->habitRepository->insertHabit($habit);
		
		$this->view->show(array('habit' => $habit));
	}
	
	public function handleInsertUserHabit($uid = null, $hid = null) {
		if ($uid == null or $hid == null) {
			return;
		}
		
		$habit = $this->habitRepository->insertUserHabit($uid, $hid);
		
		$this->view->show(array('habit' => $habit));
	}
	
	public function handleDeleteHabitById($id = null) {
		if ($id == null) {
			return;
		}
		
		$habit = $this->habitRepository->deleteHabitById($id);
		
		$this->view->show(array('habit' => $habit));
	}
	
	public function handleDeleteHabitByIdAndUserId($hid = null, $uid = null) {
		if ($uid == null or $hid == null) {
			return;
		}
		
		$habit = $this->habitRepository->deleteHabitByIdAndUserId($hid, $uid);
		
		$this->view->show(array('habit' => $habit));
	}
	
	public function handleUpdateHabitById($habit = null) {
		if ($habit == null) {
			return;
		}
		
		$habit = $this->habitRepository->updateHabitById($habit);
		
		$this->view->show(array('habit' => $habit));
	}
	
	public function handleUpdateHabitByIdAndUserId($uid = null, $oldHId = null, $newHId = null) {
		if ($id == null or $oldHId == null or $newHId == null) {
			return;
		}
		
		$habit = $this->habitRepository->updateHabitByIdAndUserId($uid, $oldHId, $newHId);
		
		$this->view->show(array('habit' => $habit));
	}
}

?>
<?php

namespace controller;

use model\HabitReached;
use model\HabitRepository;
use view\View;
use model\Habit;

class HabitController
{

    private $habitRepository;
    private $view;

    public function __construct(HabitRepository $habitRepository, View $view)
    {
        $this->habitRepository = $habitRepository;
        $this->view = $view;
    }

    public function handleFindHabitById($id = null)
    {
        if ($id == null) {
            return;
        }

        $habit = $this->habitRepository->findHabitById($id);

        $this->view->show(array('habit' => $habit));
    }

    public function handleFindAllHabits()
    {
        $habits = $this->habitRepository->findAllHabits();

        $this->view->show(array('habits' => $habits));
    }

    public function handleFindHabitsByUserId($uid)
    {
        $habits = $this->habitRepository->findHabitsByUserId($uid);

        $this->view->show(array('habits' => $habits));
    }

    public function handleFindHabitByIdAndUserId($hid, $uid)
    {
        $habit = $this->habitRepository->findHabitByIdAndUserId($hid, $uid);

        $this->view->show(array('habit' => $habit));
    }

    public function handleFindHabitsReachedByUserId($uid)
    {
        $habits = $this->habitRepository->findHabitsReachedByUserId($uid);

        $this->view->show(array('habits_status' => $habits));
    }

    public function handleInsertHabit($habit = null)
    {
        $habitModel = new Habit(-1, $habit);

        $habitModel = $this->habitRepository->insertHabit($habitModel);

        $this->view->show(array('habit' => $habitModel));
    }

    public function handleInsertUserHabit($uid = null, $hid = null)
    {
        if ($uid == null or $hid == null) {
            return;
        }

        $habit = $this->habitRepository->insertUserHabit($uid, $hid);

        $this->view->show(array('habit' => $habit));
    }

    public function handleInsertHabitsReached($habit = null)
    {
        $habitModel = new HabitReached(-1, $habit->habit_id, NULL, $habit->date, $habit->is_reached);

        $habitModel = $this->habitRepository->insertHabitReached($habitModel, $habit->user_id);

        $this->view->show(array('habit_status' => $habitModel));
    }

    public function handleDeleteHabitById($id = null)
    {
        if ($id == null) {
            return;
        }

        $habit = $this->habitRepository->deleteHabitById($id);

        $this->view->show(array('habit' => $habit));
    }

    public function handleDeleteHabitByIdAndUserId($hid = null, $uid = null)
    {
        if ($uid == null or $hid == null) {
            return;
        }

        $habit = $this->habitRepository->deleteHabitByIdAndUserId($hid, $uid);

        $this->view->show(array('habit' => $habit));
    }

    public function handleUpdateHabitById($habit = null)
    {
        $habitModel = new Habit($habit->id, $habit->description);

        $habitModel = $this->habitRepository->updateHabitById($habitModel);

        $this->view->show(array('habit' => $habitModel));
    }

    public function handleUpdateHabitByIdAndUserId($uid = null, $oldHId = null, $newHId = null)
    {
        if ($uid == null or $oldHId == null or $newHId == null) {
            return;
        }

        $habit = $this->habitRepository->updateHabitByIdAndUserId($uid, $oldHId, $newHId);

        $this->view->show(array('habit' => $habit));
    }

    public function handleUpdateHabitsReached($habit)
    {
        $habitModel = new HabitReached($habit->id, NULL, NULL, NULL, $habit->is_reached);

        $habitModel = $this->habitRepository->updateHabitReached($habitModel);

        $this->view->show(array('habit_status' => $habitModel));
    }
}
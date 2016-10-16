<?php

namespace model;

interface HabitRepository
{
    public function findHabitById($id);
    public function findAllHabits();
    public function findHabitsByUserId($uid);
    public function findHabitByIdAndUserId($hid, $uid);
    public function findHabitsReachedByUserId($uid);
}

?>
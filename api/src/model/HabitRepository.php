<?php

namespace model;

interface HabitRepository
{
    public function findAllHabits();
    public function findHabitsByUserId($uid);
    public function findHabitsReachedByUserId($uid);
}

?>
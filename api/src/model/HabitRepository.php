<?php

namespace model;

interface HabitRepository
{
    public function findHabitById($id);
    public function findAllHabits();
    public function findHabitsByUserId($uid);
    public function findHabitByIdAndUserId($hid, $uid);
    public function findHabitsReachedByUserId($uid);
    public function insertHabit(Habit $habit);
    public function insertHabitReached(HabitReached $habit, $userId);
    public function insertUserHabit($uid, $hid);
    public function deleteHabitById($id);
    public function deleteHabitByIdAndUserId($hid, $uid);
    public function updateHabitById(Habit $habit);
    public function updateHabitByIdAndUserId($uid, $oldHId, $newHId);
}
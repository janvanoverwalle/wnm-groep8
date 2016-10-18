<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 17/10/16
 * Time: 11:00
 */

namespace model;


interface CaloriesRepository
{
    public function findCaloriesById($id);
    public function findAllCalories();
    public function findCaloriesByUserId($uid);
    public function findCaloriesByIdAndUserId($cid, $uid);
    public function insertCalories($calories);
    public function deleteCaloriesById($id);
    public function updateCalorieById($calories);
}
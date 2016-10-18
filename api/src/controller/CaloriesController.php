<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 14/10/16
 * Time: 15:31
 */

namespace controller;

use model\CaloriesRepository;
use view\View;

class CaloriesController
{
    private $caloriesRepository;
    private $view;

    public function __construct(CaloriesRepository $caloriesRepository, View $view) {
        $this->caloriesRepository = $caloriesRepository;
        $this->view = $view;
    }

    public function handleFindCaloriesById($id) {
        $calories = $this->caloriesRepository->findCaloriesById($id);

        $this->view->show(array('calorie' => $calories));
    }

    public function handleFindAllCalories() {
        $calories = $this->caloriesRepository->findAllCalories();

        $this->view->show(array('calories' => $calories));
    }

    public function handleFindCaloriesByUserId($uid) {
        $calories = $this->caloriesRepository->findCaloriesByUserId($uid);

        $this->view->show(array('calories' => $calories));
    }

    public function handleFindCaloriesByIdAndUserId($cid, $uid) {
        $calories = $this->caloriesRepository->findCaloriesByIdAndUserId($cid, $uid);

        $this->view->show(array('calorie' => $calories));
    }

    public function handleInsertCalories($calories) {
        $calorie = $this->caloriesRepository->insertCalories($calories);

        $this->view->show(array('calorie' => $calorie));
    }

    public function handleDeleteCaloriesById($id = null) {
        if ($id == null) {
            return;
        }

        $calories = $this->caloriesRepository->deleteCaloriesById($id);

        $this->view->show(array('calorie' => $calories));
    }

    public function handleUpdateCaloriesById($calories = null) {
        if ($calories == null) {
            return;
        }

        $calorie = $this->caloriesRepository->updateCalorieById($calories);

        $this->view->show(array('calorie' => $calorie));
    }
}
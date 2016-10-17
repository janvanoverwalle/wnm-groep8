<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 14/10/16
 * Time: 15:31
 */

namespace controller;

use model\WeightRepository;
use view\View;

class WeightController
{
    private $weightRepository;
    private $view;

    public function __construct(WeightRepository $weightRepository, View $view) {
        $this->weightRepository = $weightRepository;
        $this->view = $view;
    }

    public function handleFindWeightById($id) {
        $weights = $this->weightRepository->findWeightById($id);

        $this->view->show(array('weight' => $weights));
    }

    public function handleFindAllWeights() {
        $weights = $this->weightRepository->findAllWeights();

        $this->view->show(array('weights' => $weights));
    }

    public function handleFindWeightsByUserId($uid) {
        $weights = $this->weightRepository->findWeightsByUserId($uid);

        $this->view->show(array('weights' => $weights));
    }

    public function handleFindWeightByIdAndUserId($wid, $uid) {
        $weights = $this->weightRepository->findWeightByIdAndUserId($wid, $uid);

        $this->view->show(array('weight' => $weights));
    }
}
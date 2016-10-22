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
use model\Weight;

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

    public function handleInsertWeight($weight) {
        $weightModel = new Weight(NULL, $weight->weight, $weight->date);
        $uid = $weight->user_id;

        $weightModel = $this->weightRepository->insertWeight($weightModel, $uid);

        $this->view->show(array('weight' => $weightModel));
    }

    public function handleDeleteWeightById($id = null) {
        if ($id == null) {
            return;
        }

        $weight = $this->weightRepository->deleteWeightById($id);

        $this->view->show(array('weight' => $weight));
    }

    public function handleUpdateWeightById($weight = null) {
        $weightModel = new Weight($weight->id, $weight->weight, $weight->date);

        $weightModel = $this->weightRepository->updateWeightById($weightModel);

        $this->view->show(array('weight' => $weightModel));
    }
}
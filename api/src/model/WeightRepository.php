<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 17/10/16
 * Time: 13:13
 */

namespace model;


interface WeightRepository
{
    public function findWeightById($id);
    public function findAllWeights();
    public function findWeightsByUserId($uid);
    public function findWeightByIdAndUserId($wid, $uid);
    public function insertWeight(Weight $weight, $uid);
    public function deleteWeightById($id);
    public function updateWeightById(Weight $weight);
}
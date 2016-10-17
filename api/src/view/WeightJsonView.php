<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 17/10/16
 * Time: 13:27
 */

namespace view;


class WeightJsonView implements View
{
    public function show(array $weights) {
        header('Content-Type: application/json');

        if (isset($weights['weight'])) {
            $weights = $weights['weight'];
            echo json_encode(['id' => $weights->getId(), 'weight' => $weights->getWeight(), 'date' => $weights->getDate()]);
        }
        else if (isset($weights['weights'])) {
            $json = "[";
            foreach ($weights['weights'] as $weight) {
                $json = $json . json_encode(['id' => $weight->getId(), 'weight' => $weight->getWeight(), 'date' => $weight->getDate()]) . ",";
            }
            $json = substr($json, 0, -1) . "]";
            echo $json;
        } else {
            echo '{}';
        }

        //echo json_encode(array("data" => $json_data));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 17/10/16
 * Time: 11:27
 */

namespace view;


class CaloriesJsonView implements View
{
    public function show(array $calories) {
        header('Content-Type: application/json');

        if (isset($calories['calorie'])) {
            $calories = $calories['calorie'];
            echo json_encode(['id' => $calories->getId(), 'calories' => $calories->getCalories(), 'date' => $calories->getDate()]);
        }
        else if (isset($calories['calories'])) {
            $json = "[";
            foreach ($calories['calories'] as $calorie) {
                $json = $json . json_encode(['id' => $calorie->getId(), 'calories' => $calorie->getCalories(), 'date' => $calorie->getDate()]) . ",";
            }
            $json = substr($json, 0, -1) . "]";
            echo $json;
        } else {
            echo '{}';
        }

        //echo json_encode(array("data" => $json_data));
    }
}
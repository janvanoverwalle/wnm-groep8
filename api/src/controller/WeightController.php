<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 14/10/16
 * Time: 15:31
 */

require_once(dirname(__FILE__) . "/../config/Database.php");
include(dirname(__FILE__) . "/../model/Weight.php");

class WeightController {

    public static function findWeightByUserId($uid)
    {
        // SELECT Calories
        $sth = Database::get()->prepare("SELECT * FROM weights WHERE user_id_id = :id");
        $sth->bindParam(':id', $uid);
        $sth->execute();
        $calories = $sth->fetchAll(PDO::FETCH_ASSOC);

        foreach ($calories as $calorie) {
            $c = new Habit($calorie['id'], $calorie['weight'], $calorie['date']);
            $caloriesList[] = $c->expose();
        }

        return $caloriesList;
    }
}
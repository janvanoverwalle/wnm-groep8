<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 17/10/16
 * Time: 11:01
 */

namespace model;


class PDOCaloriesRepository implements CaloriesRepository
{
    private $connection = null;

    public function __construct(\PDO $connection) {
        $this->connection = $connection;
    }

    public function findCaloriesById($id)
    {
        try {
            // SELECT calories
            $stmt = $this->connection->prepare("SELECT * FROM calories WHERE id = :id");
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($results) <= 0) {
                return null;
            }

            return new Calories($results[0]['id'], $results[0]['calories'], $results[0]['date']);
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function findAllCalories()
    {
        try {
            // SELECT all calories
            $stmt = $this->connection->prepare("SELECT * FROM calories");
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($results) <= 0) {
                return null;
            }

            $calories = [];
            foreach ($results as $calorie) {
                $calories[] = new Calories($calorie['id'], $calorie['calories'], $calorie['date']);
            }

            return $calories;
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function findCaloriesByUserId($uid)
    {
        try {
            // SELECT user calories
            $stmt = $this->connection->prepare("SELECT * FROM calories WHERE user_id_id = :uid");
            $stmt->bindParam(':uid', $uid);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($results) <= 0) {
                return null;
            }

            $calories = [];
            foreach ($results as $calorie) {
                $calories[] = new Calories($calorie['id'], $calorie['calories'], $calorie['date']);
            }

            return $calories;
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function findCaloriesByIdAndUserId($cid, $uid)
    {
        try {
            // SELECT user calories
            $stmt = $this->connection->prepare("SELECT * FROM calories WHERE user_id_id = :uid AND id = :cid");
            $stmt->bindParam(':cid', $cid);
            $stmt->bindParam(':uid', $uid);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($results) <= 0) {
                return null;
            }

            return new Calories($results[0]['id'], $results[0]['calories'], $results[0]['date']);
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function insertCalories($calories)
    {
        if ($calories) {
            $calorie = new Calories(NULL, $calories->calories, $calories->date);
        }

        try {
            //INSERT new user
            $stmt = $this->connection->prepare("INSERT INTO calories(user_id_id, calories, date) VALUES (:uid, :calories, :date)");
            $stmt->bindParam(':uid', $calories->user_id);
            $stmt->bindParam(':calories', $calorie->getCalories());
            $stmt->bindParam(':date', $calorie->getDate());
            $stmt->execute();

            if ($stmt) {
                $stmt = $this->connection->query("SELECT LAST_INSERT_ID()");
                $lastId = $stmt->fetch(\PDO::FETCH_NUM);
                $calorie->setId($lastId[0]);

                return $calorie;
            }

            return null;
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function deleteCaloriesById($id)
    {
        $calories = $this->findCaloriesById($id);
        if ($calories == null) {
            return null;
        }

        try {
            // DELETE user
            $stmt = $this->connection->prepare("DELETE FROM calories WHERE id = :id");
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();

            return $calories;
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function updateCalorieById($calories)
    {
        $calorie = new Calories($calories->id, $calories->calories, $calories->date);

        try {
            //UPDATE user
            $stmt = $this->connection->prepare("UPDATE calories SET calories=:calories, date=:date WHERE id=:id");
            $stmt->bindParam(':id', $calorie->getId());
            $stmt->bindParam(':calories', $calorie->getCalories());
            $stmt->bindParam(':date', $calorie->getDate());
            $stmt->execute();

            if ($stmt) {
                return $calorie;
            }

            return null;
        }
        catch (\Exception $e) {
            return null;
        }
    }


}
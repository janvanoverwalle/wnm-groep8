<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 17/10/16
 * Time: 13:16
 */

namespace model;


use controller\WeightController;

class PDOWeightRepository implements WeightRepository
{
    private $connection = null;

    public function __construct(\PDO $connection) {
        $this->connection = $connection;
    }

    public function findWeightById($id)
    {
        try {
            // SELECT weight
            $stmt = $this->connection->prepare("SELECT * FROM weights WHERE id = :id");
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($results) <= 0) {
                return null;
            }

            return new Weight($results[0]['id'], $results[0]['weight'], $results[0]['date']);
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function findAllWeights()
    {
        try {
            // SELECT all weights
            $stmt = $this->connection->prepare("SELECT * FROM weights");
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($results) <= 0) {
                return null;
            }

            $weights = [];
            foreach ($results as $weight) {
                $weights[] = new Weight($weight['id'], $weight['weight'], $weight['date']);
            }

            return $weights;
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function findWeightsByUserId($uid)
    {
        try {
            // SELECT user + his weight
            $stmt = $this->connection->prepare("SELECT * FROM weights WHERE user_id_id = :uid");
            $stmt->bindParam(':uid', $uid);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($results) <= 0) {
                return null;
            }

            $weights = [];
            foreach ($results as $weight) {
                $weights[] = new Weight($weight['id'], $weight['weight'], $weight['date']);
            }

            return $weights;
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function findWeightByIdAndUserId($wid, $uid)
    {
        try {
            // SELECT user weight
            $stmt = $this->connection->prepare("SELECT * FROM weights WHERE user_id_id = :uid AND id = :wid");
            $stmt->bindParam(':wid', $wid);
            $stmt->bindParam(':uid', $uid);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($results) <= 0) {
                return null;
            }

            return new Weight($results[0]['id'], $results[0]['weight'], $results[0]['date']);
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function insertWeight($weight)
    {
        if ($weight) {
            $weightModel = new Weight(NULL, $weight->weight, $weight->date);
        }

        try {
            //INSERT new weight
            $stmt = $this->connection->prepare("INSERT INTO weights(user_id_id, weight, date) VALUES (:uid, :weight, :date)");
            $stmt->bindParam(':uid', $weight->user_id);
            $stmt->bindParam(':weight', $weightModel->getWeight());
            $stmt->bindParam(':date', $weightModel->getDate());
            $stmt->execute();

            if ($stmt) {
                $stmt = $this->connection->query("SELECT LAST_INSERT_ID()");
                $lastId = $stmt->fetch(\PDO::FETCH_NUM);
                $weightModel->setId($lastId[0]);

                return $weightModel;
            }

            return null;
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function deleteWeightById($id)
    {
        $weightModel = $this->findWeightById($id);
        if ($weightModel == null) {
            return null;
        }

        try {
            // DELETE weight
            $stmt = $this->connection->prepare("DELETE FROM weights WHERE id = :id");
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();

            return $weightModel;
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function updateWeightById($weight)
    {
        $weightModel = new Weight($weight->id, $weight->weight, $weight->date);

        try {
            //UPDATE calories
            $stmt = $this->connection->prepare("UPDATE weights SET weight=:weight, date=:date WHERE id=:id");
            $stmt->bindParam(':id', $weightModel->getId());
            $stmt->bindParam(':weight', $weightModel->getWeight());
            $stmt->bindParam(':date', $weightModel->getDate());
            $stmt->execute();

            if ($stmt) {
                return $weightModel;
            }

            return null;
        }
        catch (\Exception $e) {
            return null;
        }
    }


}
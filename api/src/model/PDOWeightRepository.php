<?php
/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 17/10/16
 * Time: 13:16
 */

namespace model;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use controller\WeightController;

class PDOWeightRepository implements WeightRepository
{
    private $connection = null;

    public function __construct(\PDO $connection) {
        $this->connection = $connection;
		$log = new Logger('PDOUserRepository');
		$log->pushHandler(new StreamHandler(__DIR__ . '/api_db.log', Logger::WARNING));
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
			$log->error('Caught Exception: ' . $e->getMessage());
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
			$log->error('Caught Exception: ' . $e->getMessage());
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
			$log->error('Caught Exception: ' . $e->getMessage());
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
			$log->error('Caught Exception: ' . $e->getMessage());
            return null;
        }
    }

    public function insertWeight(Weight $weight, $uid)
    {
        try {
            //INSERT new weight
            $stmt = $this->connection->prepare("INSERT INTO weights(user_id_id, weight, date) VALUES (:uid, :weight, :date)");
            $stmt->bindParam(':uid', $uid);
            $stmt->bindParam(':weight', $weight->getWeight());
            $stmt->bindParam(':date', $weight->getDate());
            $stmt->execute();

            if ($stmt) {
                $stmt = $this->connection->query("SELECT LAST_INSERT_ID()");
                $lastId = $stmt->fetch(\PDO::FETCH_NUM);
                $weight->setId($lastId[0]);

                return $weight;
            }

            return null;
        }
        catch (\Exception $e) {
			$log->error('Caught Exception: ' . $e->getMessage());
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
			$log->error('Caught Exception: ' . $e->getMessage());
            return null;
        }
    }

    public function updateWeightById(Weight $weight)
    {
        try {
            //UPDATE weight
            $stmt = $this->connection->prepare("UPDATE weights SET weight=:weight, date=:date WHERE id=:id");
            $stmt->bindParam(':id', $weight->getId());
            $stmt->bindParam(':weight', $weight->getWeight());
            $stmt->bindParam(':date', $weight->getDate());
            $stmt->execute();

            if ($stmt) {
                return $weight;
            }

            return null;
        }
        catch (\Exception $e) {
			$log->error('Caught Exception: ' . $e->getMessage());
            return null;
        }
    }


}
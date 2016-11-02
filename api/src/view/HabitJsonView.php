<?php

namespace view;

class HabitJsonView implements View
{
	public function show(array $data) {
		header('Content-Type: application/json');
        header('access-control-allow-origin: *');

        if (isset($data['habit'])) {
			$habit = $data['habit'];
            if ($habit != null) {
				header($_SERVER["SERVER_PROTOCOL"]." 200 OK");
				echo json_encode(['id' => $habit->getId(), 'description' => $habit->getDescription()]);
			}
			else {
				header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error");
				echo "{}";
			}
        }
		else if (isset($data['habits'])) {
			$json = "[";
			foreach ($data['habits'] as $habit) {
				$json = $json . json_encode(['id' => $habit->getId(), 'description' => $habit->getDescription()]) . ",";
			}
			$json = substr($json, 0, -1) . "]";
			echo $json;
        }
        else if (isset($data['habits_status'])) {
            $json = "[";
            foreach ($data['habits_status'] as $habit) {
                $json = $json . json_encode(['id' => $habit->getId(), 'habit_id' => $habit->getHabitId(),
                        'description' => $habit->getDescription(), 'date' => $habit->getDate(),
                        'isReached' => $habit->getIsReached()]) . ",";
            }
            $json = substr($json, 0, -1) . "]";
            echo $json;
        }
        else if (isset($data['habit_status'])) {
            $habit = $data['habit_status'];
            if ($habit != null) {
                header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
                echo json_encode(['id' => $habit->getId(), 'habit_id' => $habit->getHabitId(),
                    'description' => $habit->getDescription(), 'date' => $habit->getDate(),
                    'isReached' => $habit->getIsReached()]);
            } else {
                header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
                echo "{}";
            }
        }
		else {
            echo '{}';
        }
		
		//echo json_encode(array("data" => $json_data));
	}
}
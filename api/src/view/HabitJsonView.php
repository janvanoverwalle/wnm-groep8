<?php

namespace view;

class HabitJsonView implements View
{
	public function show(array $data) {
		header('Content-Type: application/json');

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
        } else {
            echo '{}';
        }
		
		//echo json_encode(array("data" => $json_data));
	}
}
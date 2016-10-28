<?php

namespace view;

class UserJsonView implements View
{
	public function show(array $data) {
		header('Content-Type: application/json');

        if (isset($data['user'])) {
            $user = $data['user'];
            if ($user != null) {
				header($_SERVER["SERVER_PROTOCOL"]." 200 OK");
				echo json_encode(['id' => $user->getId(), 'name' => $user->getUsername(), 'roles' => $user->getRoles()]);
			}
			else {
				header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error");
				echo "{}";
			}
        }
		else if (isset($data['users'])) {
			//$users = [];
			$json = "[";
            foreach ($data['users'] as $user) {
				//echo json_encode(['id' => $user->getId(), 'name' => $user->getName()]);
				//$users[] = $user->expose();
				$json = $json . json_encode(['id' => $user->getId(), 'name' => $user->getUsername(), 'roles' => $user->getRoles()]) . ",";
			}
			//echo json_encode($users);
			$json = substr($json, 0, -1) . "]";
			header($_SERVER["SERVER_PROTOCOL"]." 200 OK");
			echo $json;
        }
		else {
            echo '{}';
        }
		
		//echo json_encode(array("data" => $json_data));
	}
}
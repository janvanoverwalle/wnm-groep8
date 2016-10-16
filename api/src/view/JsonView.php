<?php

class JsonView {
	public static function show($json_data) {
		echo json_encode(array("data" => $json_data));
	}
}

?>
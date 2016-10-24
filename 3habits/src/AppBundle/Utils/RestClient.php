<?php

namespace AppBundle\Utils;

use GuzzleHttp\Client;

class RestClient {
	
	private $client;
	private $host;
	
	public function __construct() {
		//$this->client = new Client(['base_uri' => 'http://localhost/api']);
		$this->client = new Client();
		$this->host = 'http://localhost/api';
	}
	
	public function get($url, $data = false) {
		$f = fopen("log.txt", "w") or die("Unable to open file!");
		fwrite($f, "[GET] ".$this->host.$url."\r\n");
		
		$response = $this->client->get($this->host.$url);
		fwrite($f, $response->getStatusCode()."\r\n");
		
		// TODO: header klopt niet
		// if ($response->hasHeader('Content-Type'))
			// fwrite($f, $response->getHeader('Content-Type')."\r\n");
		
		foreach ($response->getHeaders() as $name => $values) {
			fwrite($f, $name . ': ' . implode(', ', $values) . "\r\n");
		}
		
		if ($response->getStatusCode() == 200) {
			if ($response->getHeader('content-type') == 'application/json') {
				return $response->json();
			}
			else {
				return $response->getBody();
			}
		}
	}
	
	public function post($url, $data = false) {
		$response = $this->client->post($url, ['json' => $data]);
		
		if ($response->getStatusCode() == 200) {
			if ($response->getHeader('content-type') == 'application/json') {
				return $response->json();
			}
			else {
				return $reponse->getBody();
			}
		}
	}
	
	public function put($url, $data = false) {
		$response = $this->client->put($url, ['json' => $data]);
		
		if ($response->getStatusCode() == 200) {
			if ($response->getHeader('content-type') == 'application/json') {
				return $response->json();
			}
			else {
				return $response->getBody();
			}
		}
	}
	
	public function delete($url, $data = false) {
		$response = $this->client->delete($url);
		
		if ($response->getStatusCode() == 200) {
			if ($response->getHeader('content-type') == 'application/json') {
				return $response->json();
			}
			else {
				return $response->getBody();
			}
		}
	}
}

?>
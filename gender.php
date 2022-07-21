<?php

echo getGender($_GET['name'], $_GET['countryCode']);

function getGender($name, $countryCode) {
	$url = "https://api.genderize.io?name=" . urlencode($name) . "&country_id=" . urlencode($countryCode);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	$response = json_decode($response);	
	if (!isset($response->gender)) {return null;}
	return $response->gender;
}
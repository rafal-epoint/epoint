<?php

//$countries = getCountries();
//var_dump($countries);

function getCountries2Select() {
	$countries = getCountries();
	$html = '<select>';
	foreach ($countries as $country) {
		$html .= "<option>$country</option>";
	}
	$html .= '</select>';
	return $html;
}

function getCountries() {
	$countries = [];
	$url = 'https://www.placesapi.dev/api/v1/countries?include=continent';
	$stop = false;
	while (!$stop) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$countries = array_merge($countries, getEuropeanCountriesFromResponse($response));
		$url = getNextPageFromResponse($response);
		if (!$url) {$stop = true;}
	}

	return $countries;
}

function getEuropeanCountriesFromResponse($response) {
	$response = json_decode($response);

	$countries = [];
	foreach ($response->data as $country) {
		if (!isset($country->continent) || !isset($country->continent->name)) {continue;}
		if ($country->continent->name !== 'Europe') {continue;}
		$countries[] = $country->name;
	}
	return $countries; 

}

function getNextPageFromResponse($response) {
	$response = json_decode($response);
	if (!isset($response->links)) {return null;}
	if (!isset($response->links->next)) {return null;}
	return $response->links->next;
}
<?php

function printCountries2Select() {
	$dummy = '<<option value="AD">Andorra</option><option value="AL">Albania</option><option value="AT">Austria</option><option value="AX">Aland Islands</option><option value="BA">Bosnia and Herzegovina</option><option value="BE">Belgium</option><option value="BG">Bulgaria</option><option value="BY">Belarus</option><option value="CH">Switzerland</option><option value="CS">Serbia and Montenegro</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DE">Germany</option><option value="DK">Denmark</option><option value="EE">Estonia</option><option value="ES">Spain</option><option value="FI">Finland</option><option value="FO">Faroe Islands</option><option value="FR">France</option><option value="GB">United Kingdom</option><option value="GG">Guernsey</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="HR">Croatia</option><option value="HU">Hungary</option><option value="IE">Ireland</option><option value="IM">Isle of Man</option><option value="IS">Iceland</option><option value="IT">Italy</option><option value="JE">Jersey</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="LV">Latvia</option><option value="MC">Monaco</option><option value="MD">Moldova</option><option value="ME">Montenegro</option><option value="MK">Macedonia</option><option value="MT">Malta</option><option value="NL">Netherlands</option><option value="NO">Norway</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="RO">Romania</option><option value="RS">Serbia</option><option value="RU">Russia</option><option value="SE">Sweden</option><option value="SI">Slovenia</option><option value="SJ">Svalbard and Jan Mayen</option><option value="SK">Slovakia</option><option value="SM">San Marino</option><option value="UA">Ukraine</option><option value="VA">Vatican</option><option value="XK">Kosovo</option>';
	echo $dummy;
	return;

	$countries = getCountries();
	//var_dump($countries);	
	//die();
	$html = '';
	foreach ($countries as $country) {
		$html .= '<option value="' . $country['code'] . '">' . $country['name'] . '</option>';
	}
	echo $html;
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
		$countries[] = ['name' => $country->name, 'code' => $country->iso3166Alpha2];
	}
	return $countries; 

}

function getNextPageFromResponse($response) {
	$response = json_decode($response);
	if (!isset($response->links)) {return null;}
	if (!isset($response->links->next)) {return null;}
	return $response->links->next;
}
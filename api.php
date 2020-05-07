<?php

$endpoints = [
	'statewise' => 'https://api.covid19india.org/data.json',
	'testing' => 'https://sheets.googleapis.com/v4/spreadsheets/1R08ny_AVHLasuEyfT9lNX5sscBi6Nl5mgKvQ3cmSvj8/values/Sheet1!A1:G200?key=AIzaSyB1O3W2yx8LTFwrYDsn98FuvaAG50k7hkI',
	'historical' => 'https://corona.lmao.ninja/v2/historical'
];

$allData = [];

function writeData($name, $data) {

	$file = fopen("cache/{$name}.json", 'w');
	fwrite($file, json_encode($data));
	fclose($file);

	echo "{$name}.json updated\n";

}

foreach ($endpoints as $key => $endpoint) {
	$data = json_decode(file_get_contents($endpoint));

	$allData[$key] = $data;

	writeData($key, $data);
}

// write to api.json
writeData('api', $allData);

shell_exec('git add . && git commit -m "updated api.json" && git push origin gh-pages');


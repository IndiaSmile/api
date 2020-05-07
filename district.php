<?php

$allDistricts = json_decode(file_get_contents('cache/allDistricts.json'));

$districtWithCoords = [];

$states = json_decode(file_get_contents('https://api.covid19india.org/state_district_wise.json'));

foreach ($states as $key => $stateData) {
	$districtData = $stateData->districtData;

	foreach ($districtData as $districtName => $value) {
		if ($value->confirmed > 0 && property_exists($allDistricts, $districtName)) {
			$districtWithCoords[$districtName] = $allDistricts->{$districtName};
		}
	}
}

$file = fopen('cache/infectedDistricts.json', 'w');
fwrite($file, json_encode($districtWithCoords));
fclose($file);

echo "infectedDistricts updated\n";

shell_exec('git add . && git commit -m "updated infectedDistricts.json" && git push origin gh-pages');

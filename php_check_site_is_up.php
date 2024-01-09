<?php

function cURL($url) {
	ob_start();
	// Create a new cURL resource
	$curl = curl_init();

	if (!$curl) {
		die("Couldn't initialize a cURL handle");
	}

	// Set the file URL to fetch through cURL
	curl_setopt($curl, CURLOPT_URL, $url);

	// Follow redirects, if any
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

	// Fail the cURL request if response code = 400 (like 404 errors)
	curl_setopt($curl, CURLOPT_FAILONERROR, true);

	// Returns the status code
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	// Wait 10 seconds to connect and set 0 to wait indefinitely
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);

	// Execute the cURL request for a maximum of 50 seconds
	curl_setopt($curl, CURLOPT_TIMEOUT, 50);

	// Do not check the SSL certificates
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$result = curl_exec($curl);
	ob_end_flush();

	// Check if any error has occurred
	if (curl_errno($curl)) {
		curl_close($curl);

		return false;
	} else {
		curl_close($curl);

		return true;
	}
}

$websites = [
	"Personal"     => [
		"https://alireza10up.ir",
		"https://a10up.ir",
		"https://vahdanialireza.ir",
		"https://sajjadmehri.ir",
	],
	"Organization" => [
		"https://parswordpress.ir",
		"https://aylero.ir",
		"https://asemaninvestgroup.com",
	]
];

foreach ($websites as $websiteGroups => $websites) {
	echo "::{$websiteGroups}::".PHP_EOL;
	foreach ($websites as $website) {
		$status = cURL($website);
		if ($status) {
			echo "::up:: {$website}".PHP_EOL;
		} else {
			echo "::down:: {$website}".PHP_EOL;
		}
	}
}


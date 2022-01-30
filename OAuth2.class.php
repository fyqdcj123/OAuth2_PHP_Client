<?php
require_once 'OAuth2.config.php';
$header = array("Authorization: Bearer ".getAccessToken());
function getAccessToken() {
	$content = "grant_type=client_credentials&client_id=".OAuth2_Client_ID."&client_secret=".OAuth2_Client_Secret;
	$header = array("Content-Type: application/x-www-form-urlencoded");
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => OAuth2_Token_Url,
		CURLOPT_HTTPHEADER => $header,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_NOBODY => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $content
	));
	curl_exec($curl);
	$url = curl_getinfo($curl,CURLINFO_EFFECTIVE_URL);
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_HTTPHEADER => $header,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $content
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return json_decode($response, true)['access_token'];
}
?>

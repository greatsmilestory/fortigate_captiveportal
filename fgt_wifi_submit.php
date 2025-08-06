<?php
// login.php

$magic = $_POST['magic'] ?? '';
$ssid  = $_POST['ssid'] ?? '';
$auth_url = $_GET['post'] ?? null;

if (!$auth_url || !$magic || !$ssid) {
    die('Required parameters are missing.');
}

$username = 'forti_wifi_captiveportal';
$password = 'forti_wifi_cap_0001';

$post_fields = [
    'username' => $username,
    'password' => $password,
    'magic'    => $magic,
    'ssid'     => $ssid
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $auth_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Activate only when necessary

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($http_code == 200) {
    echo $response;
} else {
    echo "Authentication request failed (HTTP $http_code)<br>error: $error";
}
?>

<?php
require_once(__DIR__ . '/../../config.php');
require_login();

header('Content-Type: application/json');

// Get raw JSON payload
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (empty($data['language_id']) || !isset($data['sourcecode'])) {
    echo json_encode(['error' => 'Missing language_id or sourcecode parameters.']);
    exit;
}

$lang = $data['language_id'];
$code = $data['sourcecode'];
$filename = ($lang === 'python3') ? 'test.py' : 'test.c';

// Prepare payload for Jobe REST API
$payload = [
    'run_spec' => [
        'language_id' => $lang,
        'sourcefilename' => $filename,
        'sourcecode' => $code
    ]
];

// Curl Jobe container directly via internal Docker Compose hostname
$ch = curl_init('http://jobe/jobe/index.php/restapi/runs');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($response === false) {
    echo json_encode(['error' => 'Failed to connect to execution server: ' . curl_error($ch)]);
} else {
    echo $response;
}
curl_close($ch);

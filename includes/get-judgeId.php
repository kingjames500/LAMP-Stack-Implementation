<?php

header('Content-type: application/json');

require_once "../classes/traits/ApiResponse.php";
require_once "../classes/database/connection-class.php";
require_once "../classes/admin/admin-class.php";
require_once "../classes/admin/admin-view.class.php";


$judge = new AdminView();
$response = $judge->getJudgeInfo();

$judges = array_map(function($judge) {
    return $judge['id']; // Adjust based on your actual ID field name
}, $response['data'] ?? []);



echo json_encode([
    'status' => 'success',
    'data' => $judges
]);
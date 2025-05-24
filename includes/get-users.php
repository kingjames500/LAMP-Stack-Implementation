<?php
require_once "../classes/traits/ApiResponse.php";
require_once "../classes/database/connection-class.php";

require_once "../classes/judge/judge.class.php";
require_once "../classes/judge/judge-view.class.php";
require_once "../classes/judge/judge-contr.class.php";

$judgeView = new JudgeView();

$response = $judgeView->getAllUsers();





header('Content-Type: application/json');
echo json_encode($response['data'], JSON_PRETTY_PRINT);
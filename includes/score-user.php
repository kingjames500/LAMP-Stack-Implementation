<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once  "../classes/traits/ApiResponse.php";
require_once "../classes/database/connection-class.php";
require_once "../classes/judge/judge.class.php";
require_once "../classes/judge/judge-view.class.php";
require_once "../classes/judge/judge-contr.class.php";


if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["user_id"], $_POST["judge_id"], $_POST["points"])
) {
    $userId = $_POST["user_id"];
    $judgeId = $_POST["judge_id"];
    $score = $_POST["points"];

    $judgeAssignScore =  new JudgeContr($judgeId, $userId, $score);
    $result = $judgeAssignScore->assignScoresToUser();

    header('Content-Type: application/json');
     echo json_encode($result,   JSON_PRETTY_PRINT);
}
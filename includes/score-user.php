<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include required files for database connection and judge logic
require_once "../classes/traits/ApiResponse.php";
require_once "../classes/database/connection-class.php";
require_once "../classes/judge/judge.class.php";
require_once "../classes/judge/judge-view.class.php";
require_once "../classes/judge/judge-contr.class.php";

// Check if the request method is POST and required POST data exists
if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["user_id"], $_POST["judge_id"], $_POST["points"])
) {
    // Retrieve POST data
    $userId = $_POST["user_id"];
    $judgeId = $_POST["judge_id"];
    $score = $_POST["points"];

    // Create a new JudgeContr object with provided data
    $judgeAssignScore = new JudgeContr($judgeId, $userId, $score);

    // Assign the score and get the result response
    $result = $judgeAssignScore->assignScoresToUser();

    // Set response header to JSON
    header('Content-Type: application/json');

    // Output the result as pretty-printed JSON
    echo json_encode($result, JSON_PRETTY_PRINT);
}

<?php
// Include the ApiResponse trait for handling standard API responses
require_once "../classes/traits/ApiResponse.php";

// Include the database connection class
require_once "../classes/database/connection-class.php";

// Include the main Judge class with database logic
require_once "../classes/judge/judge.class.php";

// Include the JudgeView class for viewing judge-related data
require_once "../classes/judge/judge-view.class.php";

// Include the JudgeContr class for handling judge-related operations
require_once "../classes/judge/judge-contr.class.php";

// Create a new instance of JudgeView to access the user-related view methods
$judgeView = new JudgeView();

// Call the method to get all users and store the response
$response = $judgeView->getAllUsers();


// Set the header to return JSON data
header('Content-Type: application/json');

// Return the response data in JSON format with pretty print
echo json_encode($response['data'], JSON_PRETTY_PRINT);
<?php

header('Content-type: application/json');

require_once "../classes/database/connection-class.php";
require_once "../classes/traits/ApiResponse.php";
require_once "../classes/scoreboard/scoreboard.class.php";
require_once "../classes/scoreboard/scoreboard-view.class.php";

try {
    $scoreView = new ScoreboardView();
    $scores = $scoreView->scoreboardViewData(); // Already an array!


    $time = time();

    array_walk($scores['data'], function (&$user) use ($time) {
        $user['last_updated'] = $time;
    });

    echo json_encode($scores, JSON_PRETTY_PRINT);
}
catch (\Exception $error) {
    echo json_encode(['error' => $error->getMessage()]);
}

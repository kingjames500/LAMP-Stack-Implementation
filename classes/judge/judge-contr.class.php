<?php

class JudgeContr extends Judge {
    private $userId;
    private $judgeId;
    private $scores;

    // Constructor to initialize judgeId, userId, and score
    public function __construct($judgeId, $userId, $scores){
        $this->userId = $userId;
        $this->judgeId = $judgeId;
        $this->scores = $scores;
    }

    // Checks if any of the values are empty
    private function checkIfEmpty(){
        if(empty($this->userId) || empty($this->judgeId) || empty($this->scores)){
            return false;
        }
        return true;
    }

    // Checks if this judge has already scored this user
    private function checkIfUserScoresExist(){
        return $this->checkIfAlreadyScored($this->userId, $this->judgeId);
    }

    // Assigns a score to the user if validations pass
    public function assignScoresToUser(){
        if ($this->checkIfEmpty() === false) {
            return ApiResponse::badRequest("Values cannot be empty");
        }

        if ($this->checkIfUserScoresExist() === false) {
            return ApiResponse::badRequest("You cannot score points twice to a single user");
        }

        // If checks pass, assign the score
        return $this->assignUserScores($this->judgeId, $this->userId, $this->scores);
    }
}

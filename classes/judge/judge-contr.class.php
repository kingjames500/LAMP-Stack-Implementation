<?php

class JudgeContr extends Judge {
    private $userId;
    private $judgeId;
    private $scores;



    public function __construct($judgeId, $userId, $scores){
        $this->userId = $userId;
        $this->judgeId = $judgeId;
        $this->scores = $scores;
    }

    private function checkIfEmpty(){
        $results;

        if(empty($this->userId) || empty($this->judgeId) || empty($this->scores)){
            $results = false;
        }
        else {
            $results = true;
        }
        return $results;
    }

    private function checkIfUserScoresExist(){
        $results;
        if (!$this->checkIfAlreadyScored($this->userId, $this->judgeId)) {
            $results = false;
        }
        else{
            $results = true;
        }
        return $results;
    }

    public function assignScoresToUser(){
        if ($this->checkIfEmpty() === false) {
            return ApiResponse::badRequest("values cannot be empty");
        }

        if ($this->checkIfUserScoresExist() === false) { 
            return ApiResponse::badRequest("You cannot score points twice to a single user");
        }

        return $this->assignUserScores($this->judgeId, $this->userId, $this->scores);
    }
}
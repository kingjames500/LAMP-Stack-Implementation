<?php

class AdminView extends Admin{
   // a method for returning all the judges on our database
    public function getAllJudges(){
        return $this->fetchAllJudges();
    }

    public function getJudgeInfo(){
        return $this->fetchAllJudgesId();
    }
}
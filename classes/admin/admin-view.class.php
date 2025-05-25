<?php

class AdminView extends Admin{
   // a methid for returning all the judges on our database
    public function getAllJudges(){
        return $this->fetchAllJudges();
    }
}
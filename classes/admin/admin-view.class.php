<?php

class AdminView extends Admin{
    public function getAllJudges(){
        return $this->fetchAllJudges();
    }
}
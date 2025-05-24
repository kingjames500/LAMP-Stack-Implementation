<?php
class JudgeView extends Judge{

    public function getAllUsers(){
        return $this->fetchAllUsers();
    }
}
<?php
class JudgeView extends Judge {

    // A public method that returns all users from the database
    public function getAllUsers() {
        return $this->fetchAllUsers();
    }
}

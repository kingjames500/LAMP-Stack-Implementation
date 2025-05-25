<?php
// This class handles creating a new judge using data from the Admin class
class AdminContr extends Admin {
    private $username;
    private $displayName;

    // Set the username and display name when the class is created
    public function __construct($username, $displayName)
    {
        $this->username = $username;
        $this->displayName = $displayName;
    }

    // Check if username or display name is empty
    private function checkEmptyInputs(){
        if (empty($this->username) || empty($this->displayName)) {
            return false;
        }
        return true;
    }

    // Check if the username is already in the database
    private function checkUsernameTakenCheck(){
        if (!$this->ifJudgeUsernameExists($this->username)) {
            return false;
        }
        return true;
    }

    // Main method to create a new judge
    public function newJudge(){
        // Validate inputs
        if ($this->checkEmptyInputs() === false) {
            return ApiResponse::badRequest("Username and Display name are required!");
        }

        // Make sure the username is not already taken
        if ($this->checkUsernameTakenCheck() === false) {
            return ApiResponse::badRequest("Username already exists on the database");
        }

        // Add the new judge
        return $this->addNewJudge($this->username, $this->displayName);
    }
}

<?php  
class AdminContr extends Admin{
    private $username;
    private $displayName;


    public function __construct($username, $displayName)
    {
        $this->username = $username;
        $this->displayName = $displayName;
        
    }

    private function checkEmptyInputs(){
        $results;

        if (empty($this->username) || empty($this->displayName)){
            $results = false;
        }
        
        else {
            $results = true;
        }
        
        return $results;
    }

    private function checkUsernameTakenCheck(){
        $results;

        if(!$this->ifJudgeUsernameExists($this->username)){
            $results = false;
        }
        else{
            $results = true;
        }

        return $results;
    }

    public function newJudge(){
        if ($this->checkEmptyInputs() === false){
            return ApiResponse::badRequest("Username and Display name are required!");
        }

        if($this->checkUsernameTakenCheck() === false){
            return ApiResponse::badRequest("Username already  exists on the database");
        }

        return $this->addNewJudge($this->username, $this->displayName);
    }
}
<?php 

class Judge extends databaseConnection {

    // this method gets all participant users from the database and only includes those who have not been scored any marks
    protected function fetchAllUsers(){
        try{
            $query = $this->connection()->prepare("
            SELECT users.*
            FROM users
            LEFT JOIN  scores ON users.id = scores.user_id
            WHERE scores.user_id IS NULL;");
            
            if (!$query->execute()) {
                return ApiResponse::internalServerError('We could not process your request, please try again later');
            }

            if ($query->rowCount() == 0) {
                return  ApiResponse::notFound("No students were found");
            }
            
            $users = $query->fetchAll(PDO::FETCH_ASSOC);
            

            return ApiResponse::ok("Students fetched successfully", $users);
            
        }
        catch(\PDOException $error){
            return ApiResponse::internalServerError($error->getMessage());
        }
        catch(\Throwable $error){
            return ApiResponse::internalServerError($error->getMessage());
        }
        
    }


    // this method assigns scores to the participant users by the judges
    //it takes in three parameters, $judgeId, $userId, $scores and return a message if successful
    protected function assignUserScores($judgeId, $userId, $scores){
        try {
            $query = $this->connection()->prepare("INSERT INTO scores(judge_id, user_id, points) VALUES(?,?,?);");

            if (!$query->execute(array($judgeId, $userId, $scores))) {
                return ApiResponse::internalServerError("the query could not be executed");
            }
            
            return ApiResponse::created("User successfully assigned point successfully");
        }
        catch(\PDOException $error){
            return ApiResponse::internalServerError(`there was an error {$error->getMessage()}`);
        }
        
        catch (\Throwable $error) {
        return ApiResponse::internalServerError(`there was an error {$error->getMessage()}`);
        }
    }


    // This method is for checking if the participant user has been scored marks and return a bool value
    protected function checkIfAlreadyScored($userId)
    {
        $query = $this->connection()->prepare("SELECT * FROM scores WHERE user_id = ?;");
        
        if(!$query->execute(array($userId))){
           return ApiResponse::internalServerError("there was an error with the connection!");
        }
        
        $results;

        if($query->rowCount() > 0){
            $results = false;
        }
        else{
            $results = true;
        }

        return $results;
    }

//    protected  function authenticateJudge($username){
//        $query = $this->connection()->prepare("SELECT * FROM judges WHERE username = ?;");
//
//        if(!$query->execute(array($username))){
//            return ApiResponse::internalServerError("there was an error with the connection!");
//        }
//
//        $judge = $query->fetch(PDO::FETCH_ASSOC);
//
//        if (!$judge){
//            return ApiResponse::notFound("Judge not found");
//        }
//
//        if (session_status() == PHP_SESSION_NONE) {
//            session_start();
//        }
//
//        $_SESSION['judgeId'] = $judge['id'];
//        $_SESSION['username'] = $judge['username'];
//        $_SESSION['score'] = $judge['score'];
//
//        return ApiResponse::ok("login successfully");
//
//    }
}
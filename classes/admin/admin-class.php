<?php 
class Admin extends databaseConnection
{
 protected function addNewJudge($username, $displayName){
  try {
    $query = $this->connection()->prepare("INSERT INTO judges (username, display_name) VALUES (?, ?);");
    
    if (!$query->execute(array($username, $displayName))) {
       return ApiResponse::internalServerError("could not add a new judge!", $query->errorCode());  
    }

    return ApiResponse::created("Judge Created Successfully");

    
  } catch (\Throwable $th) {
    return ApiResponse::internalServerError("there was a problem when creating a new judge
    ");
  }
 }
 
 protected function ifJudgeUsernameExists($username){
    try {
        $query = $this->connection()->prepare("SELECT id FROM judges WHERE username = ?;");

        if (!$query->execute(array($username))) {
           return  ApiResponse::internalServerError("could not process your request", $query->errorCode());
        }

        $results;

        if ($query->rowCount() > 0) {
            $results = false;
        }
        
        else {
            $results = true;
        }

        return $results;
    } catch (\Throwable $th) {
      return  ApiResponse::internalServerError("something went wrong", $th->getMessage());         }
 }

//  method for fetching all the judges

protected function fetchAllJudges() {
    try {
        $query = $this->connection()->prepare("SELECT * FROM judges;");
        
        if (!$query->execute()) {
            return ApiResponse::internalServerError("Error fetching judges.");
        }

        $judges = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($judges)) {
            return ApiResponse::notFound("No judges found.");
        }

        return ApiResponse::ok("Judges retrieved.",  $judges);

    } catch (\PDOException $e) {
        // Added return here
        return ApiResponse::internalServerError("Database error: " . $e->getMessage());
    } catch (\Throwable $th) {
        // Added return here
        return ApiResponse::internalServerError("Unexpected error: " . $th->getMessage());
    }
}

}
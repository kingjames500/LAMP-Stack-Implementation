<?php
class Admin extends databaseConnection
{
    // Adds a new judge to the database
    protected function addNewJudge($username, $displayName){
        try {
            $query = $this->connection()->prepare("INSERT INTO judges (username, display_name) VALUES (?, ?);");

            if (!$query->execute(array($username, $displayName))) {
                return ApiResponse::internalServerError("could not add a new judge!", $query->errorCode());
            }

            return ApiResponse::created("Judge Created Successfully");

        } catch (\Throwable $th) {
            return ApiResponse::internalServerError("there was a problem when creating a new judge");
        }
    }

    // Checks if a judge with the given username already exists
    protected function ifJudgeUsernameExists($username){
        try {
            $query = $this->connection()->prepare("SELECT id FROM judges WHERE username = ?;");

            if (!$query->execute(array($username))) {
                return ApiResponse::internalServerError("could not process your request", $query->errorCode());
            }

            // If username exists, return false
            if ($query->rowCount() > 0) {
                return false;
            }

            return true;
        } catch (\Throwable $th) {
            return ApiResponse::internalServerError("something went wrong", $th->getMessage());
        }
    }

    // Fetches all judges from the database
    protected function fetchAllJudges() {
        try {
            $query = $this->connection()->prepare("SELECT * FROM judges;");

            if (!$query->execute()) {
                return ApiResponse::internalServerError("Error fetching judges.");
            }
            if ($query->rowCount() == 0){
                return ApiResponse::notFound("No judges found.");
            }

            $judges = $query->fetchAll(PDO::FETCH_ASSOC);

            return ApiResponse::ok("Judges retrieved.",  $judges);

        } catch (\PDOException $e) {
            return ApiResponse::internalServerError("Database error: " . $e->getMessage());
        } catch (\Throwable $th) {
            return ApiResponse::internalServerError("Unexpected error: " . $th->getMessage());
        }
    }
}

<?php

class scoreboard extends databaseConnection
{
    // This function gets all scores from the database and includes the user's full name
    protected function getAllScoreBoardData(){
        try {
            $sql = $this->connection()->prepare("SELECT scores.*, users.full_name
            FROM scores JOIN users ON scores.user_id = users.id;");
            if (!$sql->execute()){
                return ApiResponse::internalServerError($sql->errorInfo());
            }

            if ($sql->rowCount() == 0){
                return ApiResponse::notFound("No scores were found!");
            }
            $scoresData = $sql->fetchAll(PDO::FETCH_ASSOC);
            return ApiResponse::ok("data fetched successfully", $scoresData);
        }
        catch (\PDOException $e){
            return ApiResponse::internalServerError($e->getMessage());
        }

        catch (\Throwable $throwable){
            return ApiResponse::internalServerError($throwable->getMessage());
        }
    }
}
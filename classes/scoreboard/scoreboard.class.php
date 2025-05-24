<?php

class scoreboard extends databaseConnection
{

    protected function getAllScoreBoardData(){
        try {
            $sql = $this->connection()->prepare("SELECT scores.*, users.full_name
            FROM scores JOIN users ON scores.user_id = users.id;");

            if (!$sql->execute()){
                return ApiResponse::internalServerError($sql->errorInfo());
            }
            $scoresData = $sql->fetchAll(PDO::FETCH_ASSOC);

            if ($scoresData < 0){
                return ApiResponse::notFound("data not found");
            }

            return ApiResponse::success("data fetched successfully", $scoresData);
        }
        catch (\PDOException $e){
            return ApiResponse::internalServerError($e->getMessage());
        }

        catch (\Throwable $throwable){
            return ApiResponse::internalServerError($throwable->getMessage());
        }
    }
}
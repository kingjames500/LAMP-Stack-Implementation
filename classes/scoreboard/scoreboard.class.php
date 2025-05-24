<?php

class scoreboard extends databaseConnection
{

    protected function getAllScoreBoardData(){
        try {
            $sql = $this->connection()->prepare("SELECT * FROM scores ORDER BY points DESC;");

            if (!$sql->execute()){
                return ApiResponse::internalServerError("something went wrong");
            }
            $scoresData = $sql->fetchAll(PDO::FETCH_ASSOC);

            if ($scoresData < 0){
                return ApiResponse::notFound("data not found");
            }

            return ApiResponse::success("data fetched successfully", $scoresData);
        }
        catch (\PDOException $e){
            return ApiResponse::internalServerError("something went wrong");
        }

        catch (\Throwable $throwable){
            return ApiResponse::internalServerError("something went wrong");
        }
    }
}
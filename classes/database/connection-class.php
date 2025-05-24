<?php 
class databaseConnection 
{
   protected function connection(){
     try {
        $username = 'root';
        $password = '1234';
        $dbConn = new PDO('mysql:host=localhost;dbname=portal', $username, $password);
        $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConn;
    } catch (PDOException $error) {
        ApiResponse::internalServerError("database connection error", $error->getMessage());
    }
   }
}
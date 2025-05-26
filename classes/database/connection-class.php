<?php
// This class handles the database connection
class databaseConnection
{
    // This method connects to the database
    protected function connection(){
        try {
            // Set database login details
            $username = 'root';
            $password = '1234';


            // Create a new PDO connection to the 'portal' database
            $dbConn = new PDO('mysql:host=localhost;dbname=portal', $username, $password);

            // Set PDO to throw exceptions if an error happens
            $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Return the database connection
            return $dbConn;

        } catch (PDOException $error) {
            // If connection fails, return an error response
            return ApiResponse::internalServerError("database connection error", $error->getMessage());
        } catch (Exception $error) {
            return ApiResponse::internalServerError($error->getMessage());
        }
    }
}
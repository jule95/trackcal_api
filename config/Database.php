<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 18.02.2019
 * Time: 15:50
 */

class Database
{
    //Values for database connection.
    private $host = "localhost";
    private $dbName = "trackcal";
    private $username = "root";
    private $password = "";

    //Connection variable
    private $conn;

    function getConnection()
    {
        $this->conn = null;
        try
        {
            //Prepare data source name variable.
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;

            //Create new PDO object.
            $this->conn = new PDO($dsn, $this->username, $this->password);
            //Set error mode for connection to display all errors as exceptions.
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Set charset to support special characters.
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception)
        {
            //Output error if database connection failed.
            echo "failed to connect to db " . $this->dbName . ": " . $exception->getMessage();
        }

        return $this->conn;
    }
}
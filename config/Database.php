<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 18.02.2019
 * Time: 15:50
 */

class Database
{
    //values for database connection
    private $host = "localhost";
    private $db_name = "trackcal";
    private $username = "root";
    private $password = "";

    public $conn;

    function getConnection()
    {
        //initially set connection to null
        $this->conn = null;

        try
        {
            //local var to hold dns data for pdo object
            $dns = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;

            //create new pdo object using values defined above
            $this->conn = new PDO($dns, $this->username, $this->password);
            //make sure errors are being displayed
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //set charset to utf8 to support special characters
            $this->conn->exec("set names utf8");
            //validate connection
        } catch (PDOException $exception)
        {
            //output error if connection to database failed
            echo "failed to connect to db " . $this->db_name . ": " . $exception->getMessage();
        }

        return $this->conn;
    }


}
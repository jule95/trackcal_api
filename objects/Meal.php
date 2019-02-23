<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 18.02.2019
 * Time: 18:28
 */

class Meal
{
    //db properties
    private $conn;
    private $table_name = "meal";

    //object properties
    public $id;
    public $name;
    public $calories;

    //constructor to initialize db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read products
    public function read()
    {
        //create query for selecting entire table
        $query = "SELECT id, name, calories FROM meal";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        //return result set
        return $stmt;
    }

    //create a new product
    public function create()
    {
        //create insert into query
        $query = "INSERT INTO meal (name, calories) values(:name, :calories)";

        //prepare the statement
        $stmt = $this->conn->prepare($query);

        //sanitize user input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->calories = htmlspecialchars(strip_tags($this->calories));

        //execute statement, bind values and check if statement was executed properly
        $stmtParams = ["name" => $this->name, "calories" => $this->calories];

        //check if statement was executed properly
        if ($stmt->execute($stmtParams))
        {
            return true;
        }

        return false;
    }

    //update existing product
    public function update()
    {
        //create update query
        $query = "UPDATE meal SET name = :name, calories = :calories WHERE id = :id";

        //prepare the statement
        $stmt = $this->conn->prepare($query);

        //sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->calories = htmlspecialchars(strip_tags($this->calories));

        //prepare statement params
        $stmtParams = ["id" => $this->id, "name" => $this->name, "calories" => $this->calories];

        //execute statement with params and check if everything went ok
        if ($stmt->execute($stmtParams))
        {
            return ["bool" => true, "rowCount" => $stmt->rowCount()];
        }

        return ["bool" => false, "rowCount" => null];
    }

    //delete an existing product
    public function delete()
    {
        //create delete query
        $query = "DELETE FROM meal WHERE id = :id";

        //prepare the statement
        $stmt = $this->conn->prepare($query);

        //sanitize input
        $this->id = htmlspecialchars(strip_tags($this->id));

        //prepare statement params
        $stmtParams = array("id" => $this->id);

        //execute statement with params and check if everything went ok
        if ($stmt->execute($stmtParams))
        {
            return ["bool" => true, "rowCount" => $stmt->rowCount()];
        }

        return ["bool" => false, "rowCount" => null];
    }

    //delete all existing products
    public function deleteAll()
    {
        //create delete all query
        $query = "DELETE FROM meal";

        //prepare the statement
        $stmt = $this->conn->prepare($query);

        //execute statement and check if everything went ok
        if($stmt->execute())
        {
            return true;
        }

        return false;
    }
}


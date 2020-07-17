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
    private $tableName = "meal";

    //object properties
    private $id;
    private $description;
    private $calories;

    //constructor to initialize db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //setter
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setCalories($calories)
    {
        $this->calories = $calories;
    }

    // read meals
    public function read()
    {
        //create query for selecting entire table
        $query = "SELECT id, description, calories FROM " . $this->tableName;

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        //return result set
        return $stmt;
    }

    //create a new meal
    public function create()
    {
        //create insert into query
        $query = "INSERT INTO " . $this->tableName . " (description, calories) values(:description, :calories)";

        //prepare the statement
        $stmt = $this->conn->prepare($query);

        //sanitize user input
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->calories = htmlspecialchars(strip_tags($this->calories));

        //prepare statement params
        $stmtParams = ["description" => $this->description, "calories" => $this->calories];

        //execute statement with params and check if everything went ok
        if ($stmt->execute($stmtParams))
        {
            return ["bool" => true, "lastInsertId" => $this->conn->lastInsertId()];
        }

        return ["bool" => false, "lastInsertedId" => null];
    }

    //update existing meal
    public function update()
    {
        //create update query
        $query = "UPDATE " . $this->tableName . " SET description = :description, calories = :calories WHERE id = :id";

        //prepare the statement
        $stmt = $this->conn->prepare($query);

        //sanitize input
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->calories = htmlspecialchars(strip_tags($this->calories));

        //prepare statement params
        $stmtParams = ["id" => $this->id, "description" => $this->description, "calories" => $this->calories];

        //execute statement with params and check if everything went ok
        if ($stmt->execute($stmtParams))
        {
            return ["bool" => true, "rowCount" => $stmt->rowCount()];
        }

        return ["bool" => false, "rowCount" => null];
    }

    //delete an existing meal
    public function delete()
    {
        //create delete query
        $query = "DELETE FROM " . $this->tableName . " WHERE id = :id";

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

    //delete all existing meal
    public function deleteAll()
    {
        //create delete all query
        $query = "DELETE FROM " . $this->tableName;

        //prepare the statement
        $stmt = $this->conn->prepare($query);

        //execute statement and check if everything went ok
        if ($stmt->execute())
        {
            return ["bool" => true, "rowCount" => $stmt->rowCount()];
        }

        return ["bool" => false, "rowCount" => null];
    }
}


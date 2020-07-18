<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 18.02.2019
 * Time: 18:28
 */

class Meal
{
    //Database properties
    private $conn;
    private $tableName = "meal";

    //Meal properties
    private $id;
    private $description;
    private $calories;

    //Initialize a database connection upon creating a new meal.
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Setter methods used in endpoints (meal directory).
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

    //Fetch all meals from database.
    public function read()
    {
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->conn->prepare($query);

        /*
         * bool -> Indicates if statement was executed successfully.
         * rowCount -> Indicates if any rows were returned by query.
         * stmt -> Used to fetch rows as array in read.php endpoint.
         */
        if ($stmt->execute())
        {
            return ["bool" => true, "rowCount" => $stmt->rowCount(), "stmt" => $stmt];
        }

        return ["bool" => false, "rowCount" => null, "stmt" => null];
    }

    //Create a new meal.
    public function create()
    {
        $query = "INSERT INTO " . $this->tableName . " (description, calories) values(:description, :calories)";
        $stmt = $this->conn->prepare($query);

        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->calories = htmlspecialchars(strip_tags($this->calories));

        $stmtParams = ["description" => $this->description, "calories" => $this->calories];

        /*
         * bool -> Indicates if statement was executed successfully.
         * lastInsertId -> Returns ID of inserted row. Used for DOM list rendering.
         */
        if ($stmt->execute($stmtParams))
        {
            return ["bool" => true, "lastInsertId" => $this->conn->lastInsertId()];
        }

        return ["bool" => false, "lastInsertedId" => null];
    }

    //Update an existing meal.
    public function update()
    {
        $query = "UPDATE " . $this->tableName . " SET description = :description, calories = :calories WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->calories = htmlspecialchars(strip_tags($this->calories));

        $stmtParams = ["id" => $this->id, "description" => $this->description, "calories" => $this->calories];

        /*
         * bool -> Indicates if statement was executed successfully.
         * rowCount -> Used to check if a row was updated.
         */
        if ($stmt->execute($stmtParams))
        {
            return ["bool" => true, "rowCount" => $stmt->rowCount()];
        }

        return ["bool" => false, "rowCount" => null];
    }

    //Delete an existing meal.
    public function delete()
    {
        $query = "DELETE FROM " . $this->tableName . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmtParams = ["id" => $this->id];

        /*
        * bool -> Indicates if statement was executed successfully.
        * rowCount -> Used to check if a row was deleted.
        */
        if ($stmt->execute($stmtParams))
        {
            return ["bool" => true, "rowCount" => $stmt->rowCount()];
        }

        return ["bool" => false, "rowCount" => null];
    }

    //Delete all existing meals.
    public function deleteAll()
    {
        $query = "DELETE FROM " . $this->tableName;
        $stmt = $this->conn->prepare($query);

        /*
        * bool -> Indicates if statement was executed successfully.
        * rowCount -> Used to check if rows were deleted.
        */
        if ($stmt->execute())
        {
            return ["bool" => true, "rowCount" => $stmt->rowCount()];
        }

        return ["bool" => false, "rowCount" => null];
    }

    public function toAssocArray()
    {
        return [
            "id" => $this->id,
            "description" => $this->description,
            "calories" => $this->calories
        ];
    }
}


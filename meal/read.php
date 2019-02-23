<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 18.02.2019
 * Time: 18:31
 */

//allow all origins to access this resource
header("Access-Control-Allow-Origin: *");
//set format of retrieved data to json and characters set to utf8
header("Content-Type: application/json; charset=UTF-8");

//include database and meal object
include_once "../config/Database.php";
include_once "../objects/Meal.php";

//instantiate database
$database = new Database();
$conn = $database->getConnection();

//instantiate meal object
$meal = new Meal($conn);

//query meals and get row count
$stmt = $meal->read();
$num = $stmt->rowCount();

//check if any meals were found
if ($num > 0)
{
    //create array for meals
    $meals_arr = array();
    $meals_arr["records"] = array();

    //retrieve table content
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        /*
         * extract row
         * by doing this values of row can be accessed by $meal rather than $row["meal"]
         */
        extract($row);

        $meal_item = array(
            "id" => $id,
            "name" => $name,
            "calories" => $calories
        );

        array_push($meals_arr["records"], $meal_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($meals_arr);
} else
{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "no products found")
    );
}
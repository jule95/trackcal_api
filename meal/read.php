<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 18.02.2019
 * Time: 18:31
 */

//note: no cors headers required since cors does not apply to GET (simple) requests
//allow all origins to access this resource
header("Access-Control-Allow-Origin: *");
//set format of retrieved data to json and characters set to utf8
header("Content-Type: application/json; charset=UTF-8");

//include required resources
include_once "../config/Database.php";
include_once "../objects/Meal.php";
include_once "../helper/Response.php";

//instantiate database
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] === "GET")
{
    //instantiate meal object
    $meal = new Meal($conn);

//query meals and get row count
    $stmt = $meal->read();
    $num = $stmt->rowCount();

//check if any meals were found
    if ($num > 0)
    {
        //create array for meals
        $mealsArr = array();
        $mealsArr["records"] = array();

        //retrieve table content
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $mealItem = array(
                "id" => $row["id"],
                "description" => $row["description"],
                "calories" => $row["calories"]
            );

            array_push($mealsArr["records"], $mealItem);
        }

        // set response code - 200 OK
        http_response_code(200);

        // show meals data in json format
        echo json_encode($mealsArr);
    } else
    {
        //send failure response because no rows returned
        Response::sendResponse(false, "0 rows returned", 404, null);
    }
} else
{
    //send failure response because of unallowed method
    Response::sendResponse(false, "method not allowed", 405, null);
}

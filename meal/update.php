<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 19.02.2019
 * Time: 19:02
 */

//allow all origins to access this resource
header("Access-Control-Allow-Origin: *");
//set format of retrieved data to json and characters set to utf8
header("Content-Type: application/json; charset=UTF-8");
//specify method which can be used to access this resource
header("Access-Control-Allow-Methods: PUT");
//???
header("Access-Control-Max-Age: 3600");
//indicate which headers can actually be used to send this post request
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and meal object
include_once "../config/Database.php";
include_once "../objects/Meal.php";

//instantiate database
$database = new Database();
//create new connection to database
$conn = $database->getConnection();

//get post data
$data = json_decode(file_get_contents("php://input"));

//check if data was received in body of request (0 evaluates to true)
$dataIsOk = !empty($data->id) && !empty($data->description) && !empty($data->calories);

if ($dataIsOk)
{
    //create a new meal
    $meal = new Meal($conn);

    $meal->setId($data->id);
    $meal->setDescription($data->description);
    $meal->setCalories($data->calories);

    $mealHasUpdated = $meal->update();

    if ($mealHasUpdated["bool"])
    {
        if ($mealHasUpdated["rowCount"] > 0)
        {
            // set response code - 200 ok
            http_response_code(200);

            //tell the user
            echo json_encode([
                "message" => "meal was updated",
                "status" => 200
            ]);
        } else
        {
            // set response code - 404 not found
            http_response_code(404);

            //tell the user
            echo json_encode([
                "message" => "meal was not updated: zero rows returned",
                "status" => 404
            ]);
        }

    } else
    {
        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode([
            "message" => "meal was not updated: service unavailable",
            "status" => 503
        ]);
    }
} else
{
    //set response code 400 - bad request
    http_response_code(400);

    //tell the user
    echo json_encode([
        "message" => "meal was not updated: incomplete data",
        "status" => 400
    ]);
}

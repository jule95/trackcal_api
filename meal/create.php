<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 19.02.2019
 * Time: 12:51
 */

//allow all origins to access this resource
header("Access-Control-Allow-Origin: *");
//set format of retrieved data to json and characters set to utf8
header("Content-Type: application/json");
//specify method which can be used to access this resource from a different domain
header("Access-Control-Allow-Methods: POST");
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

//check if data is available (optional: empty($data->id))
$dataIsOk = !empty($data->description) && !empty($data->calories);

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if ($dataIsOk)
    {
        //create a new meal
        $meal = new Meal($conn);

        //set properties from received data
        $meal->setDescription($data->description);
        $meal->setCalories($data->calories);

        $mealWasCreated = $meal->create();

        //create meal and check if was executed properly
        if ($mealWasCreated["bool"])
        {
            //set response code 201 - created
            http_response_code(201);

            echo json_encode([
                "message" => "meal was created",
                "status" => 201,
                "newId" => $mealWasCreated["lastInsertId"]
            ]);
        } else
        {
            //set response code 503 - service unavailable
            http_response_code(503);

            echo json_encode([
                "message" => "meal was not created: service unavailable",
                "status" => 503
            ]);
        }
    } else
    {
        //set response code 400 - bad request
        http_response_code(400);

        echo json_encode([
            "message" => "meal was not created: incomplete data",
            "status" => 400
        ]);
    }
} else
{
    //set response code 400 - method not allowed
    http_response_code(405);

    echo json_encode([
        "message" => "meal was not created: method not allowed",
        "status" => 405
    ]);
}
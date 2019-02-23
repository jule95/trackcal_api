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

//include database configuration to get connection
include_once "../config/Database.php";
//include product meal project to perform a create
include_once "../objects/Meal.php";

//instantiate database
$database = new Database();
//create new connection to database
$conn = $database->getConnection();
//create a new meal
$meal = new Meal($conn);

//get post data
$data = json_decode(file_get_contents("php://input"));

//check if data is available (optional: empty($data->id))
$dataIsOk = !empty($data->name) && !empty($data->calories);

if ($dataIsOk)
{
    //$meal->id = $data->id;
    $meal->name = $data->name;
    $meal->calories = $data->calories;

    $mealWasCreated = $meal->create();

    //create meal and check if was executed properly
    if ($mealWasCreated["bool"])
    {
        //set response code 201 - created
        http_response_code(201);

        echo json_encode(array("message" => "meal was created", "status" => 201, "newId" => $mealWasCreated["lastInsertId"]));
    } else
    {
        //set response code 503 - service unavailable
        http_response_code(503);

        echo json_encode(array("message" => "meal was not created: service unavailable", "status" => 503));
    }
} else
{
    //set response code 400 - bad request
    http_response_code(400);

    echo json_encode(array("message" => "meal was not created: incomplete data", "status" => 400));
}
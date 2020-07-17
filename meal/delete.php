<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 20.02.2019
 * Time: 13:33
 */

//allow all origins to access this resource
header("Access-Control-Allow-Origin: *");
//set format of retrieved data to json and characters set to utf8
header("Content-Type: application/json; charset=UTF-8");
//specify method which can be used to access this resource
header("Access-Control-Allow-Methods: DELETE");
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

//get post data
$data = json_decode(file_get_contents("php://input"));

//check if data is available
$dataIsOk = !empty($data->id);

if ($dataIsOk)
{
    //create a new meal
    $meal = new Meal($conn);

    //set properties from received data
    $meal->setId($data->id);

    $mealWasDeleted = $meal->delete();

    if ($mealWasDeleted["bool"])
    {
        if ($mealWasDeleted["rowCount"] > 0)
        {
            http_response_code(200);

            echo json_encode([
                "message" => "meal was deleted",
                "status" => 200
            ]);
        } else
        {
            http_response_code(404);

            echo json_encode([
                "message" => "meal was not deleted: 0 rows returned",
                "status" => 404
            ]);
        }

    } else
    {
        http_response_code(503);

        echo json_encode([
            "message" => "meal was not deleted: service unavailable",
            "status" => 503
        ]);
    }
} else
{
    http_response_code(400);

    echo json_encode([
        "message" => "meal was not deleted: incomplete data",
        "status" => 400
    ]);
}





<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 19.02.2019
 * Time: 12:51
 */

//CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");//?
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//Other
header("Content-Type: application/json; charset=UTF-8");

//Include all required resources.
include_once "../config/Database.php";
include_once "../objects/Meal.php";
include_once "../helper/Response.php";

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    //Create new database object and establish a connection.
    $database = new Database();
    $conn = $database->getConnection();

    //Store received request data in JSON and check if data is valid.
    $data = json_decode(file_get_contents("php://input"));
    $dataIsOk = !empty($data->description) && !empty($data->calories);

    if ($dataIsOk)
    {
        //Create new meal object and pass $conn object used to execute queries.
        $meal = new Meal($conn);

        //Set relevant properties and create meal and store result of query.
        $meal->setDescription($data->description);
        $meal->setCalories($data->calories);
        $mealWasCreated = $meal->create();

        //Check if query executed successfully.
        if ($mealWasCreated["bool"])
        {
            //Prepare additional data to append to response.
            $additional = [
                //ID of row that was inserted. Used for DOM list rendering.
                "lastInsertId" => $mealWasCreated["lastInsertId"]
            ];

            //Send success response.
            Response::sendResponse(true, null, 201, $additional);
        } else
        {
            //Send failure response because service is unavailable.
            Response::sendResponse(false, "service unavailable", 503, null);
        }
    } else
    {
        //Send failure response because of incomplete data.
        Response::sendResponse(false, "incomplete data", 400, null);
    }
} else
{
    //Send failure response because method is not allowed.
    Response::sendResponse(false, "method not allowed", 405, null);
}
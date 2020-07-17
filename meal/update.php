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

//include required resources
include_once "../config/Database.php";
include_once "../objects/Meal.php";
include_once "../helper/Response.php";

//instantiate database
$database = new Database();
//create new connection to database
$conn = $database->getConnection();

//get post data
$data = json_decode(file_get_contents("php://input"));

//check if data was received in body of request (0 evaluates to true)
$dataIsOk = !empty($data->id) && !empty($data->description) && !empty($data->calories);

if ($_SERVER["REQUEST_METHOD"] === "PUT")
{
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
                //send success response
                Response::sendResponse(true, null, 200, null);
            } else
            {
                //send failure response because no rows were updated
                Response::sendResponse(false, "0 rows updated", 404, null);
            }

        } else
        {
            //send failure response because service is unavailable
            Response::sendResponse(false, "service unavailable", 503, null);
        }
    } else
    {
        //send failure response because of incomplete data
        Response::sendResponse(false, "incomplete data", 400, null);
    }
} else
{
    //send failure response because of unallowed method
    Response::sendResponse(false, "method not allowed", 405, null);
}
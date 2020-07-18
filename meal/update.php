<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 19.02.2019
 * Time: 19:02
 */

//CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");//?
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//Other
header("Content-Type: application/json; charset=UTF-8");

//Include all required resources.
include_once "../config/Database.php";
include_once "../objects/Meal.php";
include_once "../helper/Response.php";

if ($_SERVER["REQUEST_METHOD"] === "PUT")
{
    //Create new database object and establish a connection.
    $database = new Database();
    $conn = $database->getConnection();

    //Store received request data in JSON and check if data is valid.
    $data = json_decode(file_get_contents("php://input"));
    $dataIsOk = !empty($data->id) && !empty($data->description) && !empty($data->calories);

    if ($dataIsOk)
    {
        //Create new meal object and pass $conn object used to execute queries.
        $meal = new Meal($conn);

        //Set relevant properties and update meal and store result of query.
        $meal->setId($data->id);
        $meal->setDescription($data->description);
        $meal->setCalories($data->calories);
        $mealHasUpdated = $meal->update();

        //Check if query executed successfully.
        if ($mealHasUpdated["bool"])
        {
            //Check if any rows were returned.
            if ($mealHasUpdated["rowCount"] > 0)
            {
                //Send success response.
                Response::sendResponse(true, null, 200, null);
            } else
            {
                //Send failure response because no rows returned and updated.
                Response::sendResponse(false, "0 rows updated", 404, null);
            }

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
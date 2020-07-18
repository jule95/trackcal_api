<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 20.02.2019
 * Time: 13:33
 */

//CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");//?
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
//Other
header("Content-Type: application/json; charset=UTF-8");

//Include all required resources.
include_once "../config/Database.php";
include_once "../objects/Meal.php";
include_once "../helper/Response.php";

if ($_SERVER["REQUEST_METHOD"] === "DELETE")
{
    //Create new database object and establish a connection.
    $database = new Database();
    $conn = $database->getConnection();

    //Store received request data in JSON and check if data is valid.
    $data = json_decode(file_get_contents("php://input"));
    $dataIsOk = !empty($data->id);

    if ($dataIsOk)
    {
        //Create new meal object and pass $conn object used to execute queries.
        $meal = new Meal($conn);

        //Set relevant properties and delete meal and store result of query.
        $meal->setId($data->id);
        $mealWasDeleted = $meal->delete();

        //Check if query executed successfully.
        if ($mealWasDeleted["bool"])
        {
            //Check if any rows were deleted.
            if ($mealWasDeleted["rowCount"] > 0)
            {
                //Send success response.
                Response::sendResponse(true, null, 200, null);
            } else
            {
                //Send failure response because no rows returned and deleted.
                Response::sendResponse(false, "0 rows returned", 404, null);
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
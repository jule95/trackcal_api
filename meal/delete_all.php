<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 23.02.2019
 * Time: 14:09
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

    //Create new meal object and pass $conn object used to execute queries.
    $meal = new Meal($conn);

    //Delete all meals and store result of query.
    $mealsWereDeleted = $meal->deleteAll();

    //Check if query executed successfully.
    if ($mealsWereDeleted["bool"])
    {
        //Check if any rows were deleted.
        if ($mealsWereDeleted["rowCount"] > 0)
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
    //Send failure response because method is not allowed.
    Response::sendResponse(false, "method not allowed", 405, null);
}
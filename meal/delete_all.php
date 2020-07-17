<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 23.02.2019
 * Time: 14:09
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

//include required resources
include_once "../config/Database.php";
include_once "../objects/Meal.php";
include_once "../helper/Response.php";

//instantiate database
$database = new Database();
//create new connection to database
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] === "DELETE")
{
    //create a new meal
    $meal = new Meal($conn);

    $mealsWereDeleted = $meal->deleteAll();

    if ($mealsWereDeleted["bool"])
    {
        if ($mealsWereDeleted["rowCount"] > 0)
        {
            //send success response
            Response::sendResponse(true, null, 200, null);
        } else
        {
            //send failure response because no rows returned and deleted
            Response::sendResponse(false, "0 rows returned", 404, null);
        }

    } else
    {
        //send failure response because service is unavailable
        Response::sendResponse(false, "service unavailable", 503, null);
    }
} else
{
    //send failure response because of unallowed method
    Response::sendResponse(false, "method not allowed", 405, null);
}
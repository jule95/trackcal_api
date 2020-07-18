<?php
/**
 * Created by PhpStorm.
 * User: Jule
 * Date: 18.02.2019
 * Time: 18:31
 */

//CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");//?
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//Other
header("Content-Type: application/json; charset=UTF-8");

//include required resources
include_once "../config/Database.php";
include_once "../objects/Meal.php";
include_once "../helper/Response.php";

if ($_SERVER["REQUEST_METHOD"] === "GET")
{
    //Create new database object and establish a connection.
    $database = new Database();
    $conn = $database->getConnection();

    //Create new meal object and pass $conn object used to execute queries.
    $meal = new Meal($conn);

    //Fetch all meals and store result of query.
    $mealsWereFetched = $meal->read();

    //Check if query executed successfully.
    if ($mealsWereFetched["bool"])
    {
        //Check if any rows were returned.
        if ($mealsWereFetched["rowCount"] > 0)
        {
            //Create an array to store all meals.
            $mealsArr = [];
            $mealsArr["data"] = [];

            //Retrieve fetched entries as associative array.
            while ($row = $mealsWereFetched["stmt"]->fetch(PDO::FETCH_ASSOC))
            {
                array_push($mealsArr["data"], [
                    "id" => $row["id"],
                    "description" => $row["description"],
                    "calories" => $row["calories"]
                ]);
            }

            //Send success response.
            Response::sendResponse(true, null, 200, $mealsArr);
        } else
        {
            //Send failure response because no rows returned.
            Response::sendResponse(false, "0 rows returned", 404, null);
        }
    } else
    {
        //Send failure response because service is unavailable.
        Response::sendResponse(false, "service unavailable", 503, null);
    }
} else
{
    //Send failure response because of method is not allowed.
    Response::sendResponse(false, "method not allowed", 405, null);
}

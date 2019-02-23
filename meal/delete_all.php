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
header("Access-Control-Allow-Methods: DELETE"); //POST instead of DELETE???
//???
header("Access-Control-Max-Age: 3600");
//indicate which headers can actually be used to send this post request
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/Database.php";
include_once "../objects/Meal.php";

$database = new Database();
$conn = $database->getConnection();

$meal = new Meal($conn);
$mealsWereDeleted = $meal->deleteAll();

if ($mealsWereDeleted["bool"])
{
    if ($mealsWereDeleted["rowCount"] > 0)
    {
        http_response_code(200);

        echo json_encode([
            "message" => "all meals deleted",
            "status" => 200
        ]);
    } else
    {
        http_response_code(404);

        echo json_encode([
            "message" => "no meal deleted: 0 rows returned",
            "status" => 404
        ]);
    }

} else
{
    http_response_code(503);

    echo json_encode([
        "message" => "no meals deleted: service unavailable",
        "status" => 503
    ]);
}
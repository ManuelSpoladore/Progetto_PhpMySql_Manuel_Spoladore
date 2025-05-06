<?php

//setting header http
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Including necessary files
include_once "../config/database.php";
include_once "../models/subject.php";

// Object database creation and connection to the database
$database = new Database();
$db = $database->getConnection();

//Object Course creation
$subject = new Subject($db);

//Retrieving data sent with POST
$stmt = $subject->read();
$num = $stmt->rowCount();

//check for the presence of necessary fields
if ($num > 0) {
    // Courses array
    $subjects_arr = array();
    $subjects_arr["record"] = array();

    //Retrieving data sent with POST
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $subject_item = array(
            "id" => $id,
            "subject_name" => $subject_name
        );
        array_push($subjects_arr["record"], $subject_item);
    }

    // 200
    http_response_code(200);
    echo json_encode($subject_arr);
} else {
    //404
    http_response_code(404);
    echo json_encode(array("message" => "No subject founded"));
}


error_reporting(E_ALL);
ini_set('display_errors', 1);

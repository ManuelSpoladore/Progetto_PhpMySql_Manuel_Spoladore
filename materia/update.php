<?php
//setting header http

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Header: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Including necessary files
include_once "../config/database.php";
include_once "../models/subject.php";

// Object database creation and connection to the database
$database = new Database();
$db = $database->getConnection();

//Object Course creation
$subject = new Subject($db);

//Retrieving data sent with POST
$data = json_decode(file_get_contents("php://input"));


//check for the presence of necessary fields

if (!empty($data->id) && !empty($data->subject_name)) {
    $subject->id = $data->id;
    $subject->subject_name = $data->subject_name;


    if ($subject->update()) {
        http_response_code(201);
        echo json_encode(array("message" => "Corso aggiornato con successo"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile aggiornare corso"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile aggiornare corso, dati incompleti"));
}

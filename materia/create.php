<?php
//impostazione header http

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Header: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Inclusione file necessari
include_once "../config/database.php";
include_once "../models/materia.php";

//Creazione dell'oggetto Database e connessione al database
$database = new Database();
$db = $database->getConnection();

//Creazione oggetto corso
$materia = new Materia($db);

//Recupero dei dati inviati con POST
$data = json_decode(file_get_contents("php://input"));


//verifica presenza campi necessari

if (!empty($data->nome_materia)) {

    $materia->nome_materia = $data->nome_materia;

    if ($materia->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Materia creata con successo"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile creare materia"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile creare materia, dati incompleti"));
}

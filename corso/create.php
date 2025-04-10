<?php
//impostazione header http

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Inclusione file necessari
include_once "../config/database.php";
include_once "../models/corso.php";

//Creazione dell'oggetto Database e connessione al database
$database = new Database();
$db = $database->getConnection();

//Creazione oggetto corso
$corso = new Corso($db);

//Recupero dei dati inviati con POST
$data = json_decode(file_get_contents("php://input"));


//verifica presenza campi necessari

if (!empty($data->nome_corso) && isset($data->posti_disponibili) && is_array($data->materie_ids)) {

    $corso->nome_corso = $data->nome_corso;
    $corso->posti_disponibili = $data->posti_disponibili;


    if ($corso->create($data->materie_ids)) {
        http_response_code(201);
        echo json_encode(array("message" => "Corso creato con successo"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile creare corso"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile creare corso, dati incompleti"));
}

<?php

// Impostazione header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Inclusione file necessari
include_once "../config/database.php";
include_once "../models/materia.php";

// Creazione dell'oggetto Database e connessione al database
$database = new Database();
$db = $database->getConnection();

// Creazione oggetto materia
$materia = new Materia($db);

// Esecuzione della query per leggere i corsi
$stmt = $materia->read();
$num = $stmt->rowCount();

// Verifica se sono stati trovati corsi
if ($num > 0) {
    // Array per i corsi
    $materie_arr = array();
    $materie_arr["record"] = array();

    // Recupero dei dati dei corsi
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $materia_item = array(
            "id" => $id,
            "nome_materia" => $nome_materia
        );
        array_push($materie_arr["record"], $materia_item);
    }

    // codice risposta 200 e ritorno dati
    http_response_code(200);
    echo json_encode($materia_arr);
} else {
    //nessuna materia  trovata , 404 
    http_response_code(404);
    echo json_encode(array("message" => "Nessuna materia trovata"));
}


error_reporting(E_ALL);
ini_set('display_errors', 1);

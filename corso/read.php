<?php

// Impostazione header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Inclusione file necessari
include_once "../config/database.php";
include_once "../models/corso.php";

// Creazione dell'oggetto Database e connessione al database
$database = new Database();
$db = $database->getConnection();

// Creazione oggetto corso
$corso = new Corso($db);

// Esecuzione della query per leggere i corsi
$stmt = $corso->read();
$num = $stmt->rowCount();

// Verifica se sono stati trovati corsi
if ($num > 0) {
    // Array per i corsi
    $corsi_arr = array();
    $corsi_arr["record"] = array();

    // Recupero dei dati dei corsi
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $corso_item = array(
            "id" => $id,
            "nome_corso" => $nome_corso,
            "posti_disponibili" => $posti_disponibili
        );
        array_push($corsi_arr["record"], $corso_item);
    }

    // codice risposta 200 e ritorno dati
    http_response_code(200);
    echo json_encode($corsi_arr);
} else {
    //nessun corso trovato , 404 
    http_response_code(404);
    echo json_encode(array("message" => "Nessun corso trovato"));
}








//      Conversione in formato Json + restituzione al client
//     echo json_encode($corsi_arr);
// } else {
//      Nessun corso
//     echo json_encode(array("message" => "Nessun corso trovato"));
// }


error_reporting(E_ALL);
ini_set('display_errors', 1);

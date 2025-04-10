<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once("../config/database.php");
include_once("../models/corso.php");

$database = new Database();
$db = $database->getConnection();

$corso = new Corso($db);

$stmt = $corso->readWithMaterie();
$num = $stmt->rowCount();

if ($num > 0) {
    $corsi_arr = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $row["id"];
        $nome_corso = $row["nome_corso"];
        $posti = $row["posti_disponibili"];
        $materia = $row["nome_materia"];

        if (!isset($corsi_arr[$id])) {
            $corsi_arr[$id] = [
                "id" => $id,
                "nome_corso" => $nome_corso,
                "posti_disponibili" => $posti,
                "materie" => []
            ];
        }
        if ($materia) {
            $corsi_arr[$id]["materie"][] = $materia;
        }
    }

    $corsi_arr = array_values($corsi_arr);

    http_response_code(200);
    echo json_encode($corsi_arr);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Nessun corso trovato"]);


    
}

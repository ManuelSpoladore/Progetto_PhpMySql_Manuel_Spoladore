<?php

class Materia
{
    private $conn;
    private $table_name = "materie";

    //Proprietà
    public $id;
    public $nome_materia;

    // Costruttore
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Visualizzare corsi disponibili

    function read()
    {
        $query = "SELECT id, nome_materia FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    // creare libro nuovo 
    function create()
{
    $query = "INSERT INTO " . $this->table_name . " 
              SET id = :id, nome_materia = :nome_materia";
    $stmt = $this->conn->prepare($query);

    // sanitizzazione input
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->nome_materia = htmlspecialchars(strip_tags($this->nome_materia));

    //Binding dei parametri
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":nome_materia", $this->nome_materia);

    //Esecuzione della query
    if ($stmt->execute()) {
        return true;
    }

    return false;
}


    //aggiornare corso esistente

    function update()
    {

        $query = "UPDATE " . $this->table_name . " SET nome_materia = :nome_materia WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // sanitizzazione input
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nome_materia = htmlspecialchars(strip_tags($this->nome_materia));

        //Binding dei parametri
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nome_materia", $this->nome_materia);

        //Esecuzione della query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Cancellare corso
    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // sanitizzazione input
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Binding dei parametri
        $stmt->bindParam(":id", $this->id);

        //Esecuzione della query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

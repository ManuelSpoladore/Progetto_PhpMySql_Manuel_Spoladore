<?php

class Corso
{
    private $conn;
    private $table_name = "corsi";

    // Proprietà
    public $id;
    public $nome_corso;
    public $posti_disponibili;

    // Costruttore
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Visualizzare corsi disponibili
    function read()
    {
        $query = "SELECT id, nome_corso, posti_disponibili FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Creare un nuovo corso e associare materie
    function create($materie_ids)
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nome_corso = :nome_corso, posti_disponibili = :posti_disponibili";
        $stmt = $this->conn->prepare($query);

        // Sanitizzazione input
        $this->nome_corso = htmlspecialchars(strip_tags($this->nome_corso));
        $this->posti_disponibili = htmlspecialchars(strip_tags($this->posti_disponibili));

        // Binding dei parametri
        $stmt->bindParam(":nome_corso", $this->nome_corso);
        $stmt->bindParam(":posti_disponibili", $this->posti_disponibili);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();

            // Inserimento in tabella corso_materia
            foreach ($materie_ids as $materia_id) {
                $materia_id = htmlspecialchars(strip_tags($materia_id));
                $query_materia = "INSERT INTO corso_materia (corso_id, materia_id) VALUES (:corso_id, :materia_id)";
                $stmt_materia = $this->conn->prepare($query_materia);
                $stmt_materia->bindParam(":corso_id", $this->id);
                $stmt_materia->bindParam(":materia_id", $materia_id);
                $stmt_materia->execute();
            }

            return true;
        }

        return false;
    }

    // Aggiornare corso esistente
    function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET posti_disponibili = :posti_disponibili, nome_corso = :nome_corso 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitizzazione input
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nome_corso = htmlspecialchars(strip_tags($this->nome_corso));
        $this->posti_disponibili = htmlspecialchars(strip_tags($this->posti_disponibili));

        // Binding dei parametri
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nome_corso", $this->nome_corso);
        $stmt->bindParam(":posti_disponibili", $this->posti_disponibili);

        return $stmt->execute();
    }

    // Cancellare corso
    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // Visualizzare corsi con le materie associate
    public function readWithMaterie()
    {
        $query = "
            SELECT 
                c.id, c.nome_corso, c.posti_disponibili,
                m.nome_materia
            FROM corsi c
            LEFT JOIN corso_materia cm ON c.id = cm.corso_id
            LEFT JOIN materie m ON cm.materia_id = m.id
            ORDER BY c.id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}

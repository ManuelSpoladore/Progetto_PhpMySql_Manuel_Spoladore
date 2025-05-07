<?php

class Subject
{
    private $conn;
    private $table_name = "subjects";

    // Properties
    public $id;
    public $subject_name;

    // Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Read all subjects
    public function read()
    {
        $query = "SELECT id, subject_name FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create a new subject
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (subject_name) VALUES (:subject_name)";
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->subject_name = htmlspecialchars(strip_tags($this->subject_name));

        // Bind parameters
        $stmt->bindParam(":subject_name", $this->subject_name);

        return $stmt->execute();
    }

    // Update an existing subject
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET subject_name = :subject_name 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->subject_name = htmlspecialchars(strip_tags($this->subject_name));

        // Bind parameters
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":subject_name", $this->subject_name);

        return $stmt->execute();
    }

    // Delete a subject
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind parameters
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }
}

<?php

class Subject
{
    private $conn;
    private $table_name = "subjects";

    //Properties
    public $id;
    public $subject_name;

    // Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Visualize available places

    function read()
    {
        $query = "SELECT id, subject_name FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    // create new subject
    function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
              SET id = :id, subject_name = :subject_name";
        $stmt = $this->conn->prepare($query);

        // sanitizing input
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->subject_name = htmlspecialchars(strip_tags($this->subject_name));

        //Binding parameters
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":subject_name", $this->subject_name);

        //Query execution
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    //update existing subject

    function update()
    {

        $query = "UPDATE " . $this->table_name . " SET subject_name = :subject_name WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // sanitizing input
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->subject_name = htmlspecialchars(strip_tags($this->subject_name));

        //Binding parameters
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":subject_name", $this->subject_name);

        //Query execution
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Delete course
    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // sanitizing input
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Binding parameters
        $stmt->bindParam(":id", $this->id);

        //Query execution
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

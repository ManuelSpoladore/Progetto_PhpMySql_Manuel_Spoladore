<?php

class Course
{
    private $conn;
    private $table_name = "courses";

    // Public properties
    public $id;
    public $course_name;
    public $available_places;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Retrieve all courses (basic)
    public function read()
    {
        $query = "SELECT id, course_name, available_places FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create a new course and associate it with subjects
    public function create($subject_id)
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET course_name = :course_name, available_places = :available_places";
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->course_name = htmlspecialchars(strip_tags($this->course_name));
        $this->available_places = htmlspecialchars(strip_tags($this->available_places));

        $stmt->bindParam(":course_name", $this->course_name);
        $stmt->bindParam(":available_places", $this->available_places);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();

            // Insert entries into course_subject linking table
            foreach ($subject_id as $subject_id) {
                $subject_id = htmlspecialchars(strip_tags($subject_id));
                $link_query = "INSERT INTO subject_courses (course_id, subject_id) 
                               VALUES (:course_id, :subject_id)";
                $link_stmt = $this->conn->prepare($link_query);
                $link_stmt->bindParam(":course_id", $this->id);
                $link_stmt->bindParam(":subject_id", $subject_id);
                $link_stmt->execute(); // You may check return values if needed
            }

            return true;
        }

        return false;
    }

    // Update an existing course
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET available_places = :available_places, course_name = :course_name 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->course_name = htmlspecialchars(strip_tags($this->course_name));
        $this->available_places = htmlspecialchars(strip_tags($this->available_places));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":course_name", $this->course_name);
        $stmt->bindParam(":available_places", $this->available_places);

        return $stmt->execute();
    }

    // Delete a course by ID
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // Read courses along with their associated subjects
    public function readWithSubjects()
    {
        $query = "
            SELECT 
                c.id, c.course_name, c.available_places,
                s.subject_name
            FROM courses c
            LEFT JOIN subject_courses cs ON c.id = cs.course_id
            LEFT JOIN subjects s ON cs.subject_id = s.id
            ORDER BY c.id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

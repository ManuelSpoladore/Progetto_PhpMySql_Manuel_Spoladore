<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Course.php';

class CourseController
{
    private function setJsonHeaders()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function create()
    {
        $this->setJsonHeaders();

        $database = new Database();
        $db = $database->getConnection();
        $course = new Course($db);

        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->course_name) || !isset($data->available_places) || !is_array($data->subject_id)) {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete data"]);
            return;
        }

        $course->course_name = $data->course_name;
        $course->available_places = $data->available_places;

        if (!$course->create($data->subject_id)) {
            http_response_code(503);
            echo json_encode(["message" => "Unable to create course"]);
            return;
        }

        http_response_code(201);
        echo json_encode(["message" => "New course created successfully"]);
    }

    public function read()
    {
        header("Content-Type: application/json");

        $database = new Database();
        $db = $database->getConnection();
        $course = new Course($db);

        $stmt = $course->read();
        $courses = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $courses[] = [
                "id" => $id,
                "course_name" => $course_name,
                "available_places" => $available_places
            ];
        }

        http_response_code(200);
        echo json_encode($courses);
    }

    public function readWithSubjects()
    {
        header("Content-Type: application/json");

        $database = new Database();
        $db = $database->getConnection();
        $course = new Course($db);

        $stmt = $course->readWithSubjects();
        $courses = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $course_id = $row['id'];
            $subject_name = $row['subject_name'];

            if (!isset($courses[$course_id])) {
                $courses[$course_id] = [
                    "id" => $row['id'],
                    "course_name" => $row['course_name'],
                    "available_places" => $row['available_places'],
                    "subjects" => []
                ];
            }

            if (!empty($subject_name)) {
                $courses[$course_id]["subjects"][] = $subject_name;
            }
        }

        http_response_code(200);
        echo json_encode(array_values($courses));
    }

    public function update()
    {
        $this->setJsonHeaders();
    
        $database = new Database();
        $db = $database->getConnection();
        $course = new Course($db);
    
        $data = json_decode(file_get_contents("php://input"));
    
        // Now includes check for subject_id array
        if (
            empty($data->id) ||
            empty($data->course_name) ||
            !isset($data->available_places) ||
            !is_array($data->subject_id)
        ) {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete data, unable to update course"]);
            return;
        }
    
        $course->id = $data->id;
        $course->course_name = $data->course_name;
        $course->available_places = $data->available_places;
    
        // Pass subject_id array to model
        if (!$course->update($data->subject_id)) {
            http_response_code(503);
            echo json_encode(["message" => "Unable to update course"]);
            return;
        }
    
        http_response_code(200);
        echo json_encode(["message" => "Course updated successfully"]);
    }
    

    public function delete()
    {
        $this->setJsonHeaders();

        $database = new Database();
        $db = $database->getConnection();
        $course = new Course($db);

        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->id)) {
            http_response_code(400);
            echo json_encode(["message" => "Missing course ID"]);
            return;
        }

        $course->id = $data->id;

        if (!$course->delete()) {
            http_response_code(503);
            echo json_encode(["message" => "Unable to delete course"]);
            return;
        }

        http_response_code(200);
        echo json_encode(["message" => "Course deleted successfully"]);
    }
}

<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/subject.php';

class SubjectController
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
        $subject = new Subject($db);

        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->subject_name)) {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete data"]);
            return;
        }

        $subject->subject_name = $data->subject_name;

        if (!$subject->create()) {
            http_response_code(503);
            echo json_encode(["message" => "Unable to create subject"]);
            return;
        }

        http_response_code(201);
        echo json_encode(["message" => "New subject created successfully"]);
    }

    public function read()
    {
        header("Content-Type: application/json");

        $database = new Database();
        $db = $database->getConnection();
        $subject = new Subject($db);

        $stmt = $subject->read();
        $subjects = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $subjects[] = [
                "id" => $id,
                "subject_name" => $subject_name
            ];
        }

        http_response_code(200);
        echo json_encode($subjects);
    }

   

    public function update()
    {
        $this->setJsonHeaders();

        $database = new Database();
        $db = $database->getConnection();
        $subject = new Subject($db);

        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->id) || empty($data->subject_name)) {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete data"]);
            return;
        }

        $subject->id = $data->id;
        $subject->subject_name = $data->subject_name;

        if (!$subject->update()) {
            http_response_code(503);
            echo json_encode(["message" => "Unable to update subject"]);
            return;
        }

        http_response_code(200);
        echo json_encode(["message" => "subject updated successfully"]);
    }

    public function delete()
    {
        $this->setJsonHeaders();

        $database = new Database();
        $db = $database->getConnection();
        $subject = new Subject($db);

        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->id)) {
            http_response_code(400);
            echo json_encode(["message" => "Missing subject ID"]);
            return;
        }

        $subject->id = $data->id;

        if (!$subject->delete()) {
            http_response_code(503);
            echo json_encode(["message" => "Unable to delete subject"]);
            return;
        }

        http_response_code(200);
        echo json_encode(["message" => "subject deleted successfully"]);
    }
}

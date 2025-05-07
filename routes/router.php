<?php
$method = $_SERVER['REQUEST_METHOD'];

// Get and normalize the request URI
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Detect base path (e.g., /public) and remove it from the request
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$path = str_replace($scriptName, '', $request);
$path = urldecode($path);
$path = trim($path, "/ \t\n\r\0\x0B");

// Include the necessary controllers
require_once __DIR__ . '/../controllers/CourseController.php';
require_once __DIR__ . '/../controllers/SubjectController.php';

// Define available routes and their associated HTTP method and controller method
$routes = [
    // Course routes
    'courses/create'  => ['POST', 'create'],
    'courses'         => ['GET',  'read'],
    'courses/full'    => ['GET',  'readWithSubjects'],
    'courses/update'  => ['POST', 'update'],
    'courses/delete'  => ['POST', 'delete'],

    // Subject routes
    'subjects/create' => ['POST', 'create'],
    'subjects'        => ['GET',  'read'],
    'subjects/update' => ['POST', 'update'],
    'subjects/delete' => ['POST', 'delete'],
];

// Check if the requested path is defined
if (!isset($routes[$path])) {
    http_response_code(404);
    echo json_encode(["message" => "Not Found"]);
    return;
}

// Extract expected HTTP method and controller method
list($expectedMethod, $methodName) = $routes[$path];

// Reject the request if the method does not match
if ($method !== $expectedMethod) {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    return;
}

// Dynamically determine the controller based on path prefix
$controller = str_starts_with($path, 'courses')
    ? new CourseController()
    : new SubjectController();

// Call the matched method on the controller
$controller->$methodName();

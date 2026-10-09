<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$fields = ['student_number', 'first_name', 'last_name', 'course'];
$data = [];

foreach ($fields as $field) {
    $value = $_POST[$field] ?? '';

    if (!is_string($value)) {
        http_response_code(400);
        exit('Invalid form data.');
    }

    $data[$field] = trim($value);
}

if (in_array('', $data, true)) {
    http_response_code(400);
    exit('All fields are required. Please go back and complete the form.');
}

if (
    strlen($data['student_number']) > 30 ||
    strlen($data['first_name']) > 100 ||
    strlen($data['last_name']) > 100 ||
    strlen($data['course']) > 100
) {
    http_response_code(400);
    exit('A field is too long. Please shorten your input.');
}

try {
    $stmt = $pdo->prepare(
        'INSERT INTO students
         (student_number, first_name, last_name, course)
         VALUES (:sn, :fn, :ln, :c)'
    );

    $stmt->execute([
        ':sn' => $data['student_number'],
        ':fn' => $data['first_name'],
        ':ln' => $data['last_name'],
        ':c' => $data['course']
    ]);

    header('Location: index.php');
    exit;
} catch (PDOException $e) {
    if (($e->errorInfo[1] ?? null) === 1062) {
        http_response_code(409);
        exit('Student number already exists. Please use a different number.');
    }

    error_log($e->getMessage());
    http_response_code(500);
    exit('Unable to save the student.');
}
<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    exit('Invalid student ID.');
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

$stmt = $pdo->prepare('SELECT id FROM students WHERE id = :id');
$stmt->execute([':id' => $id]);

if (!$stmt->fetch()) {
    http_response_code(404);
    exit('Student not found.');
}

try {
    $stmt = $pdo->prepare(
        'UPDATE students
         SET student_number = :sn,
             first_name = :fn,
             last_name = :ln,
             course = :c
         WHERE id = :id'
    );

    $stmt->execute([
        ':sn' => $data['student_number'],
        ':fn' => $data['first_name'],
        ':ln' => $data['last_name'],
        ':c' => $data['course'],
        ':id' => $id
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
    exit('Unable to update the student.');
}
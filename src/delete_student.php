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

$stmt = $pdo->prepare('DELETE FROM students WHERE id = :id');
$stmt->execute([':id' => $id]);

header('Location: index.php');
exit;
<?php
require 'db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    exit('Invalid student ID.');
}

$stmt = $pdo->prepare('SELECT * FROM students WHERE id = :id');
$stmt->execute([':id' => $id]);
$student = $stmt->fetch();

if (!$student) {
    http_response_code(404);
    exit('Student not found.');
}

function escape($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }

        form {
            display: grid;
            gap: 10px;
        }

        input, button {
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>Edit Student</h1>

    <form action="update_student.php" method="POST">
        <input type="hidden" name="id"
               value="<?= escape($student['id']) ?>">

        <label for="student_number">Student Number</label>
        <input id="student_number" name="student_number"
               value="<?= escape($student['student_number']) ?>"
               maxlength="30" required>

        <label for="first_name">First Name</label>
        <input id="first_name" name="first_name"
               value="<?= escape($student['first_name']) ?>"
               maxlength="100" required>

        <label for="last_name">Last Name</label>
        <input id="last_name" name="last_name"
               value="<?= escape($student['last_name']) ?>"
               maxlength="100" required>

        <label for="course">Course</label>
        <input id="course" name="course"
               value="<?= escape($student['course']) ?>"
               maxlength="100" required>

        <button type="submit">Update Student</button>
    </form>

    <p><a href="index.php">Cancel / Back to Student Records</a></p>
</body>
</html>
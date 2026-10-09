<?php
require 'db.php';

$stmt = $pdo->query('SELECT * FROM students ORDER BY id DESC');
$students = $stmt->fetchAll();

function escape($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        form.add-form {
            display: grid;
            gap: 10px;
            max-width: 500px;
        }

        input, button {
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #eee;
        }
    </style>
</head>
<body>
    <h1>Student Information Management</h1>

    <h2>Add Student</h2>

    <form class="add-form" action="save_student.php" method="POST">
        <input name="student_number"
               placeholder="Student Number" maxlength="30" required>

        <input name="first_name"
               placeholder="First Name" maxlength="100" required>

        <input name="last_name"
               placeholder="Last Name" maxlength="100" required>

        <input name="course"
               placeholder="Course" maxlength="100" required>

        <button type="submit">Save Student</button>
    </form>

    <h2>Student Records</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Number</th>
                <th>Name</th>
                <th>Course</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= escape($student['id']) ?></td>
                    <td><?= escape($student['student_number']) ?></td>
                    <td>
                        <?= escape(
                            $student['first_name'] . ' ' .
                            $student['last_name']
                        ) ?>
                    </td>
                    <td><?= escape($student['course']) ?></td>
                    <td>
                        <a href="edit_student.php?id=<?= escape($student['id']) ?>">
                            Edit
                        </a>    

                        <form action="delete_student.php" method="POST"
                              onsubmit="return confirm('Delete this record?');">
                            <input type="hidden" name="id"
                                   value="<?= escape($student['id']) ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (!$students): ?>
                <tr>
                    <td colspan="5">No student records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
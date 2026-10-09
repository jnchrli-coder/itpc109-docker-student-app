CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_number VARCHAR(30) NOT NULL UNIQUE,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students
    (student_number, first_name, last_name, course)
VALUES
    ('2026-0001', 'Juan', 'Dela Cruz', 'BS Information Technology'),
    ('2026-0002', 'Maria', 'Santos', 'BS Computer Science');
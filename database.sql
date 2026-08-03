CREATE DATABASE IF NOT EXISTS Fall2025_CW;
USE Fall2025_CW;

CREATE TABLE IF NOT EXISTS Course (
    course_id INT PRIMARY KEY,
    title VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS Teacher (
    teacher_id INT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    course_id INT,
    FOREIGN KEY (course_id) REFERENCES Course(course_id)
);

INSERT INTO Course (course_id, title) VALUES
(101, 'Database Management'),
(102, 'Web Programming'),
(103, 'Operating Systems');

INSERT INTO Teacher (teacher_id, name, course_id) VALUES
(1, 'Mr. Ahmed', 101),
(2, 'Ms. Rima', 102),
(3, 'Mr. Karim', NULL);

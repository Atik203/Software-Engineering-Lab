CREATE DATABASE IF NOT EXISTS SchoolMgmt;
USE SchoolMgmt;

CREATE TABLE IF NOT EXISTS student (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dept VARCHAR(50),
    name VARCHAR(100),
    nid VARCHAR(30),
    birth DATE,
    address VARCHAR(200)
);

CREATE TABLE IF NOT EXISTS teacher (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dept VARCHAR(50),
    name VARCHAR(100),
    nid VARCHAR(30),
    birth DATE,
    address VARCHAR(200)
);

CREATE TABLE IF NOT EXISTS course (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dept VARCHAR(50),
    title VARCHAR(100),
    credit INT,
    syllabus VARCHAR(200)
);

CREATE TABLE IF NOT EXISTS payment (
    payment_id INT PRIMARY KEY,
    student_id INT,
    amount DECIMAL(10,2),
    date DATE
);

INSERT INTO student (id, dept, name, nid, birth, address) VALUES
(1, 'CSE', 'Rahim Uddin', '1990123456789', '2002-05-14', 'Dhaka'),
(2, 'EEE', 'Karima Sultana', '1990987654321', '2003-11-02', 'Chittagong');

INSERT INTO teacher (id, dept, name, nid, birth, address) VALUES
(1, 'CSE', 'Prof. Ahmed', '1985123456789', '1978-03-20', 'Dhaka'),
(2, 'EEE', 'Prof. Rima', '1985987654321', '1980-09-11', 'Sylhet');

INSERT INTO course (id, dept, title, credit, syllabus) VALUES
(101, 'CSE', 'Database Management', 3, 'SQL, ER diagrams'),
(102, 'CSE', 'Web Programming', 3, 'HTML, PHP, MySQL'),
(103, 'EEE', 'Circuit Theory', 2, 'Ohm, KVL, KCL');

INSERT INTO payment (payment_id, student_id, amount, date) VALUES
(1, 1, 5000.00, '2026-01-15'),
(2, 2, 4500.00, '2026-02-10');

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

<?php

$DB = [
    'host' => 'localhost',
    'port' => 3307,     // THIS PC: XAMPP MySQL runs on 3307. Default XAMPP port is 3306.
    'user' => 'root',
    'pass' => '',
    'name' => 'SchoolMgmt',   // change this to your exam database name
];

// Add/remove any table here. First column = primary key.
// Faculty asks for a new table? Just add it here, all 4 CRUD APIs appear on the home page.
$TABLES = [
    'student' => ['id', 'dept', 'name', 'nid', 'birth', 'address'],
    'teacher' => ['id', 'dept', 'name', 'nid', 'birth', 'address'],
    'course'  => ['id', 'dept', 'title', 'credit', 'syllabus'],
    'payment' => ['payment_id', 'student_id', 'amount', 'date'],
];
?>

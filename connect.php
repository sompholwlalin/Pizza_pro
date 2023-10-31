<?php
$severname = "localhost";
$username = "pizzashop";
$password = "pizzashop1234";
$dbname = "pizzashop";

$severname = "localhost";
$username = "root";
$password = "";
$dbname = "pizzashop";

$conn = new mysqli($severname, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection Fail" . $conn->connect_error);
} // เชื่อมต่อฐานข้อมูล
?>
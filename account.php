<?php
include('connect.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $customer_id = $_SESSION['user_id'];
    // เริ่มดึงข้อมูลจากฐานข้อมูล
} else {
    // ถ้าไม่ได้ล็อกอิน ให้เปลี่ยนทางไปหน้า Login หรือที่คุณต้องการ
    header("Location: login.php"); 
}
    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    $sql = "SELECT * FROM users WHERE user_id = $customer_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $address = $row['address'];

        // เขียน HTML เพื่อแสดงข้อมูลในหน้าโปรไฟล์
        echo "<h1>โปรไฟล์ของ $name</h1>";
        echo "<p>อีเมล: $email</p>";
        echo "<p>ชื่อเต็ม:  $address </p>";
    } else {
        // ถ้าไม่พบข้อมูลผู้ใช้
        echo "ไม่พบข้อมูลผู้ใช้";
    }
?>
<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = $_POST['product_id'];

    // ลบสินค้าออกจากตะกร้า
    $deleteSQL = "DELETE FROM products WHERE product_id = $productID";

    if ($conn->query($deleteSQL) === TRUE) {
        header("Location: cart.php"); // เพิ่มบรรทัดนี้เพื่อทำการเด้งไปยังหน้า cart.php
        exit(); // อย่าลืมใส่ exit() เพื่อหยุดการทำงานของสคริปต์
    } else {
        echo "ผิดพลาดในการลบสินค้า: " . $conn->error;
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
?>
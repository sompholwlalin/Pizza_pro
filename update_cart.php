<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newQuantity = $_POST['new_quantity'];
    $productID = $_POST['product_id'];

    // ตรวจสอบว่าจำนวนใหม่มีค่าที่ถูกต้อง (เช่น มากกว่าหรือเท่ากับ 1)
    if ($newQuantity >= 1) {
        // อัพเดทจำนวนของสินค้าในตะกร้า
        $updateSQL = "UPDATE products SET amount = $newQuantity WHERE product_id = $productID";

        if ($conn->query($updateSQL) === TRUE) {
            header("Location: cart.php"); // เพิ่มบรรทัดนี้เพื่อทำการเด้งไปยังหน้า cart.php
            exit(); // อย่าลืมใส่ exit() เพื่อหยุดการทำงานของสคริปต์
        } else {
            echo "ผิดพลาดในการอัพเดทจำนวนสินค้า: " . $conn->error;
        }
    } else {
        echo "จำนวนไม่ถูกต้อง";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
?>
<?php
include('connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่าค่าที่รับมาจากฟอร์มมีอยู่และถูกต้อง
    if (isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['payment_status'])) {
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);

        // คำนวณราคารวมจากตะกร้า (ตัวอย่าง: $totalPrice)
        $totalPrice = calculateTotalPrice(); // แทนที่ด้วยฟังก์ชันคำนวณราคาของคุณ

        $status = 'Pending';
        $user_id = $_SESSION['user_id'];

        // สร้างคำสั่ง SQL เพื่อบันทึกข้อมูลการสั่งซื้อ
        $orderSQL = "INSERT INTO iorder (total, status, status_pay, phone, address, user_id) VALUES ($totalPrice, '$status', '$payment_status', '$phone', '$address', $user_id)";
        function calculateTotalPrice() {
            include('connect.php');
            session_start();
        
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
        
                $totalPrice = 0;
        
                // คำนวณราคารวมจากตะกร้า (ตาราง "products") ของผู้ใช้ที่เข้าสู่ระบบ
                $cartSQL = "SELECT SUM(pizzas.price + size.price_size + crust.price_crust) AS itemTotal
                    FROM products
                    JOIN pizzas ON products.pid = pizzas.pizza_id
                    JOIN size ON products.sid = size.size_id
                    JOIN crust ON products.cid = crust.crust_id
                    WHERE products.user_id = $user_id";
        
                $cartResult = $conn->query($cartSQL);
        
                if ($cartResult->num_rows > 0) {
                    $totalPriceRow = $cartResult->fetch_assoc();
                    $totalPrice = $totalPriceRow['itemTotal'];
                }
        
                return $totalPrice;
            }
        
            return 0; // หรือค่าอื่น ๆ ที่คุณต้องการให้เป็นค่าเริ่มต้น
        } 
        if ($conn->query($orderSQL) === TRUE) {
            // สั่งซื้อสินค้าสำเร็จ สามารถแสดงข้อความยืนยันหรือเปลี่ยนหน้าไปหน้าขอบคุณได้
            header("Location: thank_you.php");
        } else {
            // ผิดพลาดในการสั่งซื้อ สามารถแสดงข้อความข้อผิดพลาดหรือเรียกให้ผู้ใช้ลองใหม่
            echo "ผิดพลาดในการสั่งซื้อ: " . $conn->error;
        }
    } else {
        echo "ไม่ได้รับข้อมูลจากฟอร์มอย่างถูกต้อง";
    }
 
    
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>

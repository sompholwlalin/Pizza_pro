<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza website</title>
    <link rel="stylesheet" href="css/Pizza website.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">

</head>

<body>

    <!-- header section -->
    <header>
        <!-- <a href="#" class="logo">Food<span>Fun</span></a> -->
        <a href="#" class="logo"><img src="img/logo.png" alt="logo"></a>
        <ul class="navbar">
            <li><a href="#home">Home</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="index.php">Login</a></li>
        </ul>
        <div class="h-icons">
            <a href="account.php"><i class='bx bx-user'></i></a>
            <a href="#"><i class='bx bx-cart'></i></a>
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>





    <?php
    include('connect.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $order_id = $_POST['order_id'];
        $new_status = $_POST['new_status'];

        // อัพเดทสถานะการสั่งซื้อในฐานข้อมูล
        $updateSQL = "UPDATE iorder SET status = '$new_status' WHERE iorder_id = $order_id";

        if ($conn->query($updateSQL) === TRUE) {
            echo "อัพเดทสถานะสำเร็จ";
        } else {
            echo "ผิดพลาดในการอัพเดทสถานะ: " . $conn->error;
        }
    }

    // ดึงรายการสั่งซื้อจากฐานข้อมูล
    $orderSQL = "SELECT * FROM iorders";
    $orderResult = $conn->query($orderSQL);

    if ($orderResult->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>เลขที่สั่งซื้อ</th><th>ราคารวม</th><th>สถานะ</th><th>เปลี่ยนสถานะ</th></tr>';

        while ($orderRow = $orderResult->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $orderRow['iorder_id'] . '</td>';
            echo '<td>' . $orderRow['total'] . '</td>';
            echo '<td>' . $orderRow['status'] . '</td>';
            echo '<td>
            <form method="post" action="">
                <input type="hidden" name="order_id" value="' . $orderRow['iorder_id'] . '">
                <select name="new_status">
                    <option value="Pending">รอดำเนินการ</option>
                    <option value="Processing">กำลังดำเนินการ</option>
                    <option value="Delivered">จัดส่งแล้ว</option>
                    <option value="Cancelled">ยกเลิก</option>
                </select>
                <input type="submit" value="อัพเดทสถานะ">
            </form>
        </td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo 'ไม่มีรายการสั่งซื้อ';
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
    ?>


    <!-- scroll top -->
    <a href="#home" class="scroll-top">
        <i class='bx bx-up-arrow-alt'></i>
    </a>

    <!-- custom scrollreveal link -->

    <script src="https://unpkg.com/scrollreveal"></script>

    <!-- custom js link -->
    <script type="text/javascript" src="js/Pizza website.js"></script>
    </section>
</body>

</html>
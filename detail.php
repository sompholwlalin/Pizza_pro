<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Details</title>
    <link rel="stylesheet" href="css/detail.css">
    <!-- รวม styles ที่จำเป็นเพื่อหน้า Detail ตามที่คุณต้องการ -->
</head>

<body>

    <!-- header section (เหมือนหน้าอื่นๆ) -->
    <!-- ... (เหมือนหน้าอื่นๆ) ... -->

    <!-- detail section -->
    <section class="detail-container">
        <?php
        include('connect.php');
        session_start();
        // ตรวจสอบว่ามีค่า ID ของพิซซ่าที่ส่งมาผ่าน URL
        if (isset($_GET['id'])) {
            $pizza_id = $_GET['id'];
            $sql = "SELECT * FROM pizzas WHERE pizza_id = $pizza_id";
            $result = $conn->query($sql);

            // ตรวจสอบว่ามีข้อมูลพิซซ่าที่ต้องการหรือไม่
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<div class="detail-box">'; // กล่องสีส้ม
                echo '<div class="image-container">'; // ส่วนรูปภาพด้านซ้ายมือ
                echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '" width="400" height="400">';
                echo '</div>'; // ปิดส่วนรูปภาพ
        
                echo '<div class="info-container">'; // ส่วนรายละเอียดด้านขวามือ
                echo '<h1>' . $row['name'] . '</h1>';
                echo '<p>Price: ' . $row['price'] . '</p>';

                // ...

                echo '<form method="POST" action="add_to_cart_1.php">'; // เพิ่มแบบฟอร์ม
                // ส่ง user_id ไปที่หน้า cart.php
                echo '<input type="hidden" name="user_id" value="' . $_SESSION['user_id'] . '">';
                echo '<label for="size">Size:</label>';
                echo '<select name="size_id" id="size">';
                $sqlSizes = "SELECT * FROM size";
                $resultSizes = $conn->query($sqlSizes);
                echo '<option value="" disabled selected>Select a size</option>';
                while ($sizeRow = $resultSizes->fetch_assoc()) {
                    echo '<option value="' . $sizeRow['size_id'] . '">' . $sizeRow['size_name'] . '</option>';
                }
                echo '</select>';

                // เมนู dropdown สำหรับทopping (crust)
                echo '<label for="crust">Crust:</label>';
                echo '<select name="crust_id" id="crust">';
                echo '<option value="" disabled selected>Select a crust</option>';
                $sqlCrusts = "SELECT * FROM crust";
                $resultCrusts = $conn->query($sqlCrusts);
                while ($crustRow = $resultCrusts->fetch_assoc()) {
                    echo '<option value="' . $crustRow['crust_id'] . '">' . $crustRow['crust_name'] . '</option>';
                }
                echo '</select>';
                // เมนู dropdown สำหรับจำนวนสินค้า
                echo '<label for="quantity">Quantity: </label>';
                echo '<input type="number" name="quantity" id="quantity" min="1" value="1">';
                echo '<input type="hidden" name="pizza_id" value="' . $row['pizza_id'] . '">'; // เพิ่ม hidden field สำหรับ pizza_id

                echo '<div class="button-container">'; // ส่วนปุ่ม
                echo '<input type="submit" class="add-to-cart-button" value="Add to Cart">';
                echo '<a class="back-button" href="customer.php">Back</a>';
                echo '</div>'; // ปิดส่วนปุ่ม
                echo '</form>'; // ปิดแบบฟอร์ม
                // ...
                echo '</div>'; // ปิดส่วนรายละเอียด
                // ...
                echo '</div>'; // ปิดกล่องสีส้ม
            } else {
                echo 'ไม่พบข้อมูลพิซซ่า';
            }
        } else {
            echo 'ไม่ระบุรหัสพิซซ่า';
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $conn->close();
        ?>

    </section>
</body>

</html>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/cart.css">
    <!-- เพิ่มไฟล์ CSS ตามที่คุณต้องการ -->
</head>

<body>
    <!-- เพิ่มส่วน header ตามที่คุณต้องการ -->
    <!-- ...

    <!-- ส่วนแสดงรายการสินค้าในตะกร้า -->
    <section class="cart-container">
        <h2>รายการสินค้าในตะกร้า</h2>
        <table>
            <thead>
                <tr>
                    <th>รูปภาพ</th>
                    <th>ชื่อรายการ</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>เพิ่ม/ลด</th>
                    <th>ลบสินค้า</th>
                    <th>ราคารวม</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // เชื่อมต่อฐานข้อมูล
                include('connect.php');
                session_start();

                if (isset($_SESSION['user_id'])) {
                    // รับค่า user_id จาก $_SESSION
                    $user_id = $_SESSION['user_id'];
                } else {
                    // ถ้าไม่ได้ตั้งค่า user_id ใน $_SESSION ให้ทำอะไรก็ตามที่เหมาะสม เช่นให้ผู้ใช้ล็อกอินใหม่หรือแสดงข้อความข้อผิดพลาด
                    echo "ไม่มี user_id ในเซสชัน กรุณาล็อกอินใหม่";
                }

                // ดึงข้อมูลสินค้าจากตาราง "products" และ "pizzas"
                $cartSQL = "SELECT products.amount, pizzas.name, pizzas.price, pizzas.image, size.price_size, crust.price_crust, products.product_id
    FROM products
    JOIN pizzas ON products.pid = pizzas.pizza_id
    JOIN size ON products.sid = size.size_id
    JOIN crust ON products.cid = crust.crust_id
    WHERE products.user_id = $user_id";

                $cartResult = $conn->query($cartSQL);

                if ($cartResult->num_rows > 0) {
                    $totalPrice = 0;
                    $itemNumber = 1;

                    while ($cartRow = $cartResult->fetch_assoc()) {
                        $itemImage = $cartRow['image']; // URL ของรูปภาพ
                        $itemName = $cartRow['name'];
                        $itemPrice = $cartRow['price'] + $cartRow['price_size'] + $cartRow['price_crust'];
                        $itemQuantity = $cartRow['amount'];
                        $productId = $cartRow['product_id'];
                        $itemTotal = $itemPrice * $itemQuantity;
                        $totalPrice += $itemTotal;

                        echo '<tr>';
                        echo '<td><img src="' . $itemImage . '" alt="' . $itemName . '" width="100"></td>';
                        echo '<td>' . $itemNumber . '. ' . $itemName . '</td>';
                        echo '<td>' . number_format($itemPrice, 2) . ' บาท</td>';
                        echo '<td>' . $itemQuantity . '</td>';
                        echo '<td>
                            <form method="post" action="update_cart.php">
                                <input type="number" name="new_quantity" min="1" value="' . $itemQuantity . '">
                                <input type="hidden" name="product_id" value="' . $productId . '">
                                <input type="submit" value="อัพเดทจำนวน">
                            </form>
                        </td>';
                        echo '<td>
                            <form method="post" action="remove_from_cart.php">
                                <input type="hidden" name="product_id" value="' . $productId . '">
                                <input type="submit" value="ลบสินค้า">
                            </form>
                        </td>';
                        echo '<td>' . number_format($itemTotal, 2) . ' บาท</td>';
                        echo '</tr>';

                        $itemNumber++;
                    }

                    // แสดงราคารวมทั้งหมด
                    echo '<tr>
                    <td colspan="6" align="right"><strong>ราคารวมทั้งหมด:</strong></td>
                    <td><strong>' . number_format($totalPrice, 2) . ' บาท</strong></td>
                </tr>';
                } else {
                    echo '<tr><td colspan="7">ไม่มีรายการสินค้าในตะกร้า</td></tr>';
                }

                // ปิดการเชื่อมต่อฐานข้อมูล
                $conn->close();
                ?>
            </tbody>
        </table>
    </section>
    <section class="cart-container">
        <?php
        include('connect.php');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // รับข้อมูลจากหน้า "detail.php"
            $pizza_id = $_POST['pizza_id'];
            $size_id = $_POST['size'];
            $crust_id = $_POST['crust'];
            $quantity = $_POST['quantity'];
            $user_id = $_SESSION['user_id'];

            // เริ่มการทำงานกับฐานข้อมูล เช่นตรวจสอบการสั่งซ้ำ, คำนวณราคา, และอื่น ๆ
            // ตรวจสอบว่ารายการสินค้าเหมือนกันอยู่ในตะกร้าหรือไม่
            $checkDuplicateSQL = "SELECT * FROM products WHERE pid = $pizza_id AND sid = $size_id AND cid = $crust_id AND user_id = $user_id";
            $duplicateResult = $conn->query($checkDuplicateSQL);

            if ($duplicateResult->num_rows > 0) {
                // หากมีรายการสินค้าเหมือนกันอยู่ในตะกร้า สามารถทำอะไรก็ได้ เช่น บันทึกการอัพเดทจำนวนสินค้า
                // ตรวจสอบและปรับปรุงจำนวนสินค้าเพิ่มเติม หรือใด ๆ ตามที่คุณต้องการ
                // ตัวอย่าง: คุณสามารถเพิ่มจำนวนสินค้าที่มีอยู่อีกเท่าที่รับเข้ามา
                $existingProduct = $duplicateResult->fetch_assoc();
                $existingQuantity = $existingProduct['amount'];
                $newQuantity = $existingQuantity + $quantity;

                // ทำการอัพเดทจำนวนสินค้า
                $updateSQL = "UPDATE products SET amount = $newQuantity WHERE product_id = " . $existingProduct['product_id'];
                if ($conn->query($updateSQL) === TRUE) {
                    echo "อัพเดทจำนวนสินค้าสำเร็จ";
                } else {
                    echo "ผิดพลาดในการอัพเดทจำนวนสินค้า: " . $conn->error;
                }
            } else {
                // หากไม่มีรายการสินค้าเหมือนกันในตะกร้า ให้เพิ่มรายการใหม่
                $sql = "INSERT INTO products (amount, pid, sid, cid, user_id) VALUES ($quantity, $pizza_id, $size_id, $crust_id, $user_id)";
                if ($conn->query($sql) === TRUE) {
                    echo "เพิ่มสินค้าลงในตะกร้าสำเร็จ";
                } else {
                    echo "ผิดพลาดในการเพิ่มสินค้าในตะกร้า: " . $conn->error;
                }
            }

            // ใส่ข้อมูลเข้าไปในตะกร้าในฐานข้อมูล (ตาราง "products")
            $sql = "INSERT INTO products (amount, pid, sid, cid, user_id) VALUES ($quantity, $pizza_id, $size_id, $crust_id, $user_id)";
            if ($conn->query($sql) === TRUE) {
                echo "เพิ่มสินค้าลงในตะกร้าสำเร็จ";
            } else {
                echo "ผิดพลาดในการเพิ่มสินค้าในตะกร้า: " . $conn->error;
            }

            // ...
        
            // ปิดการเชื่อมต่อฐานข้อมูล
            $conn->close();
        }
        ?>
    </section>

    <section class="order-form">
        <h2>กรอกข้อมูลการสั่งซื้อ</h2>
        <form method="post" action="submit_order.php">
            <label for="phone">หมายเลขโทรศัพท์:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="address">ที่อยู่จัดส่ง:</label>
            <textarea id="address" name="address" required></textarea>

            <label for="payment_status">สถานะการชำระเงิน:</label>
            <select id="payment_status" name="payment_status">
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>
            </select>

            <input type="submit" value="สั่งซื้อสินค้า">
        </form>
    </section>
</body>

</html>
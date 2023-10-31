<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pizza_id'], $_GET['size_id'], $_GET['crust_id'], $_GET['quantity'], $_GET['user_id'])) {
    $pizza_id = $_GET['pizza_id'];
    $size_id = $_GET['size_id'];
    $crust_id = $_GET['crust_id'];
    $quantity = $_GET['quantity'];
    $user_id = $_GET['user_id'];
    
    include('connect.php');

    // ตรวจสอบว่ารายการสินค้ามีในตะกร้าแล้วหรือไม่

    $sqlCheckCart = "SELECT * FROM products WHERE pid = $pizza_id AND oid = ? AND sid = $size_id AND cid = $crust_id";
    $stmt = $conn->prepare($sqlCheckCart);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $resultCheckCart = $stmt->get_result();

    if ($resultCheckCart->num_rows > 0) {
        // ถ้ามีรายการสินค้าเดียวกันแล้วในตะกร้า ให้อัปเดตจำนวนสินค้า
        $rowCheckCart = $resultCheckCart->fetch_assoc();
        $newQuantity = $rowCheckCart['amount'] + $quantity;
        $product_id = $rowCheckCart['product_id'];

        $sqlUpdateCart = "UPDATE products SET amount = ? WHERE product_id = ?";
        $stmt = $conn->prepare($sqlUpdateCart);
        $stmt->bind_param("ii", $newQuantity, $product_id);
        $stmt->execute();
    } else {
        // คำนวณราคาของรายการสินค้า
        $sqlGetPizzaPrice = "SELECT price FROM pizzas WHERE pizza_id = $pizza_id";
        $resultGetPizzaPrice = $conn->query($sqlGetPizzaPrice);
        $rowPizzaPrice = $resultGetPizzaPrice->fetch_assoc();
        $pizzaPrice = $rowPizzaPrice['price'];

        $sqlGetSizePrice = "SELECT price_size FROM size WHERE size_id = $size_id";
        $resultGetSizePrice = $conn->query($sqlGetSizePrice);
        $rowSizePrice = $resultGetSizePrice->fetch_assoc();
        $sizePrice = $rowSizePrice['price_size'];

        $sqlGetCrustPrice = "SELECT price_crust FROM crust WHERE crust_id = $crust_id";
        $resultGetCrustPrice = $conn->query($sqlGetCrustPrice);
        $rowCrustPrice = $resultGetCrustPrice->fetch_assoc();
        $crustPrice = $rowCrustPrice['price_crust'];

        $totalPrice = ($pizzaPrice + $sizePrice + $crustPrice) * $quantity;

        // ดึงราคารวมปัจจุบันของออร์เดอร์
        $sqlGetOrderTotal = "SELECT total FROM iorder WHERE oid = ? AND user_id = ?";
        $stmt = $conn->prepare($sqlGetOrderTotal);
        $stmt->bind_param("ii", $user_id, $user_id);
        $stmt->execute();
        $resultGetOrderTotal = $stmt->get_result();
        $rowOrderTotal = $resultGetOrderTotal->fetch_assoc();
        $orderTotal = $rowOrderTotal['total'];

        // อัปเดตราคารวมในฐานข้อมูล
        $newOrderTotal = $orderTotal + $totalPrice;

        $sqlUpdateOrderTotal = "UPDATE iorder SET total = ? WHERE oid = ? AND user_id = ?";
        $stmt = $conn->prepare($sqlUpdateOrderTotal);
        $stmt->bind_param("dii", $newOrderTotal, $user_id, $user_id);
        $stmt->execute();

        // เพิ่มรายการสินค้าใหม่ในตะกร้า
        $sqlAddToCart = "INSERT INTO products (amount, pid, oid, sid, cid) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlAddToCart);
        $stmt->bind_param("iiiii", $quantity, $pizza_id, $user_id, $size_id, $crust_id);
        $stmt->execute();
    }

    // หลังจากดำเนินการเสร็จสิ้น นำกลับไปยังหน้า "Pizza Details" หรือหน้าอื่น ๆ ตามที่คุณต้องการ
    header('Location: pizza_details.php?id=' . $pizza_id);
    exit();
}
?>

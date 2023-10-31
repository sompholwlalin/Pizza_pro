function addToCart(pizzaId) {
    // ดึงข้อมูลจากเมนู dropdown ขนาด (size), ขอบแป้ง (crust) และ จำนวนสินค้า
    var size = document.getElementById("size").value;
    var crust = document.getElementById("crust").value;
    var quantity = document.getElementById("quantity").value;

    // ส่งข้อมูลไปยังหน้า add_to_cart.php
    var url = 'add_to_cart.php?id=' + pizzaId + '&size=' + size + '&crust=' + crust + '&quantity=' + quantity;
    window.location.href = cart.php;
}

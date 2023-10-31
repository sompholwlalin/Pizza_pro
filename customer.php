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
            <li><a href="index.php">Logout</a></li>
        </ul>
        <div class="h-icons">
            <a href="account.php"><i class='bx bx-user'></i></a>
            <a href="cart.php"><i class='bx bx-cart'></i></a>
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>

    <!-- home section -->
    <section class="home" id="home">
        <div class="home-text">
            <h1><span>New!!</span>โปรใหม่มาแรงรีบซื้อเลย</h1>
        </div>

        <div class="home-img">
            <img src="img/home.png" alt="home">
        </div>
    </section>

    <!-- menu section -->

    <section id="menu" class="menu">
        <h1 class="heading">our menu</h1>
        <?php
        include('connect.php');
        $sql = "SELECT * FROM Pizzas "; // ให้ชื่อตาราง Pizzas ถูกต้องตามฐานข้อมูล
        $result = $conn->query($sql);

        // ตรวจสอบว่ามีข้อมูลในฐานข้อมูลหรือไม่
        if ($result->num_rows > 0) {
            echo '<div class="menu-container">'; // เริ่มต้นคอนเทนเนอร์
        
            // วนลูปแสดงข้อมูลพิซซ่า
            while ($row = $result->fetch_assoc()) {
                echo '<div class="menu-item">'; // เริ่มต้นแสดงเมนู
                echo '<img src="' . $row["image"] . '" alt="' . $row["name"] . '" width="200" height="200"><br>';
                echo '<h3>' . $row["name"] . '</h3>';
                echo "<a class='bt-view' href='detail.php?id=" . $row["pizza_id"] . "'> Select </a>"; // แก้ไขเครื่องหมายเป็น " (double quotes) เพื่อให้แสดงค่าตัวแปรได้
                echo '</div>'; // ปิดแสดงเมนู
        
                // เมื่อแสดง 4 เมนูในแถวแล้วให้สร้างแถวใหม่
                if ($result->num_rows % 4 == 0) {
                    echo '<div style="clear: both;"></div>';
                }
            }

            echo '</div>'; // ปิดคอนเทนเนอร์
        } else {
            echo "ไม่พบข้อมูลพิซซ่า";
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $conn->close();
        ?>
    </section>
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
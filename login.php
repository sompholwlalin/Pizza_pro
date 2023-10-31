<?php
include('connect.php');
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Use prepared statements to prevent SQL injection
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['user_id']; // ID of the user
    $_SESSION['user_email'] = $row['email'];
    $_SESSION['user_type'] = $row['type'];

    if ($row['type'] == 'c') {
      header("Location: customer.php");
    } elseif ($row['type'] == 'o') {
      header("Location: owner.php");
    } else {
      echo "Invalid user type";
    }
  } else {
    echo "Invalid email or password";
  }
  $stmt->close();
  $conn->close();
} else {
  echo "Please fill out all fields";
}
?>

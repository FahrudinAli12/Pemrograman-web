<?php
include '../include/db.php';

$nama = $_POST['nama'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$password')";
if (mysqli_query($conn, $sql)) {
  header("Location: ../login.php");
} else {
  echo "Error: " . mysqli_error($conn);
}
?>

// hapus_hotel.php
<?php
include 'include/db.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM hotels WHERE id=$id");
header("Location: dashboard_admin.php");
?>

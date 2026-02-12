<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['kode_item'])) {
    $kode_item=$_GET['kode_item'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM item WHERE kode_item='$kode_item'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:itemlihat.php");
?>
<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['no_polisi'])) {
    $no_polisi=$_GET['no_polisi'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM motor WHERE no_polisi='$no_polisi'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:motorlihat.php");
?>
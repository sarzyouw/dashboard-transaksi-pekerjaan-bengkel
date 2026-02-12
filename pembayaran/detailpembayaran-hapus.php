<?php
// include database connection file
include '../koneksi.php';

// Get parameters from URL to delete that payment detail
if (isset($_GET['no_pembayaran']) && isset($_GET['kode_item'])) {
    $no_pembayaran = mysqli_real_escape_string($conn, $_GET['no_pembayaran']);
    $kode_item = mysqli_real_escape_string($conn, $_GET['kode_item']);
    
    // First get the item's total price before deletion
    $query_get_total = "SELECT harga_total FROM detailpembayaran 
                       WHERE no_pembayaran = '$no_pembayaran' AND kode_item = '$kode_item' LIMIT 1";
    $result_get_total = mysqli_query($conn, $query_get_total);
    
    if (!$result_get_total) {
        die("Error getting item total: " . mysqli_error($conn));
    }
    
    $row = mysqli_fetch_assoc($result_get_total);
    $harga_total = $row['harga_total'];
    
    // Delete payment detail row from table
    $result_delete = mysqli_query($conn, "DELETE FROM detailpembayaran 
                                        WHERE no_pembayaran = '$no_pembayaran' AND kode_item = '$kode_item' LIMIT 1");

    if ($result_delete) {
        // Update total amount in pembayaran table
        $query_update = "UPDATE pembayaran SET jumlah = jumlah - $harga_total 
                        WHERE no_pembayaran = '$no_pembayaran'";
        $result_update = mysqli_query($conn, $query_update);

        if ($result_update) {
            // After delete redirect to detail view
            header("Location: detailpembayaran-lihat.php?no_pembayaran=$no_pembayaran");
            exit();
        } else {
            die("Error updating payment total: " . mysqli_error($conn));
        }
    } else {
        die("Error deleting payment detail: " . mysqli_error($conn));
    }
} else {
    die("Invalid parameters - missing no_pembayaran or kode_item");
}
?>
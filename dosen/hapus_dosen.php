<?php
// include database connection file
include '../koneksi.php';

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Delete data from the database
$query = "DELETE FROM users WHERE id='$id'";
$delete = mysqli_query($koneksi, $query);

if ($delete) {
  // Success message with SweetAlert
  echo '<script>
            alert("Data Berhasil Dihapus");
            window.location.href = "../dosen/dosen.php"; // Replace with the actual success page
          </script>';
} else {
  // Error message with SweetAlert
  echo '<script>
            alert("Gagal Menghapus Data");
            window.location.href = "../dosen/dosen.php"; // Replace with the actual page
          </script>';
}
?>
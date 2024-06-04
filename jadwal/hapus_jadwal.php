<?php
// include database connection file
include '../koneksi.php';

$id_destination = $_GET['id_destination'];

// Hapus data dari database menggunakan prepared statement
$stmt = $koneksi->prepare("DELETE FROM destination_place WHERE id_destination=?");
$stmt->bind_param("s", $id_destination);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Pesan sukses dengan SweetAlert
    echo '<script>
            alert("Data Berhasil Dihapus");
            window.location.href = "../jadwal/jadwal.php"; // Ganti dengan halaman sukses aktual
          </script>';
} else {
    // Pesan kesalahan dengan SweetAlert
    echo '<script>
            alert("Gagal Menghapus Data");
            window.location.href = "../jadwal/jadwal.php"; // Ganti dengan halaman sukses aktual
          </script>';
}

$stmt->close();
?>

<?php
// include database connection file
include '../koneksi.php';

if (isset($_GET['id_category'])) {
    $id = $_GET['id_category'];

    // Hapus data dari database menggunakan prepared statement
    $stmt = $koneksi->prepare("DELETE FROM destination_category WHERE id_category=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Pesan sukses dengan SweetAlert
        echo '<script>
                alert("Data Berhasil Dihapus");
                window.location.href = "../mahasiswa/mahasiswa.php"; // Ganti dengan halaman sukses aktual
              </script>';
    } else {
        // Pesan kesalahan dengan SweetAlert
        echo '<script>
                alert("Gagal Menghapus Data");
                window.location.href = "../mahasiswa/mahasiswa.php"; // Ganti dengan halaman sukses aktual
              </script>';
    }

    $stmt->close();
} else {
    // Redirect jika tidak ada ID kategori yang diberikan
    header("Location:../mahasiswa/mahasiswa.php");
}
?>

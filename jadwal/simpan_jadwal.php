<?php
include '../koneksi.php';

$id_destination = mysqli_real_escape_string($koneksi, $_POST['id_destination']);
$destination_name = mysqli_real_escape_string($koneksi, $_POST['destination_name']);
$destination_description = mysqli_real_escape_string($koneksi, $_POST['destination_description']);
$destination_operational_hour = mysqli_real_escape_string($koneksi, $_POST['destination_operational_hour']);
$destination_address = mysqli_real_escape_string($koneksi, $_POST['destination_address']);
$latitude = mysqli_real_escape_string($koneksi, $_POST['latitude']);
$longitude = mysqli_real_escape_string($koneksi, $_POST['longitude']);
$iconic = isset($_POST['iconic']) ? 1 : 0;  // Check if the checkbox is checked
$id_category = mysqli_real_escape_string($koneksi, $_POST['id_category']);

// File upload handling
$destination_image_1 = $_FILES['destination_image_1']['tmp_name'];
$destination_image_2 = $_FILES['destination_image_2']['tmp_name'];
$destination_image_3 = $_FILES['destination_image_3']['tmp_name'];

// Convert images to binary data
$imageData1 = file_get_contents($destination_image_1);
$imageData2 = file_get_contents($destination_image_2);
$imageData3 = file_get_contents($destination_image_3);

// Escape binary data
$imageData1 = mysqli_real_escape_string($koneksi, $imageData1);
$imageData2 = mysqli_real_escape_string($koneksi, $imageData2);
$imageData3 = mysqli_real_escape_string($koneksi, $imageData3);

// Insert data into the database
$query = "INSERT INTO `destination_place` 
          (`id_destination`, `destination_name`, `destination_description`, `destination_operational_hour`, 
          `destination_address`, `destination_image_1`, `destination_image_2`, `destination_image_3`, 
          `latitude`, `longitude`, `iconic`, `id_category`) 
          VALUES 
          ('$id_destination', '$destination_name', '$destination_description', '$destination_operational_hour', 
          '$destination_address', '$imageData1', '$imageData2', '$imageData3', 
          '$latitude', '$longitude', '$iconic', '$id_category')";

$input = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

if ($input) {
    // Pesan sukses dengan SweetAlert
    echo '<script>
            alert("Data Berhasil Disimpan");
            window.location.href = "../jadwal/jadwal.php"; // Ganti dengan halaman sukses aktual
          </script>';
} else {
    // Pesan kesalahan dengan SweetAlert
    echo '<script>
            alert("Gagal Disimpan");
            window.location.href = "../jadwal/jadwal.php"; // Ganti dengan halaman sukses aktual
          </script>';
}
?>

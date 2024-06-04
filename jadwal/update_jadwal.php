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
$destination_image_1 = !empty($_FILES['destination_image_1']['tmp_name']) ? $_FILES['destination_image_1']['tmp_name'] : null;
$destination_image_2 = !empty($_FILES['destination_image_2']['tmp_name']) ? $_FILES['destination_image_2']['tmp_name'] : null;
$destination_image_3 = !empty($_FILES['destination_image_3']['tmp_name']) ? $_FILES['destination_image_3']['tmp_name'] : null;

// Check if new images are provided
$updateImages = false;
if ($destination_image_1 || $destination_image_2 || $destination_image_3) {
  $updateImages = true;
}

// Convert images to binary data if not empty
$imageData1 = $destination_image_1 ? mysqli_real_escape_string($koneksi, file_get_contents($destination_image_1)) : null;
$imageData2 = $destination_image_2 ? mysqli_real_escape_string($koneksi, file_get_contents($destination_image_2)) : null;
$imageData3 = $destination_image_3 ? mysqli_real_escape_string($koneksi, file_get_contents($destination_image_3)) : null;

// Update data in the database
if ($updateImages) {
  $query = "UPDATE `destination_place` SET
          `destination_name`='$destination_name',
          `destination_description`='$destination_description',
          `destination_operational_hour`='$destination_operational_hour',
          `destination_address`='$destination_address',
          `destination_image_1`='$imageData1',
          `destination_image_2`='$imageData2',
          `destination_image_3`='$imageData3',
          `latitude`='$latitude',
          `longitude`='$longitude',
          `iconic`='$iconic',
          `id_category`='$id_category'
          WHERE `id_destination`='$id_destination'";
} else {
  // If no new images, update without changing the image fields
  $query = "UPDATE `destination_place` SET
          `destination_name`='$destination_name',
          `destination_description`='$destination_description',
          `destination_operational_hour`='$destination_operational_hour',
          `destination_address`='$destination_address',
          `latitude`='$latitude',
          `longitude`='$longitude',
          `iconic`='$iconic',
          `id_category`='$id_category'
          WHERE `id_destination`='$id_destination'";
}

$update = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

if ($update) {
  // Pesan sukses dengan SweetAlert
  echo '<script>
          alert("Data Berhasil Diupdate");
          window.location.href = "../jadwal/jadwal.php"; // Ganti dengan halaman sukses aktual
        </script>';
} else {
  // Pesan kesalahan dengan SweetAlert
  echo '<script>
          alert("Gagal Diupdate");
          window.location.href = "../jadwal/jadwal.php"; // Ganti dengan halaman sukses aktual
        </script>';
}
?>

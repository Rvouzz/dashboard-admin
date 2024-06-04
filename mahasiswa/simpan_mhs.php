<?php
include '../koneksi.php';

if(isset($_POST['submit'])) {
    $category_name = $_POST['category_name'];

    // Check if category name already exists
    $checkQuery = "SELECT id_category FROM destination_category WHERE category_name = ?";
    $checkStmt = $koneksi->prepare($checkQuery);
    $checkStmt->bind_param("s", $category_name);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Category name already exists
        echo '<script>
                alert("Nama kategori sudah ada untuk kategori lain. Harap pilih yang berbeda.");
                window.location.href = "mahasiswa.php"; // Replace with the actual form page
              </script>';
        exit;
    }

    // File upload handling
    $file_tmp = $_FILES['category_image']['tmp_name'];
    $file_data = file_get_contents($file_tmp);

    // Insert data into the database using prepared statement
    $insertQuery = "INSERT INTO destination_category (category_name, category_image) VALUES (?, ?)";
    $insertStmt = $koneksi->prepare($insertQuery);
    $insertStmt->bind_param("ss", $category_name, $file_data);
    $insertStmt->execute();

    if ($insertStmt->affected_rows > 0) {
        echo '<script>
                alert("Data Berhasil Disimpan");
                window.location.href = "mahasiswa.php"; // Replace with the actual success page
              </script>';
    } else {
        echo "Gagal Disimpan";
    }

    $insertStmt->close();
    $checkStmt->close();
} else {
    echo "Form submission error.";
}
?>

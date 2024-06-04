<?php
include '../koneksi.php';

if (isset($_POST['submit'])) {
    $id = $_POST['id_category'];
    $category_name = $_POST['category_name'];

    // Check if category name already exists
    $checkQuery = "SELECT id_category FROM destination_category WHERE category_name = ?";
    $checkStmt = $koneksi->prepare($checkQuery);
    $checkStmt->bind_param("s", $category_name);
    $checkStmt->execute();
    
    // Dapatkan hasil dari prepared statement
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Dapatkan array asosiatif dari hasil set
        $existingCategory = $result->fetch_assoc();

        // Periksa jika kategori yang sudah ada bukan merupakan kategori yang sedang diupdate
        if ($existingCategory['id_category'] != $id) {
            // Nama kategori sudah ada untuk kategori lain
            echo '<script>
                    alert("Nama kategori sudah ada untuk kategori lain. Harap pilih yang berbeda.");
                    window.location.href = "mahasiswa.php"; // Ganti dengan halaman formulir aktual
                  </script>';
            exit;
        }
    }

    // Periksa jika file gambar baru diunggah
    if ($_FILES['category_image']['name'] != "") {
        // Penanganan unggah file
        $file_tmp = $_FILES['category_image']['tmp_name'];
        $file_data = file_get_contents($file_tmp);

        // Perbarui data di database termasuk gambar kategori menggunakan prepared statement
        $stmt = $koneksi->prepare("UPDATE destination_category SET category_name=?, category_image=? WHERE id_category=?");
        $stmt->bind_param("sss", $category_name, $file_data, $id);
        $stmt->execute();
    } else {
        // Perbarui data di database tanpa mengubah gambar kategori
        $stmt = $koneksi->prepare("UPDATE destination_category SET category_name=? WHERE id_category=?");
        $stmt->bind_param("ss", $category_name, $id);
        $stmt->execute();
    }

    if ($stmt->affected_rows > 0) {
        // Pesan sukses dengan SweetAlert
        echo '<script>
                alert("Data Berhasil Diupdate");
                window.location.href = "mahasiswa.php"; // Ganti dengan halaman sukses aktual
              </script>';
    } else {
        echo "Gagal Disimpan";
    }

    $stmt->close();
    $checkStmt->close();
} else {
    echo "Terjadi kesalahan pengiriman formulir.";
}
?>

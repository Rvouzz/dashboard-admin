<?php
include '../koneksi.php';

$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$role = $_POST['role'];

// Check if email already exists for another user
$checkQuery = "SELECT id FROM users WHERE email = ? AND id != ?";
$checkStmt = mysqli_prepare($koneksi, $checkQuery);
mysqli_stmt_bind_param($checkStmt, "si", $email, $id);
mysqli_stmt_execute($checkStmt);
mysqli_stmt_store_result($checkStmt);

if (mysqli_stmt_num_rows($checkStmt) > 0) {
    // Email sudah ada untuk pengguna lain, tampilkan pesan dan kembali ke halaman sebelumnya
    echo '<script>
            alert("Email sudah ada untuk pengguna lain. Silahkan gunakan email lain.");
            window.location.href = document.referrer;
          </script>';
    exit;
}

// Email belum ada atau milik pengguna saat ini, lakukan pembaruan data
$updateQuery = "UPDATE users SET id=?, username=?, email=?, role=? WHERE id=?";
$updateStmt = mysqli_prepare($koneksi, $updateQuery);
mysqli_stmt_bind_param($updateStmt, "issii", $id, $username, $email, $role, $id);
$update = mysqli_stmt_execute($updateStmt);

if ($update) {
    echo '<script>
            alert("Data Berhasil Diupdate");
            window.location.href = "../dosen/dosen.php";
          </script>';
} else {
    echo "Gagal Diupdate";
}

mysqli_stmt_close($updateStmt);
mysqli_stmt_close($checkStmt);
mysqli_close($koneksi);
?>

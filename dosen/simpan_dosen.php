<?php
include '../koneksi.php';

$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// Hash password sebelum menyimpan ke database
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Check if email already exists
$checkQuery = "SELECT id FROM users WHERE email = ?";
$checkStmt = mysqli_prepare($koneksi, $checkQuery);
mysqli_stmt_bind_param($checkStmt, "s", $email);
mysqli_stmt_execute($checkStmt);
mysqli_stmt_store_result($checkStmt);

if (mysqli_stmt_num_rows($checkStmt) > 0) {
    // Email sudah ada, tampilkan pesan dan kembali ke halaman sebelumnya
    echo '<script>
            alert("Email sudah ada. Silahkan gunakan email lain.");
            window.location.href = document.referrer;
          </script>';
    exit;
}

// Email belum ada, lakukan penyimpanan data
$insertQuery = "INSERT INTO users VALUES(?, ?, ?, ?, ?)";
$insertStmt = mysqli_prepare($koneksi, $insertQuery);
mysqli_stmt_bind_param($insertStmt, "issss", $id, $username, $email, $hashedPassword, $role);
$input = mysqli_stmt_execute($insertStmt);

if ($input) {
    echo '<script>
            alert("Data Berhasil Disimpan");
            window.location.href = "../dosen/dosen.php";
          </script>';
} else {
    echo "Gagal Disimpan";
}

mysqli_stmt_close($insertStmt);
mysqli_stmt_close($checkStmt);
mysqli_close($koneksi);
?>

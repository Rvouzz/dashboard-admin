<?php
session_start();

include '../koneksi.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

if (!$koneksi) {
    die("Gagal koneksi: " . mysqli_connect_error());
}

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($koneksi, $sql);

if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
    $_SESSION['pesan_error'] = "Password harus terdiri dari setidaknya 8 karakter dengan kombinasi huruf dan angka.";
    header("Refresh: 0; URL=../dashboard/signup.php");
    exit();
}

if (mysqli_num_rows($result) > 0) {
    $_SESSION['pesan_error'] = "Email sudah digunakan. Silahkan pilih Email lain.";
    header("Refresh: 0; URL=../dashboard/signup.php");
    exit();
} else {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username','$email', '$hashedPassword')";

    if (mysqli_query($koneksi, $sql)) {
        $_SESSION['pesan_sukses'] = "Pendaftaran berhasil!";
        header("Refresh: 0; URL=../dashboard/login.php");
        exit();
    } else {
        $_SESSION['pesan_error'] = "Gagal menyimpan data.";
        header("Refresh: 0; URL=../dashboard/signup.php");
        exit();
    }
}

mysqli_close($koneksi);

?>
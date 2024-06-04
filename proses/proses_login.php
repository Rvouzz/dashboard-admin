<?php
include '../koneksi.php';

$email = $_POST['email'];
$password = $_POST['password'];

if (!$koneksi) {
    die("Gagal koneksi: " . mysqli_connect_error());
}

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($koneksi, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $hashedPassword = $row['password'];

    if (password_verify($password, $hashedPassword)) {
        if (isset($_POST['rememberMe'])) {
            $hashemail = hash('sha512', $row['email']);
            setcookie('email', $hashemail, time() + 3600, '/');
        }

        // Check user role
        $userRole = $row['role'];

        if ($userRole === 'User') {
            // Redirect or handle accordingly for 'user' role
            session_start();
            $_SESSION['login_error'] = "Permission denied. You do not have access.";
            header("Refresh: 0; URL=../dashboard/login.php");
            exit(); // Ensure the script stops executing after redirection
        }

        // For other roles, continue as usual
        session_start();
        $_SESSION['email'] = $email;
        header("Location: ../mahasiswa/mahasiswa.php");
    }
}

// Login gagal
session_start();
$_SESSION['login_error'] = "Email atau password salah.";
header("Refresh: 0; URL=../dashboard/login.php");

mysqli_close($koneksi);
?>

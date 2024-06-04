<?php
include '../koneksi.php';
session_start();
if (isset($_COOKIE['email']) && isset($_COOKIE['id'])) {
  $email = $_COOKIE['email'];
  $query = mysqli_query($koneksi, "SELECT email FROM user WHERE id = '$id'");
  $row = mysqli_fetch_assoc($query);
  $email1 = $row['email'];
  if ($email === hash('sha512', $row['email'])) {
    $_SESSION['email'] = $row['email'];
    header("Location: index.php");
  }
}

if (isset($_SESSION['email'])) {
  header("Location: ../mahasiswa/mahasiswa.php");
  exit;
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <style>
    body {
      background-color: #f2f2f2;
      font-family: Arial, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      overflow: hidden;
    }

    .container {
      width: 300px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-top: 4px;
    }

    label {
      display: block;
      margin-bottom: 10px;
      color: black;
    }

    input[type="text"],
    input[type="password"] {
      width: 93%;
      padding: 10px;
      border: 1px solid grey;
      border-radius: 5px;
      margin-bottom: 5px;
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    .register-link {
      text-align: center;
      margin-top: 10px;
    }

    .register-link a {
      color: #666;
      text-decoration: none;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

  </style>
</head>

<body>
  <div class="container">
    <h2>LOGIN</h2>
    <form method="POST" action="../proses/proses_login.php">
      <label for="email">Email:</label>
      <input type="text" id="email" name="email" placeholder="Email" required><br><br>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" placeholder="Password" required><br><br>
      <span style="display: flex; align-items: center; gap: 0.2rem;"><input style="margin-top: -1rem;" type="checkbox" id="rememberMe" name="rememberMe">
        <label style="margin-top: -0.5rem; margin-bottom: 10px;" for="rememberMe">Remember Me</label></span>
      <input type="submit" value="Login">
    </form>

    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>

    <?php
    if (isset($_SESSION['pesan_sukses'])) {
      echo '<script>
        swal({
          title: "Success!",
          text: "' . $_SESSION['pesan_sukses'] . '",
          icon: "success",
          timer: 3000,
        });
      </script>';
      unset($_SESSION['pesan_sukses']);
    }

    if (isset($_SESSION['login_error'])) {
      echo '<script>
        swal({
          title: "Error!",
          text: "' . $_SESSION['login_error'] . '",
          icon: "error",
          timer: 2500,
        });
      </script>';
      unset($_SESSION['login_error']);
    }
    ?>

    <div class="register-link">
      <p>Belum punya akun? <a style="color: blue;" href="signup.php">Sign Up</a></p>
    </div>
  </div>
</body>

</html>
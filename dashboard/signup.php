<!DOCTYPE html>
<html>

<head>
  <title>Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
      position: relative;
      z-index: 2;
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

    .login-link {
      text-align: center;
      margin-top: 10px;
    }

    .login-link a {
      color: #666;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>

  <div class="container">
    <h2>SIGN UP</h2>
    <form method="POST" action="../proses/proses_register.php">
      <label for="username">Name:</label>
      <input type="text" id="username" name="username" placeholder="Name" required><br><br>

      <label for="email">Email:</label>
      <input type="text" id="email" name="email" placeholder="Email" required><br><br>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" placeholder="Password" required><br><br>

      <input type="submit" value="Sign Up">
    </form>



    <script>
      <?php
      session_start();
      if (isset($_SESSION['pesan_error'])) {
        echo 'swal({
      title: "Error!",
      text: "' . $_SESSION['pesan_error'] . '",
      icon: "error",
      timer: 3000,
    });';
        unset($_SESSION['pesan_error']);
      }
      ?>
    </script>


    <div class="login-link">
      <p>Sudah punya akun? <a style="color: blue;" href="login.php">Login</a></p>
    </div>
  </div>

  <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
  <script>
    var audioPlayer = document.getElementById('audio-player');
    var playButton = document.getElementById('play-button');
    var stopButton = document.getElementById('stop-button');
    var songDurationElement = document.getElementById('song-duration');
    var isPlaying = false;
    audioPlayer.volume = 0.04;

    function togglePlay() {
      if (isPlaying) {
        audioPlayer.pause();
        playButton.innerHTML = '<i class="fas fa-play"></i>';
      } else {
        audioPlayer.play();
        playButton.innerHTML = '<i class="fas fa-pause"></i>';
        audioPlayer.volume = 0.04;
      }
      isPlaying = !isPlaying;
    }

    function stopAudio() {
      audioPlayer.pause();
      audioPlayer.currentTime = 0;
      playButton.innerHTML = '<i class="fas fa-play"></i>';
      isPlaying = false;
    }

    function updateSongDuration() {
      var duration = audioPlayer.duration;
      var currentTime = audioPlayer.currentTime;
      var minutes = Math.floor(currentTime / 60);
      var seconds = Math.floor(currentTime % 60);
      var formattedDuration = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
      songDurationElement.textContent = formattedDuration;
    }

    audioPlayer.loop = true; // Menambahkan looping ke elemen audio

    playButton.addEventListener('click', togglePlay);
    stopButton.addEventListener('click', stopAudio);
    audioPlayer.addEventListener('timeupdate', updateSongDuration);
  </script>

</body>

</html>
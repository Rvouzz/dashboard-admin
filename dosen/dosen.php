<?php
session_start();

if (!isset($_SESSION['email'])) {
  header("Location: ../index.php");
  exit();
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../admin.css">
  <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <title>ADMINISTRATOR</title>
</head>
<style>
  #back-to-top {
    position: fixed;
    bottom: 0;
    right: 0;
    margin: 20px;

  }

  @media (max-width: 767px) {
    #back-to-top {
      display: none;
    }
  }
</style>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
    <a class="navbar-brand nav-link text-white" href="#">SELAMAT DATANG <span style="text-transform: uppercase;">
        <?php echo $_SESSION['email'] ?>
      </span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <form class="form-inline my-2 my-lg-0 ml-auto">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0 text-white" type="submit">Search</button>
      </form>
      <div class="icon ml-4">
        <h5>
          <a href="#">
            <i class="fas fa-envelope-square mr-3 mt-2 text-secondary"></i>
          </a>

          <a href="#">
            <i class="fas fa-bell-slash mr-3 mt-2 text-secondary"></i>
          </a>

          <a href="../proses/proses_logout.php" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt mr-3 mt-2 text-light"></i>
          </a>
        </h5>
      </div>
    </div>
  </nav>
  <div class="row no-gutters mt-5">
    <div class="col-md-2 bg-dark mt-2 pr-3 pt-4">
      <ul class="nav flex-column ml-3 mb-5">
        <li class="nav-item">
          <a class="nav-link text-white" href="../mahasiswa/mahasiswa.php"><i
              class="fas fa-user-graduate mr-2"></i>Daftar Kategori</a>
          <hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../jadwal/jadwal.php"><i class="far fa-calendar-alt mr-2"></i>Daftar
            Destinasi</a>
          <hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../dosen/dosen.php"><i class="fas fa-chalkboard-teacher mr-2"></i>Daftar
            Pengguna</a>
          <hr class="bg-secondary">
        </li>
      </ul>
    </div>

    <div class="col-md-10 p-5 pt-2">
      <h3>
        <i class="fas fa-chalkboard-teacher mr-2"></i>
        PENGGUNA
      </h3>
      <hr>
      <a href="#" class="btn btn-dark mb-2" data-toggle="modal" data-target="#tambahdsn">
        <i class="fas fa-plus-circle mr-2"></i>TAMBAH PENGGUNA</a>

      <table class="table table-striped table-bordered">
        <thread>
          <tr>
            <th scope="col" style="text-align: center;">NO</th>
            <th scope="col" style="text-align: center;">NAME</th>
            <th scope="col" style="text-align: center;">EMAIL</th>
            <th scope="col" style="text-align: center;">ROLE</th>
            <th colspan="3" scope="col" style="text-align: center;">AKSI</th>
          </tr>
        </thread>
        <?php
        include '../koneksi.php';

        $query = mysqli_query($koneksi, "SELECT * FROM users");
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
          ?>
          <tr>
            <center>
              <td style="text-align: center;">
                <?php echo $no++; ?>
              </td>
              <td style="text-align: center;">
                <?php echo $data['username']; ?>
              </td>
              <td style="text-align: center;">
                <?php echo $data['email']; ?>
              </td>
              <td style="text-align: center;">
                <?php echo $data['role']; ?>
              </td>
            </center>
            <td style="text-align: center;"><a href="#" data-toggle="modal"
                data-target="#editdsn<?php echo $data['id']; ?>">
                <button type="button" class="btn btn-success">
                  <i class="fas fa-edit"></i>
                  Edit
                </button>
              </a>

              <!-- Modal Delete -->
              <a href="#" data-toggle="modal" data-target="#deletedsn<?php echo $data['id']; ?>">
                <button type="button" class="btn btn-danger">
                  <i class="fas fa-trash-alt"></i>
                  Delete
                </button>
              </a>
            </td>
            <div class="example-modal">
              <div id="deletedsn<?php echo $data['id']; ?>" class="modal fade" role="dialog" style="display:none;">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">

                      <h3 class="modal-title">Konfirmasi Hapus Data</h3>
                    </div>
                    <div class="modal-body">
                      <h5 align="center">Apakah anda yakin ingin menghapus<br><span style="color: red;">
                          <?php echo $data['username']; ?>
                        </span> dari daftar pengguna<strong><span class="grt"></span></strong> ?</h5>
                    </div>
                    <div class="modal-footer">
                      <button id="nodelete" type="button" class="btn btn-danger pull-left"
                        data-dismiss="modal">Cancel</button>
                      <a href="hapus_dosen.php?id=<?php echo $data['id']; ?>" class="btn btn-primary">Delete</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </td>
          </tr>
          <!-- Update Modal -->
          <div class="example-modal">
            <div class="modal fade" id="editdsn<?php echo $data['id']; ?>" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title">Update data user</h3>
                  </div>
                  <div class="modal-body">
                    <form action="update_dosen.php" method="post" role="form">
                      <?php
                      $id = $data['id'];
                      $query1 = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'");
                      while ($data1 = mysqli_fetch_assoc($query1)) {
                        ?>
                        <input type="hidden" class="form-control" name="id" value="<?php echo $data1['id']; ?>">
                        <div class="form-group">
                          <div class="row">
                            <label class="col-sm-3 control-label text-right">Name</label>
                            <div class="col-sm-8"><input type="text" class="form-control" placeholder="Name" name="username"
                                value="<?php echo $data1['username']; ?>" required></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="col-sm-3 control-label text-right">Email</label>
                            <div class="col-sm-8"><input type="text" class="form-control" placeholder="email" name="email"
                                value="<?php echo $data1['email']; ?>" required></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="col-sm-3 control-label text-right">Role</label>
                            <div class="col-sm-8">
                              <select class="form-control" name="role" required>
                                <option value="User" <?php echo ($data1['role'] == 'User') ? 'selected' : ''; ?>>User</option>
                                <option value="Admin" <?php echo ($data1['role'] == 'Admin') ? 'selected' : ''; ?>>Admin
                                </option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer">
                          <button id="noedit" type="button" class="btn btn-danger pull-left"
                            data-dismiss="modal">Batal</button>
                          <input type="submit" name="submit" class="btn btn-primary" value="Update">
                        </div>
                        <?php
                      }
                      ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
        }
        ?>

      </table>
      </tbody>
      </table>
    </div>

  </div>
  <!-- Simpan Modal -->
  <div class="example-modal">
    <div id="tambahdsn" class="modal fade" role="dialog" style="display:none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Add new User</h3>
          </div>
          <div class="modal-body">
            <form action="simpan_dosen.php" method="post" role="form">
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Name</label>
                  <div class="col-sm-8"><input type="text" class="form-control" name="username" placeholder="Name"
                      value="" required></div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Email</label>
                  <div class="col-sm-8"><input type="text" class="form-control" name="email" placeholder="Email"
                      value="" required></div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Password</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" name="password" placeholder="Password" id="password"
                      required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Role</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="role" id="role" required>
                      <option value="User">User</option>
                      <option value="Admin">Admin</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button id="nosave" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Batal</button>
                <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL LOGOUT -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">Logout</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div style="text-align: center;" class="modal-body">
          Apakah Anda yakin ingin keluar dari <span style="text-transform: uppercase; color: red; font-weight: bold;">
            <?php echo $_SESSION['email'] ?>
          </span> ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <a class="btn btn-primary" href="../proses/proses_logout.php">Keluar</a>
        </div>
      </div>
    </div>
  </div>

  <a style="color: darkslategrey;" id="back-to-top" href="#top">
    <h2><i class="fas fa-arrow-up"></i></h2>
  </a>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>
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
  <title>ADMINISTRATOR</title>
</head>
<style>
  #back-to-top {
    position: fixed;
    bottom: 0;
    right: 0;
    margin: 20px;
    z-index: 9999;
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
        <i class="far fa-calendar-alt mr-2"></i>
        DESTINASI WISATA
      </h3>
      <hr>
      <a href="#" class="btn btn-dark mb-2" data-toggle="modal" data-target="#tambahjdwl">
        <i class="fas fa-plus-circle mr-2"></i>TAMBAH DESTINASI</a>

      <table class="table table-striped table-bordered">
        <thread>
          <tr>
            <th scope="col" style="text-align: center;">No</th>
            <th scope="col" style="text-align: center;">Name</th>
            <th scope="col" style="text-align: center;">Description</th>
            <th scope="col" style="text-align: center;">Operational</th>
            <th scope="col" style="text-align: center;">Address</th>
            <th scope="col" style="text-align: center;">Image 1</th>
            <th scope="col" style="text-align: center;">Image 2</th>
            <th scope="col" style="text-align: center;">Image 3</th>
            <th scope="col" style="text-align: center;">Latitude</th>
            <th scope="col" style="text-align: center;">Longitude</th>
            <th scope="col" style="text-align: center;">Iconic</th>
            <th colspan="3" scope="col" style="text-align: center;">AKSI</th>
          </tr>
        </thread>
        <?php
        include '../koneksi.php';

        $query = "
    SELECT dp.*, dc.id_category, dc.category_name
    FROM destination_place dp
    INNER JOIN destination_category dc ON dp.id_category = dc.id_category
";

        $result = mysqli_query($koneksi, $query);

        if ($result) {
          $no = 1;
          while ($data = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td style="text-align: center;">' . $no++ . '</td>';
            echo '<td style="text-align: center;">' . $data['destination_name'] . '</td>';
            echo '<td style="text-align: center;">' . (strlen($data['destination_description']) > 20 ? substr($data['destination_description'], 0, 20) . '...' : $data['destination_description']) . '</td>';
            echo '<td style="text-align: center;">' . $data['destination_operational_hour'] . '</td>';
            echo '<td style="text-align: center;">' . (strlen($data['destination_address']) > 20 ? substr($data['destination_address'], 0, 20) . '...' : $data['destination_address']) . '</td>';
            echo '<td style="text-align: center;">' . getImageHtml($data['destination_image_1']) . '</td>';
            echo '<td style="text-align: center;">' . getImageHtml($data['destination_image_2']) . '</td>';
            echo '<td style="text-align: center;">' . getImageHtml($data['destination_image_3']) . '</td>';
            echo '<td style="text-align: center;">' . number_format($data['latitude'], 4) . '</td>';
            echo '<td style="text-align: center;">' . number_format($data['longitude'], 4) . '</td>';
            echo '<td style="text-align: center;">' . $data['iconic'] . '</td>';
            echo '<td style="text-align: center;">';
            echo '<a href="#" data-toggle="modal" data-target="#editjdwl' . $data['id_destination'] . '">';
            echo '<button type="button" class="btn btn-success">';
            echo '<i class="fas fa-edit"></i> Edit</button></a>';
            echo '<a href="#" data-toggle="modal" data-target="#deletejdwl' . $data['id_destination'] . '">';
            echo '<button type="button" class="btn btn-danger">';
            echo '<i class="fas fa-trash-alt"></i> Delete</button></a>';
            echo '</td>';

            // Delete Modal
            echoDeleteModal($data['id_destination'], $data['destination_name']);

            // Update Modal
            echoUpdateModal($data);
            echo '</tr>';
          }
        }

        // Don't forget to free the result set
        mysqli_free_result($result);

        function getImageHtml($imageData)
        {
          $imageData = base64_encode($imageData);
          $imageType = "image/jpeg";
          $imageUrl = "data:$imageType;base64,$imageData";
          return "<img src='$imageUrl' alt='Destination Image' style='max-width: 100px; max-height: 100px;'>";
        }

        function echoDeleteModal($id_destination, $destination_name)
        {
          echo '<div class="example-modal">';
          echo '<div id="deletejdwl' . $id_destination . '" class="modal fade" role="dialog" style="display:none;">';
          echo '<div class="modal-dialog">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h3 class="modal-title">Konfirmasi Hapus Data</h3>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<h5 align="center">Apakah anda yakin ingin menghapus<br><span style="color: red;">';
          echo $destination_name;
          echo '</span> dari Destinasi Wisata<strong><span class="grt"></span></strong>?</h5>';
          echo '</div>';
          echo '<div class="modal-footer">';
          echo '<button type="button" class="btn btn-danger float-left" data-dismiss="modal">Cancel</button>';
          echo '<a href="hapus_jadwal.php?id_destination=' . $id_destination . '" class="btn btn-primary">Delete</a>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }

        function echoUpdateModal($data)
        {
          echo '<div class="example-modal">';
          echo '<div id="editjdwl' . $data['id_destination'] . '" class="modal fade" role="dialog" style="display:none;">';
          echo '<div class="modal-dialog">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h3 class="modal-title">Edit Destination</h3>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<form action="update_jadwal.php" method="post" role="form" enctype="multipart/form-data">';
          echo '<input type="hidden" class="form-control" name="id_destination" value="' . $data['id_destination'] . '">';

          echo '<div class="form-group">';
          echo '<div class="row">';
          echo '<label class="col-sm-3 control-label text-right">Destination Name</label>';
          echo '<div class="col-sm-8">';
          echo '<input type="text" class="form-control" name="destination_name" placeholder="Destination Name" value="' . $data['destination_name'] . '">';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '<div class="row">';
          echo '<label class="col-sm-3 control-label text-right">Description</label>';
          echo '<div class="col-sm-8">';
          echo '<textarea class="form-control" name="destination_description" placeholder="Destination Description">' . $data['destination_description'] . '</textarea>';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '<div class="row">';
          echo '<label class="col-sm-3 control-label text-right">Operational Hour</label>';
          echo '<div class="col-sm-8">';
          echo '<input type="text" class="form-control" name="destination_operational_hour" placeholder="Operational Hours" value="' . $data['destination_operational_hour'] . '">';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '<div class="row">';
          echo '<label class="col-sm-3 control-label text-right">Address</label>';
          echo '<div class="col-sm-8">';
          echo '<input type="text" class="form-control" name="destination_address" placeholder="Destination Address" value="' . $data['destination_address'] . '">';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '<div class="row">';
          echo '<label class="col-sm-3 control-label text-right">Image 1</label>';
          echo '<div class="col-sm-8">';
          echo '<input type="file" name="destination_image_1" accept="image/*">';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '<div class="row">';
          echo '<label class="col-sm-3 control-label text-right">Image 2</label>';
          echo '<div class="col-sm-8">';
          echo '<input type="file" name="destination_image_2" accept="image/*">';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '<div class="row">';
          echo '<label class="col-sm-3 control-label text-right">Image 3</label>';
          echo '<div class="col-sm-8">';
          echo '<input type="file" name="destination_image_3" accept="image/*">';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '<div class="row">';
          echo '<label class="col-sm-3 control-label text-right">Latitude</label>';
          echo '<div class="col-sm-8">';
          echo '<input type="text" class="form-control" name="latitude" placeholder="Latitude" value="' . $data['latitude'] . '">';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '<div class="row">';
          echo '<label class="col-sm-3 control-label text-right">Longitude</label>';
          echo '<div class="col-sm-8">';
          echo '<input type="text" class="form-control" name="longitude" placeholder="Longitude" value="' . $data['longitude'] . '">';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '<div class="row">';
          echo '<label class="col-sm-3 control-label text-right">Iconic</label>';
          echo '<div class="col-sm-8">';
          $checked = ($data['iconic'] == 1) ? 'checked' : '';
          echo '<input type="checkbox" name="iconic" value="1" ' . $checked . '> Yes';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '<div class="row">';
          echo '<label class="col-sm-3 control-label text-right">Category</label>';
          echo '<div class="col-sm-8">';
          echo '<select class="form-control" name="id_category">';

          // Fetch and display categories from destination_category table
          include '../koneksi.php';
          $query = "SELECT id_category, category_name FROM destination_category";
          $result = mysqli_query($koneksi, $query);

          if ($result) {
            while ($row = mysqli_fetch_array($result)) {
              $id_category = $row['id_category'];
              $category_name = $row['category_name'];
              $selected = ($id_category == $data['id_category']) ? 'selected' : '';
              echo '<option value="' . $id_category . '" ' . $selected . '>' . $category_name . '</option>';
            }
          }

          echo '</select>';
          echo '</div>';
          echo '</div>';
          echo '</div>';

          echo '<div class="modal-footer">';
          echo '<button type="button" class="btn btn-danger float-left" data-dismiss="modal">Cancel</button>';
          echo '<input type="submit" name="submit" class="btn btn-primary" value="Update">';
          echo '</div>';
          echo '</form>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }

        ?>
        </tbody>
      </table>
    </div>
  </div>


  <!-- Simpan Modal -->
  <div class="example-modal">
    <div id="tambahjdwl" class="modal fade" role="dialog" style="display:none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Tambah Destinasi Baru</h3>
          </div>
          <div class="modal-body">
            <form action="simpan_jadwal.php" method="post" role="form" enctype="multipart/form-data">
              <div class="col-sm-8"><input type="hidden" class="form-control" name="id_destination" placeholder="id"
                  value="" required></div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Destination Name</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="destination_name" placeholder="Destination Name"
                      required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Description</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" name="destination_description" placeholder="Destination Description"
                      required></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Operational Hour</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="destination_operational_hour"
                      placeholder="Operational Hours" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Address</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="destination_address" placeholder="Destination Address"
                      required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Image 1</label>
                  <div class="col-sm-8">
                    <input type="file" name="destination_image_1" accept="image/*" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Image 2</label>
                  <div class="col-sm-8">
                    <input type="file" name="destination_image_2" accept="image/*" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Image 3</label>
                  <div class="col-sm-8">
                    <input type="file" name="destination_image_3" accept="image/*" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Latitude</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="latitude" placeholder="Latitude" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Longitude</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="longitude" placeholder="Longitude" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Iconic</label>
                  <div class="col-sm-8">
                    <input type="checkbox" name="iconic" value="1"> Yes
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Category</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="id_category" required>
                      <!-- Fetch and display categories from destination_category table -->
                      <?php
                      $query = "SELECT id_category, category_name FROM destination_category";
                      $result = mysqli_query($koneksi, $query);

                      if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                          $id_category = $row['id_category'];
                          $category_name = $row['category_name'];
                          echo '<option value="' . $id_category . '">' . $category_name . '</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger float-left" data-dismiss="modal">Batal</button>
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
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>

</html>
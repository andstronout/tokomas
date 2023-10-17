<?php
session_start();
require 'config.php';
$id = $_SESSION['id_pelanggan'];
$sql = sql("SELECT * FROM user WHERE id_user='$id'");
$query = $sql->fetch_assoc();
// var_dump($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body style="background-color: #eaeaea;">
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h2 class="text-center text-dark mt-4">Edit Profile</h2>
        <div class="card my-3">
          <form class="card-body cardbody-color p-lg-5" method="post">
            <div class="text-center">
              <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle mb-3" width="150px" alt="profile" style="margin-top: -30px;">
            </div>

            <div class="mb-3">
              <label for="nama" class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control" id="nama" aria-describedby="namaHelp" name="nama_pelanggan" value="<?= $query['nama_user']; ?>" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" aria-describedby="emailHelp" name="email" value="<?= $query['email']; ?>" readonly>
            </div>
            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat</label>
              <textarea name="alamat_pelanggan" class="form-control" id="" cols="30" rows="5"><?= $query['alamat']; ?></textarea required>
            </div>
            <div class="mb-3">
              <label for="tlp" class="form-label">Nomor Handphone</label>
              <input type="tel" class="form-control" id="tlp" aria-describedby="tlpHelp" name="tlp_pelanggan" value="<?= $query['nomor_hp']; ?>" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-outline-info px-5 mb-2 w-100" name="submit">Edit Profil</button>
              <a href="index.php" class="btn btn-outline-secondary px-5 w-100">Halaman Utama</a>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <?php
  if (isset($_POST['submit'])) {
    $update = ("UPDATE user SET nama_user='$_POST[nama_pelanggan]', alamat='$_POST[alamat_pelanggan]', nomor_hp='$_POST[tlp_pelanggan]' WHERE id_user='$id'");
    if (sql($update) == true) {
      echo "
      <script>
      alert('Data Profile berhasil diubah!');
      window.location.href='index.php';
      </script>
      ";
    } else {
      echo '
      <scrpit>
      alert("Data Profile gagal diubah!");
      </scrpit>
      ';
    }
  }

  ?>


  <script src="<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
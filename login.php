<?php
session_start();
require 'config.php';
if (isset($_SESSION['login_pelanggan'])) {
  header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="images/favicon.png" type="">
  <title>Nadia Ryan Jewelry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body style="background-color: #eaeaea;">
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h2 class="text-center text-dark mt-4">Login </h2>
        <div class="card my-3">
          <form class="card-body cardbody-color p-lg-5" method="post">
            <div class="text-center">
              <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle mb-3" width="150px" alt="profile" style="margin-top: -30px;">
            </div>

            <div class="mb-3">
              <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Masukan Email" name="email" required>
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" id="password" placeholder="Masukan Password" name="password" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-outline-info px-5 mb-3 w-100" name="submit">Login</button>
            </div>
          </form>
          <p class="text-center" style="margin-top: -50px; margin-bottom: 30px;">Belum punya akun? <a href="registrasi.php">Registrasi Sekarang</a></p>
        </div>
      </div>
    </div>
  </div>

  <?php
  if (isset($_POST['submit'])) {
    // Ambil dari form
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    // var_dump($email, $password);

    // ambil dari DB
    $sql = sql("SELECT * FROM user WHERE email='$email' AND `password`='$password'");
    $user = $sql->fetch_assoc();
    // var_dump($user);

    if (!empty($user)) {
      if ($user['level'] == 1) {
        $_SESSION['login_pelanggan'] = true;
        $_SESSION['id_pelanggan'] = $user['id_user'];
        header("location:index.php");
      } elseif ($user['level'] == 2) {
        $_SESSION['login_admin'] = true;
        $_SESSION['id_admin'] = $user['id_user'];
        header("location:admin/index.php");
      } else {
        $_SESSION['login_owner'] = true;
        $_SESSION['id_owner'] = $user['id_user'];
        header("location:owner/index.php");
      }
    } else {
      echo "
        <script>
        alert('Email atau Password salah');
        document.location.href = 'login.php';
        </script>
        ";
    }
  }

  ?>


  <script src="<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
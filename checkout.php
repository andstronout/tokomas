<?php
session_start();
require "config.php";
$conn = koneksi();
if (!isset($_SESSION['login_pelanggan'])) {
  header("location:login.php");
}
$sql_cart = sql("SELECT * FROM cart INNER JOIN produk ON cart.id_produk=produk.id_produk WHERE id_user='$_SESSION[id_pelanggan]'");
$total_harga = 0;
while ($cart = $sql_cart->fetch_assoc()) {
  $total_harga += $cart['harga_produk'] * $cart['qty_cart'];
}

if (isset($_POST["submit"])) {
  $id_user = $_SESSION['id_pelanggan'];
  $tanggal_transaksi = date("y-m-d");
  $total_transaksi = $total_harga;
  $status = 'Belum Diproses';

  $sumber = @$_FILES['bukti_bayar']['tmp_name'];
  $target = 'images/bukti_bayar/';
  $nama_bukti_bayar = @$_FILES['bukti_bayar']['name'];

  if (@$_FILES['bukti_bayar']['error'] > 0) {
    echo "
    <script>
    alert('Bukti Bayar Tidak Boleh Kosong!');
    </script>
    ";
  } else if (@$_FILES['bukti_bayar']['type'] != 'image/jpg' && @$_FILES['bukti_bayar']['type'] != 'image/png' && @$_FILES['bukti_bayar']['type'] != 'image/jpeg') {
    echo "
    <script>
    alert('Silahkan Upload Bukti Bayar Dengan Benar!');
    </script>
    ";
  } else {
    $pindah = move_uploaded_file($sumber, $target . $nama_bukti_bayar);
    $tambah_transaksi = $conn->query("INSERT INTO transaksi (id_user,tanggal_transaksi,total_transaksi,bukti_bayar,`status`) VALUES ('$id_user','$tanggal_transaksi','$total_transaksi','$nama_bukti_bayar','$status') ");
    $id_transaksi = $conn->insert_id;
    // var_dump($id_transaksi);

    $t = time();
    $id_pesanan = "NRJ" . $t;
    $update = sql("UPDATE transaksi SET id_pesanan='$id_pesanan' WHERE id_transaksi='$id_transaksi'");

    foreach ($sql_cart as $cart) {
      $tambah_detail = sql("INSERT INTO detail_transaksi (id_transaksi,id_produk,qty_transaksi) VALUES ('$id_transaksi','$cart[id_produk]','$cart[qty_cart]')");
      $total = $cart['qty_produk'] - $cart['qty_cart'];
      $update_stok = sql("UPDATE produk SET qty_produk='$total' WHERE id_produk='$cart[id_produk]'");
    }

    $hapus_cart = sql("DELETE FROM cart WHERE id_user='$id_user'");
    $url = "sukses.php?id=" . $id_transaksi;
    header("location:" . $url);
  }
}


?>
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="">
  <title>Nadia Ryan Jewelry</title>
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body>
  <div class="container-fluid mt-2">
    <nav class="navbar navbar-expand-lg custom_nav-container ">
      <a class="navbar-brand" href="index.html"><img width="250" src="images/logo.png" alt="#" /></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class=""> </span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#produk">Products</a>
          </li>
          <?php
          if (!isset($_SESSION['login_pelanggan'])) { ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
          <?php } else { ?>
            <?php
            $sql_user = sql("SELECT * FROM user WHERE id_user='$_SESSION[id_pelanggan]'");
            $user = $sql_user->fetch_assoc();
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> <span class="nav-label">Halo <?= $user['nama_user']; ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="pesanan_saya.php">Pesanan Saya</a></li>
                <li><a href="ubah_password.php">Ubah Password</a></li>
                <li><a href="ubah_profil.php">Ubah Profil</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </li>
          <?php } ?>
        </ul>
      </div>
    </nav>
    <!-- header section strats -->
    <header class="header_section">
    </header>
    <!-- end header section -->
  </div>

  <!-- product section -->
  <section class="product_section" id="produk">
    <div class="container" style="min-height: 300px;">
      <div class="heading_container heading_center">
        <h2>
          Payment <span>Summary</span>
        </h2>
      </div>
      <div class="container">
        <div class="row border-top border-bottom py-2">
          <div class="col-md-8 px-4 py-4">
            <h4 class="border-top py-3">Payment Details</h4>
            <p>Nama Pelanggan : <?= $user['nama_user'] . '-' . $user['nomor_hp']; ?></p>
            <p>Alamat Lengkap : <?= $user['alamat']; ?></p>
            <div class=" alert alert-info mt-2 " role="alert">
              Silahkan melakukan pembayaran pada <br>
              BCA : 123123123 ( Rivaldo )<br>
              Dana : 08123123123 <br><br>
              <strong>Simpan dan submit bukti pembayaran agar pesanan segera di proses</strong>
            </div>
            <div class="mb-3">
              <form action="" method="post" enctype="multipart/form-data">
                <label for="formFileSm" class="form-label"><b>Upload bukti pembayaran disini</b></label>
                <input class="form-control form-control-sm" id="formFileSm" type="file" name="bukti_bayar">
            </div>
          </div>
          <div class="col-md-4 px-5 py-5 border">
            <h5>Subtotal</h5>
            <p class="mt-4">Rp. <?= number_format($total_harga); ?>,-</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md mt-4 d-flex justify-content-end">
          <h4>Jumlah Bayar : Rp. <?= number_format($total_harga); ?>,-</h4>
        </div>
        <br>
      </div>
      <div class="col-md mx-2 my-2  d-flex justify-content-end">
        <a href="cart.php" class="btn btn-outline-secondary mx-2">Halaman Keranjang</a>
        <button type="submit" name="submit" class="btn btn-outline-primary">Proses Sekarang</button>
        </form>
      </div>
    </div>

  </section>
  <!-- end product section -->
  <!-- footer start -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="full">
            <div class="logo_footer">
              <a href="#"><img width="210" src="images/logo.png" alt="#" /></a>
            </div>
            <div class="information_f">
              <p><strong>ADDRESS:</strong>Manado, Indonesia</p>
              <p><strong>TELEPHONE:</strong> +91 987 654 3210</p>
              <p><strong>EMAIL:</strong> nadyaryan@gmail.com</p>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-5 ">
              <div class="widget_menu">
                <h3>Newsletter</h3>
                <div class="information_f">
                  <p>Subscribe by our newsletter and get update protidin.</p>
                </div>
                <div class="form_sub">
                  <form>
                    <fieldset>
                      <div class="field">
                        <input type="email" placeholder="Enter Your Mail" name="email" />
                        <input type="submit" value="Subscribe" />
                      </div>
                    </fieldset>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- footer end -->
  <div class="cpy_">
    <p class="mx-auto">© 2021 All Rights Reserved By <a href="#">Nadya Ryan Jewelry</a>
    </p>
  </div>
  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="js/popper.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
</body>

</html>
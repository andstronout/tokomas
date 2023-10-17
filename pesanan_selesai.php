<?php
session_start();
require "config.php";
$conn = koneksi();
if (!isset($_SESSION['login_pelanggan'])) {
  header("location:login.php");
}

$sql_transaksi = sql("SELECT * FROM transaksi WHERE id_user='$_SESSION[id_pelanggan]' AND `status`='Selesai'");

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
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Pesanan <span>Saya</span>
        </h2>
      </div>
      <div class="row my-4 ">
        <div class="col-4 d-flex justify-content-center border-right">
          <a href="pesanan_saya.php" class="text-dark">Belum Diproses</a>
        </div>
        <div class="col-4 d-flex justify-content-center">
          <a href="pesanan_diproses.php" class="text-dark">Sudah Diproses</a>
        </div>
        <div class="col-4 d-flex justify-content-center border-left">
          <a href="pesanan_selesai.php" class="text-info">Selesai</a>
        </div>
      </div>
      <div class="container">
        <div class="row border-bottom pt-4 d-flex justify-content-center align-items-center">
          <?php
          if ($sql_transaksi->num_rows > 0) {
            foreach ($sql_transaksi as $transaksi) { ?>
              <div class="row" style="width: 100%;">
                <div class="col-10">
                  <h5>Pesanan : <?= $transaksi['id_pesanan']; ?> <small> - Nomor resi : <?= $transaksi['no_resi']; ?></small></h5>
                </div>
              </div>
              <?php
              $sql_detail = sql("SELECT * FROM detail_transaksi INNER JOIN transaksi ON detail_transaksi.id_transaksi=transaksi.id_transaksi INNER JOIN produk ON detail_transaksi.id_produk=produk.id_produk WHERE id_user='$_SESSION[id_pelanggan]' AND `status`='Selesai' AND transaksi.id_transaksi='$transaksi[id_transaksi]'");
              foreach ($sql_detail as $detail) { ?>
                <div class="row border-top border-bottom main d-flex justify-content-center align-items-center mx-4 mb-3">
                  <div class="col-2"><img class="img-fluid" src="images/produk/<?= $detail['gambar_produk']; ?>"></div>
                  <div class="col-5">
                    <div class="row text-muted"><?= $detail['jenis']; ?></div>
                    <div class="row"><?= $detail['nama_produk']; ?></div>
                  </div>
                  <div class="col-2">
                    <?= $detail['qty_transaksi']; ?> Pcs
                  </div>
                  <div class="col-2">
                    <?php echo 'Rp. ' . number_format($total_harga = $detail['harga_produk'] * $detail['qty_transaksi']); ?>
                  </div>
                </div>
            <?php
              }
            } ?>
          <?php } else { ?>
            <div class="row border-top border-bottom main d-flex justify-content-center align-items-center mx-4">
              <div class=" alert alert-info mt-5 text-center" role="alert">
                Keranjang belanja kosong. Silahkan pilih barang terlebih dahulu. <a href="index.php#produk">Pilih Produk</a>
              </div>
            </div>
          <?php } ?>
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
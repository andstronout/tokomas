<?php
session_start();
require "config.php";
$conn = koneksi();
if (!isset($_SESSION['login_pelanggan'])) {
  header("location:login.php");
}

$sql_transaksi = sql("SELECT * FROM transaksi WHERE id_user='$_SESSION[id_pelanggan]' AND `status`='Sedang Diproses'");

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
</head>

<body>

  <?php foreach ($sql_transaksi as $transaksi) {
    echo "<p>" . $transaksi['id_pesanan'] . "</p>";
    $sql_detail = sql("SELECT * FROM detail_transaksi INNER JOIN transaksi ON detail_transaksi.id_transaksi=transaksi.id_transaksi INNER JOIN produk ON detail_transaksi.id_produk=produk.id_produk WHERE id_user='$_SESSION[id_pelanggan]' AND `status`='Sedang Diproses' AND transaksi.id_transaksi='$transaksi[id_transaksi]'");
    foreach ($sql_detail as $detail) {
      echo "<p>" . $detail['nama_produk'] . ' - ' . $detail['qty_transaksi'] . "</p>";
    }
  } ?>
  <?php
  ?>

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
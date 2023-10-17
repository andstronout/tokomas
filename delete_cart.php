<?php
require 'config.php';
$id = $_GET['id'];
$hapus = sql("DELETE FROM cart WHERE id_cart ='$id'");

header("location:cart.php");

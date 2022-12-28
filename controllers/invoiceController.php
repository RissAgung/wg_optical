<?php

include "../config/koneksi.php";

$crud = new koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["type"])) {
    if ($_POST["type"] == "confirm") {
      $crud->execute("UPDATE transaksi SET status_confirm = '2', status_pengiriman= 'produksi' WHERE kode_pesanan = '" . $_POST['id'] . "'");

      $response = array(
        'status' => 'success',
        'msg' => 'Pesanan sudah di konfirmasi'
      );

      echo json_encode($response);
      exit();
    }

    if ($_POST["type"] == "tracking") {
      $crud->execute("UPDATE transaksi SET status_pengiriman= '" .  $_POST['status'] . "' WHERE kode_pesanan = '" . $_POST['id'] . "'");

      $response = array(
        'status' => 'success',
        'msg' => 'Status pengiriman berhasil di edit',
      );
      echo json_encode($response);
      exit();
    }
  }
}

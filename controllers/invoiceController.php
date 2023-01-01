<?php

include "../config/koneksi.php";

$crud = new koneksi();

if (isset($_GET['check'])) {
  if ($_GET['check'] == 'requestPembelian') {
    $res = $crud->showData("SELECT COUNT(*) as checkRequest FROM pegawai JOIN transaksi ON pegawai.id_pegawai = transaksi.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN cicilan ON transaksi.kode_pesanan = cicilan.kode_pesanan WHERE transaksi.status_confirm = '1'");
    foreach ($res as $value) {
      $json = $value['checkRequest'];
    }

    echo $json;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["type"])) {
    if ($_POST["type"] == "confirm") {

      $detailBawa = $crud->showData("SELECT frame_transaksi.id_detail_bawa FROM frame_transaksi RIGHT JOIN detail_transaksi ON frame_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan JOIN transaksi ON detail_transaksi.kode_pesanan = transaksi.kode_pesanan WHERE transaksi.kode_pesanan = '" . $_POST['id'] . "'");

      if ($detailBawa[0]['id_detail_bawa'] != null) {

        foreach ($detailBawa as $index) {
          $indexDB = strpos($index['id_detail_bawa'], '-');
          $id_produk = substr($index['id_detail_bawa'], 0, $indexDB);

          $stock = $crud->showData("SELECT stock FROM produk WHERE kode_frame = '" . $id_produk . "'");
          $stockDb = $stock[0]["stock"];
          $finalStock = $stockDb - 1;
          $crud->execute("DELETE FROM detail_bawa WHERE Id_Bawa = '" . $index['id_detail_bawa'] . "'");
          $crud->execute("UPDATE produk SET stock='$finalStock' WHERE kode_frame = '$id_produk'");
        }

      }

      $crud->execute("UPDATE transaksi SET status_confirm = '2', status_pengiriman= 'produksi' WHERE transaksi.kode_pesanan = '" . $_POST['id'] . "'");

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

    if ($_POST["type"] == "cicilan") {

      $edit_total_bayar = $_POST["total_bayar"] + $_POST["total_bayar_old"];

      $crud->execute("INSERT INTO detail_cicilan VALUES ('" . $_POST['id_cicilan'] . "',NOW(),'" . $_POST['total_bayar'] . "')");
      $crud->execute("UPDATE transaksi SET total_bayar='" . $edit_total_bayar . "' WHERE kode_pesanan = '" . $_POST['id_tr'] . "'");

      if ($edit_total_bayar - $_POST["total_harga"] > 0) {
        $crud->execute("UPDATE transaksi SET kembalian='" . $edit_total_bayar - $_POST["total_harga"] . "' WHERE kode_pesanan = '" . $_POST['id_tr'] . "'");
      }

      $response = array(
        'status' => 'success',
        'msg' => 'Cicilan berhasil di inputkan',
      );
      echo json_encode($response);
      exit();
    }

    if ($_POST["type"] == "pengiriman_terima") {
      $crud->execute("UPDATE transaksi SET status_pengiriman='" . $_POST['status'] . "' WHERE transaksi.kode_pesanan = '" . $_POST['id'] . "'");
      $response = array(
        'status' => 'success',
        'msg' => 'Bukti pengiriman telah di konfirmasi',
      );
      echo json_encode($response);
      exit();
    }
  }
}

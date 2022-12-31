<?php

include "../config/koneksi.php";

$crud = new koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["type"])) {
    if ($_POST["type"] == "confirm") {
      $index = strpos($_POST['detail_bawa'], '-');
      $id_produk = substr($_POST['detail_bawa'], 0, $index);

      $stock = $crud->showData("SELECT stock FROM produk WHERE kode_frame = '".$id_produk."'");
      $stockDb = $stock[0]["stock"];
      $finalStock = $stockDb - 1;

      $crud->execute("UPDATE transaksi SET status_confirm = '2', status_pengiriman= 'produksi' WHERE transaksi.kode_pesanan = '" . $_POST['id'] . "'");
      $crud->execute("DELETE FROM detail_bawa WHERE Id_Bawa = '".$_POST['detail_bawa']."'");
      $crud->execute("UPDATE produk SET stock='$finalStock' WHERE kode_frame = '$id_produk'");

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
        $crud->execute("UPDATE transaksi SET kembalian='" . $edit_total_bayar - $_POST["total_harga"]. "' WHERE kode_pesanan = '" . $_POST['id_tr'] . "'");
      }

      $response = array(
        'status' => 'success',
        'msg' => 'Cicilan berhasil di inputkan',
      );
      echo json_encode($response);
      exit();
    }

    if ($_POST["type"] == "pengiriman_terima"){
      $crud->execute("UPDATE transaksi SET status_pengiriman='".$_POST['status']."' WHERE transaksi.kode_pesanan = '".$_POST['id']."'");
      $response = array(
        'status' => 'success',
        'msg' => 'Bukti pengiriman telah di konfirmasi',
      );
      echo json_encode($response);
      exit();
    }
  }
}

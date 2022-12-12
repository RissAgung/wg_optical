<?php

include "../config/koneksi.php";
$crud = new koneksi();
$variant_send = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["type"])) {
    if ($_POST["type"] == "insert") {
      $crud->execute($_POST["query_keranjang"]);
      $crud->execute($_POST["keranjang_frame"]);
      $crud->execute($_POST["query_Keranjang_Lensa"]);
      $crud->execute($_POST["query_keranjang_resep"]);

      $response = array(
        'status' => 'success',
        'msg' => 'Berhasil Memasukkan Ke keranjang',
      );
      echo json_encode($response);
      exit();

    } elseif ($_POST["type"] == "insert_frame") {
      $crud->execute($_POST["query_keranjang"]);
      $crud->execute($_POST["keranjang_frame"]);
      $response = array(
        'status' => 'success',
        'msg' => 'Berhasil Memasukkan Frame Ke keranjang',
      );
      echo json_encode($response);
      exit();
    }elseif ($_POST["type"] == "insert_lensa") {
      $crud->execute($_POST["query_keranjang"]);
      $crud->execute($_POST["query_Keranjang_Lensa"]);
      $crud->execute($_POST["query_keranjang_resep"]);
      $response = array(
        'status' => 'success',
        'msg' => 'Berhasil Memasukkan Lensa Ke keranjang',
      );
      echo json_encode($response);
      exit();
    }
  } else {
    for ($i = 0; $i < count($_POST); $i++) {
      array_push($variant_send, (array) json_decode($_POST['data-' . $i]));
      $crud->execute("INSERT INTO detail_varian_lensa_keranjang VALUES ('" . $variant_send[$i]['kodeVariant'] . "', '" . $variant_send[$i]['kode'] . "')");
    }
    $response = array(
      'status' => 'success',
      'msg' => 'Berhasil Memasukkan Ke keranjang',
    );
    echo json_encode($response);
    exit();
  }
}

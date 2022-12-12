<?php

include "../config/koneksi.php";
$crud = new koneksi();
$variant_send = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["type"])) {
    if ($_POST["type"] == "insert") {
      $crud->execute($_POST["query_keranjang"]);
      $crud->execute($_POST["query_Detail_keranjang"]);
      $crud->execute($_POST["query_Keranjang_Lensa"]);
      $crud->execute($_POST["query_keranjang_resep"]);
      echo 'awkakwoa';
    } elseif ($_POST["type"] == "insert_frame") {
      $crud->execute($_POST["query_keranjang"]);
      $crud->execute($_POST["query_Detail_keranjang"]);
      echo 'hahahahah';
    }
  } else {
    for ($i = 0; $i < count($_POST); $i++) {
      array_push($variant_send, (array) json_decode($_POST['data-' . $i]));
      echo ($variant_send[$i]['kodeVariant']);
      $crud->execute("INSERT INTO detail_varian_lensa_keranjang VALUES ('" . $variant_send[$i]['kodeVariant'] . "', '" . $variant_send[$i]['kode'] . "')");
      //$crud->execute("INSERT INTO `detail_varian_lensa_keranjang` VALUES ( $variant_send[$i]['kodeVariant'] , $variant_send[$i]['kode'] )");
    }
  }
}

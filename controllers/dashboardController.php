<?php
include '../config/koneksi.php';

$crud = new koneksi();

if (isset($_POST["type"])) {
  if ($_POST["type"] == "get_daerah") {
    $daerah = [];
    $jumlah = [];

    $daerahDB = $crud->showData("SELECT DISTINCT kecamatan FROM customer");

    foreach ($daerahDB as $index) {
      array_push($daerah, array(
        "daerah" => $index["kecamatan"],
      ));
    }

    for ($i = 0; $i < count($daerah); $i++) {
      $jumlahDB = $crud->showData("SELECT COUNT(kecamatan) AS jumlah, kecamatan FROM customer WHERE kecamatan = '" . $daerah[$i]['daerah'] . "'");
      foreach ($jumlahDB as $index) {
        if ($daerah[$i]['daerah'] == $index['kecamatan']) {
          $daerah[$i]["jumlah"] = $index["jumlah"];
        }
      }
    }

    echo json_encode($daerah);
    exit();
  }
}

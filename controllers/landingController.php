<?php

include "../config/koneksi.php";
$crud = new koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["type"])) {
    if ($_POST["type"] == "up_bukti") {

      $imgproduk_name = $_FILES['image_produk']['name'];
      $imgproduk_size = $_FILES['image_produk']['size'];
      $tmpproduk_name = $_FILES['image_produk']['tmp_name'];
      $errorproduk    = $_FILES['image_produk']['error'];
      $allowed_exs = array("jpg", "jpeg", "png");

      if ($errorproduk === 0) {
        if ($imgproduk_size > 10000000) {
          $response = array(
            'status' => 'error',
            'msg' => 'File Foto Terlalu Besar'
          );
          echo json_encode($response);
          exit();
        } else {
          if (!in_array(pathinfo($imgproduk_name, PATHINFO_EXTENSION), $allowed_exs)) {
            $response = array(
              'status' => 'error',
              'msg' => 'Ekstensi Foto Tidak Sesuai'
            );
            echo json_encode($response);
            exit();
          } else {
            $img_upload_path_produk = "../images/landing/" . $_POST['img_file_produk'];
            move_uploaded_file($tmpproduk_name, $img_upload_path_produk);
            $crud->execute($_POST["query"]);
            $response = array(
              'status' => 'success',
              'msg' => 'Berhasil Menambah Gambar'
            );
            echo json_encode($response);
            exit();
          }
        }
      } else {
        $response = array(
          'status' => 'error',
          'msg' => 'Gagal Menambah Gambar'
        );
        echo json_encode($response);
        exit();
      }
    }
    if ($_POST["type"] == "delete") {
      $crud->execute($_POST["query"]);
      $path = "../images/landing/" . $_POST["imgPath"];
      unlink($path);
      $response = array(
        'status' => 'success',
        'msg' => 'Data berhasil dihapus'
      );
      echo json_encode($response);
      exit();
    }
    if ($_POST["type"] == "update") {
      $crud->execute($_POST["query"]);
      $response = array(
        'status' => 'success',
        'msg' => 'Data berhasil dirubah'
      );
      echo json_encode($response);
      exit();
    }
  }
}

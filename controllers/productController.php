<?php

include "../config/koneksi.php";

$crud = new koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["type"])) {
    if ($_POST["type"] == "insert") {

      $imgproduk_name = $_FILES['image_produk']['name'];
      $imgproduk_size = $_FILES['image_produk']['size'];
      $tmpproduk_name = $_FILES['image_produk']['tmp_name'];
      $errorproduk    = $_FILES['image_produk']['error'];
      $allowed_exs = array("jpg", "jpeg", "png");

      if ($errorproduk === 0) {
        if ($imgproduk_size > 2000000) {
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
              'msg' => 'Ekstensi Foto Pegawai Tidak Sesuai'
            );
            echo json_encode($response);
            exit();
          } else {
            $img_upload_path_produk = "../../images/produk/" . $_POST['img_file_produk'];
            move_uploaded_file($tmpproduk_name, $img_upload_path_produk);
            $crud->execute($_POST["query"]);
            $response = array(
              'status' => 'success',
              'msg' => 'Berhasil Menambahkan Data'
            );
            echo json_encode($response);
            exit();
          }
        }
      } else {
        $response = array(
          'status' => 'error',
          'msg' => 'Gagal Menambahkan Data'
        );
        echo json_encode($response);
        exit();
      }
    }

    if ($_POST["type"] == "delete") {
      $crud->execute($_POST["query"]);
      $path = "../../images/produk/" . $_POST["imgPath"];
      unlink($path);
      $response = array(
        'status' => 'success',
        'msg' => 'Data berhasil dihapus'
      );
      echo json_encode($response);
      exit();
    }

    if ($_POST["type"] == "update") {

      if (isset($_FILES['image_produk'])) {

        $imgproduk_name = $_FILES['image_produk']['name'];
        $imgproduk_size = $_FILES['image_produk']['size'];
        $tmpproduk_name = $_FILES['image_produk']['tmp_name'];
        $errorproduk    = $_FILES['image_produk']['error'];
        $allowed_exs = array("jpg", "jpeg", "png");

        if ($errorproduk === 0) {
          if ($imgproduk_size > 2000000) {
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
                'msg' => 'Ekstensi Foto Pegawai Tidak Sesuai'
              );
              echo json_encode($response);
              exit();
            } else {
              $img_upload_path_produk = "../../images/produk/" . $_POST['img_file_produk_baru'];
              $img_upload_path_produk_lama = "../../images/produk/" . $_POST['img_file_produk_lama'];
              move_uploaded_file($tmpproduk_name, $img_upload_path_produk);
              unlink($img_upload_path_produk_lama);
              $crud->execute($_POST["query"]);
              $response = array(
                'status' => 'success',
                'msg' => 'Berhasil Menambahkan Data'
              );
              echo json_encode($response);
              exit();
            }
          }
        } else {
          $response = array(
            'status' => 'error',
            'msg' => 'Gagal Menambahkan Data'
          );
          echo json_encode($response);
          exit();
        }
      } else {

        $crud->execute($_POST["query"]);
        $response = array(
          'status' => 'success',
          'msg' => 'Data Berhasil Dirubah'
        );
        echo json_encode($response);
        exit();
      }
    }
  }
}

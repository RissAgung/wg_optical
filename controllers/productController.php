<?php
date_default_timezone_set("Asia/Bangkok");
include "../config/koneksi.php";

$crud = new koneksi();

function compressImage($source, $destination, $quality)
{
    // Get image info 
    $imgInfo = getimagesize($source);
    $mime = $imgInfo['mime'];

    // Create a new image from file 
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            $image = imagecreatefromjpeg($source);
    }

    // Save image 
    imagejpeg($image, $destination, $quality);

    // Return compressed image 
    // return $destination;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["type"])) {
    if ($_POST["type"] == "insert") {

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
              'msg' => 'Ekstensi Foto Pegawai Tidak Sesuai'
            );
            echo json_encode($response);
            exit();
          } else {
            $img_upload_path_produk = "../images/produk/" . $_POST['img_file_produk'];
            compressImage($tmpproduk_name, $img_upload_path_produk, 60);
            // move_uploaded_file($tmpproduk_name, $img_upload_path_produk);
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
      $path = "../images/produk/" . $_POST["imgPath"];
      if (file_exists($path)) {
        unlink($path);
      }
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
                'msg' => 'Ekstensi Foto Pegawai Tidak Sesuai'
              );
              echo json_encode($response);
              exit();
            } else {
              $img_upload_path_produk = "../images/produk/" . $_POST['img_file_produk_baru'];
              $img_upload_path_produk_lama = "../images/produk/" . $_POST['img_file_produk_lama'];
              compressImage($tmpproduk_name, $img_upload_path_produk, 60);
              // move_uploaded_file($tmpproduk_name, $img_upload_path_produk);
              if (file_exists($img_upload_path_produk_lama)) {
                unlink($img_upload_path_produk_lama);
              }
              $crud->execute($_POST["query"]);
              $response = array(
                'status' => 'success',
                'msg' => 'Data Berhasil Dirubah'
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

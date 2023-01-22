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
            compressImage($tmpproduk_name, $img_upload_path_produk, 60);
            // move_uploaded_file($tmpproduk_name, $img_upload_path_produk);
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

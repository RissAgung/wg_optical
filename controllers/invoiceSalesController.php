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
      try {
        $crud->execute($_POST["query"]);
        $response = array(
          'status' => 'success',
          'msg' => 'Berhasil Mengirim Konfirmasi Pengiriman'
        );
        echo json_encode($response);
        exit();
      } catch (\Throwable $th) {
        $response = array(
          'status' => 'error',
          'msg' => 'Gagal Mengirim Konfirmasi Pengiriman'
        );
        echo json_encode($response);
        exit();
      }
    }
  }
}

<?php
date_default_timezone_set("Asia/Bangkok");
include'../config/koneksi.php';

$crud =new koneksi();

if ($_SERVER['REQUEST_METHOD']==='POST') {
  if (isset ($_POST['type'])) {
    if ($_POST['type']==='insert') {
      $crud -> execute($_POST['query']);
      $respon = array(
        'status' => 'sukses',
        'msg' => 'berhasil ',

      );
      echo json_encode($respon);
      exit();
    }

    if ($_POST['type']==='update') {
      $crud -> execute($_POST['query']);
      $respon = array(
        'status' => 'sukses',
        'msg' => 'berhasil edit',
      );
      echo json_encode($respon);
      exit();
    }

    if ($_POST['type']==='delete') {
      $crud -> execute($_POST['query']);
      $respon = array(
        'status' => 'sukses',
        'msg' => 'berhasil di hapus',
      );
      echo json_encode($respon);
      exit();
    }
  }
}





?>
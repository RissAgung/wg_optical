<?php

include "../config/koneksi.php";

$crud = new koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["type"])) {
    if ($_POST["type"] == "insert") {    
            $crud->execute($_POST["query"]);
            $response = array(
              'status' => 'success',
              'msg' => 'Berhasil Menambahkan Data'
            );
            echo json_encode($response);
            exit();       
    }

    if ($_POST["type"] == "delete") {
        $crud->execute($_POST["query"]);
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
                'msg' => 'Berhasil Mengubah Data'
              );
              echo json_encode($response);
              exit();
        } else{
            $response = array(
                'status' => 'error',
                'msg' => 'Perubahan Data Gagal'
              );
              echo json_encode($response);
              exit();
        }
    } else{
        $crud->execute($_POST["query"]);
        $response = array(
          'status' => 'success',
          'msg' => 'Data Berhasil Dirubah'
        );
        echo json_encode($response);
        exit();
    }
}





<?php
date_default_timezone_set("Asia/Bangkok");
include "../config/koneksi.php";

$crud = new koneksi();

$data = [];

if($_GET['type'] == 'frame'){
    $res = $crud->showData("Select kode_frame, merk from produk");
    foreach ($res as $value){
        array_push($data, $value);
    }
    echo json_encode($data);
}else if($_GET['type'] == 'tambahan'){
    $res = $crud->showData("Select kode_barang, nama_barang from tambahan");
    foreach ($res as $value1){
        array_push($data, $value1);
    }
    echo json_encode($data);
}else if($_GET['type'] == 'perlengkapan') {
    $res = $crud->showData("Select kode_perlengkapan, nama_perlengkapan from perlengkapan");
    foreach ($res as $value){
        array_push($data, $value);
    }
    echo json_encode($data);
}
?>
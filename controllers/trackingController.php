<?php
date_default_timezone_set("Asia/Bangkok");
include '../config/koneksi.php';
$crud = new koneksi();

if(isset($_POST['kode_pesanan'])){

    $res = $crud->showData("SELECT customer.nama, transaksi.kode_pesanan, transaksi.status_pengiriman FROM transaksi JOIN customer ON transaksi.id_customer = customer.id_customer WHERE status_confirm = 2 AND status_pengiriman IS NOT NULL AND transaksi.kode_pesanan = '".$_POST['kode_pesanan']."'");
    foreach ($res as $value) {
        $json[] = array(
            'nama'=> $value['nama'],
            'kode_pesanan'=> $value['kode_pesanan'],
            'status_pengiriman'=> $value['status_pengiriman'],
        );
    }

    echo json_encode($json);


}

?>
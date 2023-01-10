<?php
date_default_timezone_set("Asia/Bangkok");
include "../config/koneksi.php";

$crud = new koneksi();

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["type"])) {
        if ($_POST['type'] == 'hapus_selected') {
            // array_push($data, json_decode($_POST['kode_tr']));
            $data = $_POST['kode_tr'];

            foreach ($data as $value) {
                $crud->execute("DELETE FROM keranjang WHERE kode_pesanan = '" . $value['kode'] . "'");
            }
        } else {
            $crud->execute("DELETE FROM keranjang WHERE kode_pesanan = '" . $_POST['kode_tr'] . "'");
        }

        $response = array(
            'status' => 'berhasil',
            'msg' => 'Hapus Data Berhasil'
        );
        echo json_encode($response);
        exit();
    }
}

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
                $ha = $crud->showData("SELECT Id_Bawa FROM keranjang_frame WHERE kode_pesanan = '" . $value['kode'] . "'");
                foreach ($ha as $values) {
                    # code...
                    $crud->execute("UPDATE detail_bawa SET status_frame = 'ready' WHERE Id_Bawa = '" . $values['Id_Bawa'] . "'");
                }

                $crud->execute("DELETE FROM keranjang WHERE kode_pesanan = '" . $value['kode'] . "'");
            }
        } else {
            $ha = $crud->showData("SELECT Id_Bawa FROM keranjang_frame WHERE kode_pesanan = '" . $_POST['kode_tr'] . "'");
            foreach ($ha as $value) {
                # code...
                $crud->execute("UPDATE detail_bawa SET status_frame = 'ready' WHERE Id_Bawa = '" . $value['Id_Bawa'] . "'");
            }

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

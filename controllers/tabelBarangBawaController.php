<?php
include '../config/koneksi.php';

$con = new koneksi();
if (isset($_GET['id'])) {


    $data = $con->showData("SELECT * FROM detail_bawa JOIN produk ON detail_bawa.Kode_Frame = produk.Kode_frame WHERE detail_bawa.id_pegawai = '" . $_GET['id'] . "' AND status_frame = 'ready'");
    $arr = [];
    foreach ($data as $value) {
        array_push($arr, array(
            'id_bawa' => $value['Id_Bawa'],
            'kode_frame' => $value['Kode_Frame'],
            'merk' => $value['merk'],
        ));
    }
    echo json_encode($arr);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $con->execute("DELETE FROM detail_bawa WHERE Id_Bawa = '" . $_POST['id'] . "'");
        $response = array(
            'status' => 'success',
            'msg' => 'Berhasil Hapus Data'
        );
        echo json_encode($response);
        exit();
    }
}

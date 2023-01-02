<?php
include '../config/koneksi.php';
$crud = new koneksi();

$api_key = 'aoi12j1h7dwgopticalw1dggwuawdki';

if (isset($_POST['apikey'])) {
    if ($_POST['apikey'] == $api_key) {
        $json = [];
        $idpeg = $_POST['id_pegawai'];

        if (isset($_POST['type'])) {

            if ($_POST['type'] == 'getFrame') {
                $result = $crud->showData("SELECT * FROM detail_bawa JOIN produk ON detail_bawa.Kode_Frame = produk.kode_frame LEFT JOIN keranjang_frame ON detail_bawa.Id_Bawa = keranjang_frame.id_bawa WHERE status_frame = 'ready' AND kode_pesanan IS NULL AND detail_bawa.Id_pegawai = '".$idpeg."'");
                foreach ($result as $value) {
                    $json[] = array(
                        'status' => 'sukses',
                        'data' => $value,
                    );
                }
                echo json_encode($json, JSON_PRETTY_PRINT);
            } else if ($_POST['type'] == 'insert') {
                $idTR = strtoupper(str_replace(".", "", uniqid('TR', true)));
                $harga = $_POST['harga'];
                $kodef = $_POST['kode_frame'];
                $crud->execute("INSERT INTO keranjang VALUES ('" . $idTR . "', NOW(), '" . $idpeg . "','" . $harga . "')");
                $crud->execute("INSERT INTO keranjang_frame VALUES ('" . $idTR . "','" . $kodef . "','" . $harga . "')");

                $json = array(
                    'status' => 'Berhasil',
                    'msg' => 'Berhasil Menambahkan ke Keranjang',
                );

                echo json_encode($json, JSON_PRETTY_PRINT);
            }
        }
    }
}

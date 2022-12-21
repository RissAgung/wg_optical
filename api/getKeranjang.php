<?php
include '../config/koneksi.php';

$crud = new koneksi();
$api_key = 'aoi12j1h7dwgopticalw1dggwuawdki';

if (isset($_POST['apikey'])) {
    if ($_POST['apikey'] == $api_key) {

        $data = $crud->showData("SELECT keranjang.kode_pesanan, keranjang.total, keranjang_lensa.kode_varian_lensa_keranjang as lensa, keranjang_frame.kode_pesanan as frame, keranjang.id_pegawai FROM keranjang LEFT JOIN keranjang_frame ON keranjang.kode_pesanan = keranjang_frame.kode_pesanan LEFT JOIN keranjang_lensa ON keranjang.kode_pesanan = keranjang_lensa.kode_pesanan GROUP BY keranjang.kode_pesanan HAVING keranjang.id_pegawai = '141220223'");

        foreach ($data as $value) {
            if($value['lensa'] != null && $value['frame'] != null){
                // fullset
                $json[] = array(
                    'jenis' => 'Full Set',
                    'data' => $value,
                );
            } else {
                if($value['lensa'] != null){
                    // lensa
                    $json[] = array(
                        'jenis' => 'Lensa',
                        'data' => $value,
                    );
                } else {
                    // frame
                    $json[] = array(
                        'jenis' => 'Frame',
                        'data' => $value,
                    );
                }
            }
        }

        echo json_encode($json, JSON_PRETTY_PRINT);
    }
}

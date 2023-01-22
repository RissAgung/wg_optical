<?php
include '../config/koneksi.php';
$crud = new koneksi();

$api_key = 'aoi12j1h7dwgopticalw1dggwuawdki';

if (isset($_POST['apikey'])) {
    if ($_POST['apikey'] == $api_key) {

        if (isset($_POST['type'])) {

            if ($_POST['type'] == 'getLensa') {
                $result = $crud->showData("SELECT * FROM `lensa`");
                foreach ($result as $value) {
                    $json[] = array(
                        'status' => 'sukses',
                        'data' => $value,
                    );
                }
                echo json_encode($json, JSON_PRETTY_PRINT);
            } else if ($_POST['type'] == 'insert') {
                $idpeg = $_POST['id_pegawai'];
                $harga = $_POST['harga'];
                $idTR = strtoupper(str_replace(".", "", uniqid('TR', true)));
                $kode_varian_lensa = strtoupper(str_replace(".", "", uniqid('KVLK', true)));
                $jenislensa = $_POST['jenislensa'];

                $knsph = $_POST['knsph'];
                $kncyl = $_POST['kncyl'];
                $knaxis = $_POST['knaxis'];
                $krsph = $_POST['krsph'];
                $krcyl = $_POST['krcyl'];
                $kraxis = $_POST['kraxis'];
                $knadd = $_POST['knadd'];
                $knpd = $_POST['knpd'];
                $knseg = $_POST['knseg'];
                $kradd = $_POST['kradd'];
                $krpd = $_POST['krpd'];
                $krseg = $_POST['krseg'];

                $crud->execute("INSERT INTO keranjang (`kode_pesanan`, `tanggal`, `id_pegawai`, `total`) VALUES ('" . $idTR . "', NOW(),'" . $idpeg . "','" . $harga . "')");

                $crud->execute("INSERT INTO `keranjang_lensa`(`kode_varian_lensa_keranjang`, `kode_pesanan`, `id_jenis_lensa`, `harga`) VALUES ('" . $kode_varian_lensa . "','" . $idTR . "','" . $jenislensa . "','" . $harga . "')");

                $crud->execute("INSERT INTO `keranjang_resep`(`kode_varian_lensa_keranjang`, `KN_SPH`, `KN_CYL`, `KN_AXIS`, `KR_SPH`, `KR_CYL`, `KR_AXIS`, `KN_ADD+`, `KN_PD`, `KN_SEG`, `KR_ADD+`, `KR_PD`, `KR_SEG`) VALUES ('" . $kode_varian_lensa . "','" . $knsph . "','" . $kncyl . "','" . $knaxis . "','" . $krsph . "','" . $krcyl . "','" . $kraxis . "','" . $knadd . "','" . $knpd . "','" . $knseg . "','" . $kradd . "','" . $krpd . "','" . $krseg . "')");

                foreach (json_decode($_POST['selectedVarian']) as $value) {
                    $crud->execute("INSERT INTO detail_varian_lensa_keranjang VALUES ('" . $kode_varian_lensa . "', '" . $value . "')");
                }

                $json = array(
                    'status' => 'Berhasil',
                    'msg' => 'Berhasil Menambahkan ke Keranjang',
                );

                echo json_encode($json, JSON_PRETTY_PRINT);
            }
        }
    }
}

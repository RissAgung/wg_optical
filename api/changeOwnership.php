<?php

include '../config/koneksi.php';

$kon = new Koneksi();
$api_key = 'aoi12j1h7dwgopticalw1dggwuawdki';

if (isset($_POST['apikey'])) {
    if ($_POST['apikey'] == $api_key) {
        $nama_req = $_POST["nama_req"];
        $kode_req = $_POST['kode_bawa'];
        $value_req = $_POST['value_req'];
        $nama_bawa = $_POST['nama_bawa'];

        $kon->execute("UPDATE `detail_bawa` SET `req`='" . $value_req . "',`pegawai_req`='" . $nama_req . "' WHERE Id_pegawai = '" . $nama_bawa . "' AND Id_Bawa = '" . $kode_req . "'");
    }
}
<?php

include '../config/koneksi.php';

$kon = new Koneksi();
$api_key = 'aoi12j1h7dwgopticalw1dggwuawdki';

if (isset($_POST['apikey'])) {
    if ($_POST['apikey'] == $api_key) {
        $nama_req = $_POST["nama_req"];
        $nama_bawa = $_POST['nama_bawa'];
        $id_bawa = $_POST['id_bawa'];

        $kon->execute("UPDATE `detail_bawa` SET `Id_pegawai`='" . $nama_bawa . "',`req`='0',`pegawai_req`='' WHERE Id_Bawa = '" . $id_bawa . "'");
    }
}
<?php

include '../config/koneksi.php';

$kon = new Koneksi();
$api_key = 'aoi12j1h7dwgopticalw1dggwuawdki';

if (isset($_POST['apikey'])) {
    if ($_POST['apikey'] == $api_key) {
        $ID_Cust = $_POST["idCust"];
        $res = $kon->showData("SELECT transaksi.kode_pesanan, transaksi.status_confirm, transaksi.tanggal, transaksi.tanggal_jatuh_tempo, transaksi.total_bayar, transaksi.total_harga, customer.nama, customer.alamat_jalan FROM customer INNER JOIN transaksi ON transaksi.id_customer = customer.id_customer WHERE transaksi.status_pengiriman='terima' AND transaksi.id_pegawai='" . $ID_Cust . "'");
        $data = [];
        foreach ($res as $value) {
            array_push($data, $value);
        }

        echo json_encode($data, JSON_PRETTY_PRINT);
        exit();
    }
}

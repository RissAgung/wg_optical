<?php

include '../config/koneksi.php';

$kon = new Koneksi();
$api_key = 'aoi12j1h7dwgopticalw1dggwuawdki';

if (isset($_POST['apikey'])) {
    if ($_POST['apikey'] == $api_key) {
        $ID_Cust = $_POST["idCust"];
        $value = $kon->execute("SELECT Status_transaksi,COUNT(Status_transaksi) as jumlah_selesai FROM `transaksi` WHERE Status_transaksi='selesai' AND id_pegawai='" . $ID_Cust . "'");
        $value1 = $kon->execute("SELECT Status_transaksi,COUNT(Status_transaksi) as jumlah_kirim FROM `transaksi` WHERE Status_transaksi='kirim' AND id_pegawai='" . $ID_Cust . "'");
        $num = mysqli_num_rows($value);

        while ($row = mysqli_fetch_array($value)) {
            $js = $row['jumlah_selesai'];
        }

        while ($row = mysqli_fetch_array($value1)) {
            $jk = $row['jumlah_kirim'];
        }

        if ($num != 0) {
            $response = array(
                'data' => array(
                    'jumlah_selesai' => $js,
                    'jumlah_kirim' => $jk,
                ),
            );
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit();
        }

    }
}
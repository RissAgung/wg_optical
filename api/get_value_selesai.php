<?php
include '../config/koneksi.php';

$kon = new Koneksi();
$api_key = 'aoi12j1h7dwgopticalw1dggwuawdki';

if (isset($_POST['apikey'])) {
    if ($_POST['apikey'] == $api_key) {
        $ID_Cust = $_POST["idCust"];
        $value = $kon->execute("SELECT status_pengiriman,COUNT(status_pengiriman) as jumlah FROM `transaksi` WHERE status_pengiriman='terima' AND id_pegawai='" . $ID_Cust . "'");
        $num = mysqli_num_rows($value);

        while ($row = mysqli_fetch_array($value)) {
            $sTrans = $row['status_pengiriman'];
            $Sum = $row['jumlah'];
        }

        if ($num != 0) {
            $response = array(
                'data' => array(
                    'status' => $sTrans,
                    'jumlah' => $Sum,
                ),
            );
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit();
        }

    }
}
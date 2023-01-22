<?php

include '../config/koneksi.php';

$kon = new Koneksi();
$api_key = 'aoi12j1h7dwgopticalw1dggwuawdki';

if (isset($_POST['apikey'])) {
    if ($_POST['apikey'] == $api_key) {
        $id_pegawai = $_POST["id_pegawai"];
        $value = $kon->execute("SELECT pegawai.nama, pegawai.id_pegawai, detail_bawa.Id_Bawa FROM pegawai JOIN detail_bawa ON pegawai.id_pegawai = detail_bawa.pegawai_req WHERE detail_bawa.Id_pegawai = '" . $id_pegawai . "'");
        $num = mysqli_num_rows($value);

        while ($row = mysqli_fetch_array($value)) {
            $nama = $row['nama'];
            $id_pegawai = $row['id_pegawai'];
            $id_bawa = $row['Id_Bawa'];
            // $Kode_Frame = $row['Kode_Frame'];
            // $status_frame = $row['status_frame'];
            $response[] = array(
                'data' => array(
                    'nama' => $nama,
                    'id_pegawai' => $id_pegawai,
                    'id_bawa' => $id_bawa,
                    // 'kode_frame' => $Kode_Frame,
                    // 'status_frame' => $status_frame
                ),
            );
        }

        echo json_encode($response, JSON_PRETTY_PRINT);
        exit();

    }
}
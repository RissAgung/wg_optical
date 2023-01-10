<?php
include "../config/koneksi.php";
session_start();
$crud = new koneksi();
date_default_timezone_set("Asia/Bangkok");
$api_key = 'aoi12j1h7dwgopticalw1dggwuawdki';

$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['apikey'])) {
        if ($_POST['apikey'] == $api_key) {
            $idPeg = $_POST['id_pegawai'];
            if ($_POST["type"] == "penghasilan") {
                $result = [];

                $res = $crud->showData("SELECT (CASE WHEN (SUM(frame_transaksi.harga) + SUM(lensa_transaksi.harga)) IS NULL THEN 0 ELSE (SUM(frame_transaksi.harga) + SUM(lensa_transaksi.harga)) END) as jumlah, COUNT(*) as count FROM transaksi LEFT JOIN detail_transaksi ON transaksi.kode_pesanan = detail_transaksi.kode_pesanan LEFT JOIN frame_transaksi ON detail_transaksi.kode_detail_pesanan = frame_transaksi.kode_detail_pesanan LEFT JOIN lensa_transaksi ON detail_transaksi.kode_detail_pesanan = lensa_transaksi.kode_detail_pesanan WHERE transaksi.status_pengiriman = 'terima' AND transaksi.total_bayar >= transaksi.total_harga AND transaksi.id_pegawai = '" . $idPeg . "' AND MONTH(transaksi.tanggal) = MONTH(NOW()) AND frame_transaksi.kode_detail_pesanan IS NOT NULL AND lensa_transaksi.kode_detail_pesanan IS NOT NULL");

                foreach ($res as $value) {
                    array_push($data, $value);
                }

                $res1 = $crud->showData("SELECT (CASE WHEN SUM(frame_transaksi.harga) IS NULL THEN 0 ELSE SUM(frame_transaksi.harga) END) as jumlah, COUNT(*) AS count FROM transaksi LEFT JOIN detail_transaksi ON transaksi.kode_pesanan = detail_transaksi.kode_pesanan LEFT JOIN frame_transaksi ON detail_transaksi.kode_detail_pesanan = frame_transaksi.kode_detail_pesanan LEFT JOIN lensa_transaksi ON detail_transaksi.kode_detail_pesanan = lensa_transaksi.kode_detail_pesanan WHERE transaksi.status_pengiriman = 'terima' AND transaksi.total_bayar >= transaksi.total_harga AND transaksi.id_pegawai = '" . $idPeg . "' AND MONTH(transaksi.tanggal) = MONTH(NOW()) AND frame_transaksi.kode_detail_pesanan IS NOT NULL AND lensa_transaksi.kode_detail_pesanan IS NULL");

                foreach ($res1 as $value) {
                    array_push($data, $value);
                }

                $res2 = $crud->showData("SELECT (CASE WHEN SUM(lensa_transaksi.harga) IS NULL THEN 0 ELSE SUM(lensa_transaksi.harga) END) as jumlah, COUNT(*) AS count FROM transaksi LEFT JOIN detail_transaksi ON transaksi.kode_pesanan = detail_transaksi.kode_pesanan LEFT JOIN frame_transaksi ON detail_transaksi.kode_detail_pesanan = frame_transaksi.kode_detail_pesanan LEFT JOIN lensa_transaksi ON detail_transaksi.kode_detail_pesanan = lensa_transaksi.kode_detail_pesanan WHERE transaksi.status_pengiriman = 'terima' AND transaksi.total_bayar >= transaksi.total_harga AND transaksi.id_pegawai = '" . $idPeg . "' AND MONTH(transaksi.tanggal) = MONTH(NOW()) AND frame_transaksi.kode_detail_pesanan IS NULL AND lensa_transaksi.kode_detail_pesanan IS NOT NULL");

                foreach ($res2 as $value) {
                    array_push($data, $value);
                }

                $setoranLensa = 0;

                if ($data[2]['jumlah'] > 500000) {
                    $setoranLensa = $data[2]['jumlah'];
                }

                $kalkulasi = 0;
                if (($data[0]['count'] + $data[1]['count']) < 10) {
                    $kalkulasi = (($data[0]['jumlah'] + $data[1]['jumlah']) + $setoranLensa) * 0.1;
                } else if (($data[0]['count'] + $data[1]['count']) >= 10 && ($data[0]['count'] + $data[1]['count']) < 20) {
                    $kalkulasi = ((($data[0]['jumlah'] + $data[1]['jumlah']) + $setoranLensa) * 0.15) + 500000;
                } else if (($data[0]['count'] + $data[1]['count']) >= 20) {
                    $kalkulasi = ((($data[0]['jumlah'] + $data[1]['jumlah']) + $setoranLensa) * 0.2) + 500000;
                }

                array_push($result, array(
                    "setoran" => $kalkulasi,
                    "jumlah_frame" => $data[0]['count'] + $data[1]['count'],
                ));


                echo json_encode($result, JSON_PRETTY_PRINT);
            }
        }
    }
}

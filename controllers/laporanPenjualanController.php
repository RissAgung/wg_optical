<?php
include '../config/koneksi.php';

$crud = new Koneksi();

$data = [];

if (isset($_GET['getDataPieChart'])) {
    if ($_GET['getDataPieChart'] == 'frame') {
        $res = $crud->showData("SELECT COUNT(*) AS jumlah, produk.merk FROM transaksi JOIN detail_transaksi ON transaksi.kode_pesanan = detail_transaksi.kode_pesanan LEFT JOIN frame_transaksi ON detail_transaksi.kode_detail_pesanan = frame_transaksi.kode_detail_pesanan JOIN produk ON frame_transaksi.kode_frame = produk.kode_frame GROUP BY produk.kode_frame ORDER BY jumlah DESC LIMIT 7");

        foreach ($res as $value) {

            array_push(
                $data,
                array(
                    'jumlah' => filter_var($value['jumlah'], FILTER_VALIDATE_INT),
                    'merk' => $value['merk'],
                )
            );
        }

        echo json_encode($data);
        exit();
    } else if ($_GET['getDataPieChart'] == 'lensa') {
        $res = $crud->showData("SELECT COUNT(*) AS jumlah, lensa.nama_lensa FROM transaksi JOIN detail_transaksi ON transaksi.kode_pesanan = detail_transaksi.kode_pesanan LEFT JOIN lensa_transaksi ON detail_transaksi.kode_detail_pesanan = lensa_transaksi.kode_detail_pesanan JOIN detail_varian_lensa_transaksi ON lensa_transaksi.kode_varian_lensa_transaksi = detail_varian_lensa_transaksi.kode_varian_lensa_transaksi JOIN lensa ON detail_varian_lensa_transaksi.kode_lensa = lensa.kode_lensa GROUP BY lensa.nama_lensa ORDER BY jumlah DESC LIMIT 7");

        foreach ($res as $value) {
            array_push(
                $data,
                array(
                    'jumlah' => filter_var($value['jumlah'], FILTER_VALIDATE_INT),
                    'nama' => $value['nama_lensa'],
                )
            );
        }

        echo json_encode($data);
        exit();
    }
}

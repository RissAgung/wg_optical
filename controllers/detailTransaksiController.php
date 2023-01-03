<?php
date_default_timezone_set("Asia/Bangkok");
include '../config/koneksi.php';

$con = new koneksi();
if (isset($_GET['id_transaksi'])) {


    $data1 = $con->showData("SELECT produk.merk, jenis_lensa.nama_jenis_lensa, keranjang_resep.KN_SPH, keranjang_resep.KN_CYL, keranjang_resep.KN_AXIS, keranjang_resep.KR_SPH, keranjang_resep.KR_CYL, keranjang_resep.KR_AXIS, keranjang_resep.`KN_ADD+`, keranjang_resep.KN_PD, keranjang_resep.KN_SEG, keranjang_resep.`KR_ADD+`, keranjang_resep.KR_PD, keranjang_resep.KR_SEG, keranjang_lensa.harga AS harga_lensa, keranjang_frame.harga AS harga_frame, keranjang.total FROM produk RIGHT JOIN detail_bawa ON produk.kode_frame = detail_bawa.Kode_Frame RIGHT JOIN keranjang_frame ON detail_bawa.Id_Bawa = keranjang_frame.id_bawa RIGHT JOIN keranjang ON keranjang_frame.kode_pesanan = keranjang.kode_pesanan LEFT JOIN keranjang_lensa ON keranjang_lensa.kode_pesanan = keranjang.kode_pesanan LEFT JOIN jenis_lensa ON keranjang_lensa.id_jenis_lensa = jenis_lensa.id_jenis_lensa LEFT JOIN keranjang_resep ON keranjang_lensa.kode_varian_lensa_keranjang = keranjang_resep.kode_varian_lensa_keranjang WHERE keranjang.kode_pesanan = '" . $_GET['id_transaksi'] . "'");

    $data2 = $con->showData("SELECT lensa.nama_lensa FROM lensa RIGHT JOIN detail_varian_lensa_keranjang ON lensa.kode_lensa = detail_varian_lensa_keranjang.kode_lensa RIGHT JOIN keranjang_lensa ON detail_varian_lensa_keranjang.kode_varian_lensa_keranjang = keranjang_lensa.kode_varian_lensa_keranjang RIGHT JOIN keranjang ON keranjang_lensa.kode_pesanan = keranjang.kode_pesanan WHERE keranjang.kode_pesanan = '" . $_GET['id_transaksi'] . "'");

    $arr = [];
    $tmpArr = [];

    foreach ($data2 as $value) {
        if ($value['nama_lensa'] == null) {
        } else {
            array_push(
                $tmpArr,
                $value['nama_lensa'],
            );
        }
    }

    foreach ($data1 as $value) {


        array_push($arr, array(
            'merk' => $value['merk'],
            'nama_jenis_lensa' => $value['nama_jenis_lensa'],
            'kn_sph' => $value['KN_SPH'],
            'kn_cyl' => $value['KN_CYL'],
            'kn_axis' => $value['KN_AXIS'],
            'kr_sph' => $value['KR_SPH'],
            'kr_cyl' => $value['KR_CYL'],
            'kr_axis' => $value['KR_AXIS'],
            'kn_add' => $value['KN_ADD+'],
            'kn_pd' => $value['KN_PD'],
            'kn_seg' => $value['KN_SEG'],
            'kr_add' => $value['KR_ADD+'],
            'kr_pd' => $value['KR_PD'],
            'kr_seg' => $value['KR_SEG'],
            'harga_lensa' => $value['harga_lensa'],
            'harga_frame' => $value['harga_frame'],
            'total' => $value['total'],
            'nama_lensa' => $tmpArr
        ));
    }

    echo json_encode($arr);
    exit();
}

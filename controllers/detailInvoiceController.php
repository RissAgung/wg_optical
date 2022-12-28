<?php

include "../config/koneksi.php";

$crud = new koneksi();
if (isset($_GET["detail"])) {

  $arr1 = [];
  $arr2 = [];
  $arr3 = [];
  $arr4 = [];

  $data1 = $crud->showData("SELECT transaksi.status_pengiriman, transaksi.kode_pesanan, transaksi.tanggal, pegawai.nama AS nama_sales, customer.nama AS nama_cus, customer.kecamatan, customer.desa, customer.alamat_jalan, customer.pekerjaan, customer.instansi FROM pegawai JOIN transaksi ON pegawai.id_pegawai = transaksi.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer WHERE transaksi.kode_pesanan = '" . $_GET['detail'] . "'");

  $data2 = $crud->showData("SELECT kode_detail_pesanan FROM detail_transaksi WHERE kode_pesanan = '" . $_GET['detail'] . "'");

  $data3 = $crud->showData("SELECT detail_transaksi.kode_detail_pesanan, frame_transaksi.id_detail_bawa, lensa.nama_lensa, frame_transaksi.harga AS harga_frame, lensa_transaksi.harga AS harga_lensa, resep.* FROM frame_transaksi RIGHT JOIN detail_transaksi ON frame_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan JOIN transaksi ON detail_transaksi.kode_pesanan = transaksi.kode_pesanan LEFT JOIN lensa_transaksi ON detail_transaksi.kode_detail_pesanan = lensa_transaksi.kode_detail_pesanan LEFT JOIN resep ON resep.kode_varian_lensa_transaksi = lensa_transaksi.kode_varian_lensa_transaksi LEFT JOIN detail_varian_lensa_transaksi ON lensa_transaksi.kode_varian_lensa_transaksi = detail_varian_lensa_transaksi.kode_varian_lensa_transaksi LEFT JOIN lensa ON detail_varian_lensa_transaksi.kode_lensa = lensa.kode_lensa WHERE transaksi.kode_pesanan = '" . $_GET['detail'] . "'");

  $data4 = $crud->showData("SELECT transaksi.total_harga, transaksi.total_bayar, transaksi.kembalian, transaksi.tanggal_jatuh_tempo, cicilan.kode_cicilan, cicilan.depan_pembayaran FROM transaksi LEFT JOIN cicilan ON transaksi.kode_pesanan = cicilan.kode_pesanan WHERE transaksi.kode_pesanan = '" . $_GET['detail'] . "'");

  $data5 = $crud->showData("SELECT detail_cicilan.kode_cicilan, detail_cicilan.total_bayar FROM detail_cicilan RIGHT JOIN cicilan ON detail_cicilan.kode_cicilan = cicilan.kode_cicilan RIGHT JOIN transaksi ON cicilan.kode_pesanan = transaksi.kode_pesanan WHERE transaksi.kode_pesanan = '" . $_GET['detail'] . "'");

  foreach ($data2 as $index) {
    array_push($arr2, array(
      "kode" => $index["kode_detail_pesanan"],
      "lensa" => [],
    ));
  }

  for ($i = 0; $i < count($arr2); $i++) {
    foreach ($data3 as $index) {
      if ($index["kode_detail_pesanan"] === $arr2[$i]["kode"]) {
        $arr2[$i]["frame"] = $index["id_detail_bawa"];
        $arr2[$i]["harga_frame"] = $index["harga_frame"];
        $arr2[$i]["harga_lensa"] = $index["harga_lensa"];

        // resep
        $arr2[$i]["kn_sph"] = $index["KN_SPH"];
        $arr2[$i]["kn_cyl"] = $index["KN_CYL"];
        $arr2[$i]["kn_axis"] = $index["KN_AXIS"];
        $arr2[$i]["kr_sph"] = $index["KR_SPH"];
        $arr2[$i]["kr_cyl"] = $index["KR_CYL"];
        $arr2[$i]["kr_axis"] = $index["KR_AXIS"];
        $arr2[$i]["kn_add"] = $index["KN_ADD+"];
        $arr2[$i]["kn_pd"] = $index["KN_PD"];
        $arr2[$i]["kn_seg"] = $index["KN_SEG"];
        $arr2[$i]["kr_add"] = $index["KR_ADD+"];
        $arr2[$i]["kr_pd"] = $index["KR_PD"];
        $arr2[$i]["kr_seg"] = $index["KR_SEG"];

        array_push($arr2[$i]["lensa"], array(
          $index["nama_lensa"]
        ));
      }
    }
  }

  foreach ($data4 as $index) {
    array_push($arr3, array(
      "total_harga" => $index["total_harga"],
      "total_bayar" => $index["total_bayar"],
      "kembalian" => $index["kembalian"],
      "tanggal_jatuh_tempo" => $index["tanggal_jatuh_tempo"],
      "kode_cicilan" => $index["kode_cicilan"],
      "depan_pembayaran" => $index["depan_pembayaran"],
    ));
  }

  foreach ($data5 as $index){
    array_push($arr4, array(
      "total_bayar" => $index["total_bayar"],
    ));
  }

  foreach ($data1 as $index) {
    array_push($arr1, array(
      "kode_pesanan" => $index["kode_pesanan"],
      "status_pengiriman" => $index["status_pengiriman"],
      "tanggal" => $index["tanggal"],
      "nama_sales" => $index["nama_sales"],
      "nama_cus" => $index["nama_cus"],
      "kecamatan" => $index["kecamatan"],
      "desa" => $index["desa"],
      "alamat_jalan" => $index["alamat_jalan"],
      "pekerjaan" => $index["pekerjaan"],
      "instansi" => $index["instansi"],
      "data_pesanan" => $arr2,
      "data_pembayaran" => $arr3,
      "data_cicilan" => $arr4,
    ));
  }

  echo json_encode($arr1);
  exit();
}

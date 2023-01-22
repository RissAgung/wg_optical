<?php
date_default_timezone_set("Asia/Bangkok");
include "../config/koneksi.php";

$crud = new koneksi();

if (isset($_POST['type'])) {
  if ($_POST['type'] == 'salary') {
    $dateNow = date("Y-m-d");
    $dateFilter =  substr($dateNow, strlen($dateNow) - 2, strlen($dateNow) - 1);
    // $tanggal_awal = date("Y-m-01");
    // $tanggal_akhir = date("Y-m-t");
    $dateFilterFinal = substr($dateFilter, 1);

    $dataSales = $crud->showData("SELECT id_pegawai FROM pegawai WHERE id_level = '3'");

    if ($dateFilterFinal == 1) {

      for ($i = 0; $i < count($dataSales); $i++) {

        $id_pegawai = $dataSales[$i]["id_pegawai"];

        $cekExecuteGaji = $crud->showData("SELECT id_gaji FROM gaji WHERE id_gaji = '" . getIdGaji($id_pegawai) . "'");

        if (count($cekExecuteGaji) == 0) {
          $result = $crud->showData("SELECT COUNT(transaksi.kode_pesanan) AS jumlah_pesanan ,SUM(transaksi.total_harga) AS total_harga ,pegawai.id_pegawai  FROM transaksi JOIN pegawai ON transaksi.id_pegawai = pegawai.id_pegawai WHERE transaksi.total_bayar >= transaksi.total_harga AND transaksi.status_pengiriman = 'terima' AND pegawai.id_pegawai = '" . $dataSales[$i]['id_pegawai'] . "' AND DATE(transaksi.tanggal) BETWEEN '" . date("Y-n-j", strtotime("first day of previous month")) . "' AND '" . date("Y-n-j", strtotime("last day of previous month")) . "'");

          $jumlah_pesanan = "";
          $total_harga = "";

          foreach ($result as $index) {
            $id_pegawai = $index["id_pegawai"];
            $jumlah_pesanan = $index["jumlah_pesanan"];
            $total_harga = $index["total_harga"];
          }

          if ($jumlah_pesanan <= 9) {
            $tl_harga =  $total_harga * 0.1;

            $crud->execute("INSERT INTO gaji VALUES ('" . getIdGaji($id_pegawai) . "','" . $id_pegawai . "','" . date("y-m-d") . "','" . $tl_harga . "','" . $jumlah_pesanan . "')");
          } elseif ($jumlah_pesanan <= 10) {
            $tl_harga = $total_harga * 0.15 + 500000;

            $crud->execute("INSERT INTO gaji VALUES ('" . getIdGaji($id_pegawai) . "','" . $id_pegawai . "','" . date("y-m-d") . "','" . $tl_harga . "','" . $jumlah_pesanan . "')");
          } elseif ($jumlah_pesanan >= 20) {
            $tl_harga = $total_harga * 0.2 + 500000;

            $crud->execute("INSERT INTO gaji VALUES ('" . getIdGaji($id_pegawai) . "','" . $id_pegawai . "','" . date("y-m-d") . "','" . $tl_harga . "','" . $jumlah_pesanan . "')");
          }
        }
      }

      echo "berhasil";
      exit();
    }
  }

  if ($_POST['type'] == 'show_data'){
    $data = $crud->execute("SELECT gaji.id_gaji , pegawai.nama , gaji.bulan, gaji.total_penjualan, gaji.gaji FROM gaji JOIN pegawai ON gaji.id_pegawai = pegawai.id_pegawai WHERE pegawai.nama ='".$_POST['nama']."'");

    $dataFinal = [];

    foreach($data as $index){
      array_push($dataFinal, array(
        "id_gaji" => $index["id_gaji"],
        "nama" => $index["nama"],
        "bulan" => $index["bulan"],
        "total_penjualan" => $index["total_penjualan"],
        "gaji" => $index["gaji"],
      ));
    }

    echo json_encode($dataFinal);
    exit();
  }
}
function getIdGaji($id_pegawai)
{
  return "G" . $id_pegawai . date("Ymd");
}

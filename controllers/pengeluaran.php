<?php

include "../config/koneksi.php";

$crud = new koneksi();



if(isset($_GET['search'])){
  $json = [];
  if($_GET['type'] == 'getOperasional'){
    $res = $crud->showData("SELECT * FROM tr_pengeluaran JOIN pegawai ON tr_pengeluaran.id_pegawai = pegawai.id_pegawai WHERE kode_tr_pengeluaran LIKE '%".$_GET['search']."%'");
    foreach ($res as $value) {
      $json[] = array(
        'kode_tr_pengeluaran'=> $value['kode_tr_pengeluaran'],
        'tanggal'=> $value['tanggal'],
        'nama'=> $value['nama'],
        'keterangan'=> $value['keterangan'],
        'total_harga'=> $value['total_harga'],
      );
    }
  } else {
    $res = $crud->showData("SELECT tr_pengeluaran.kode_tr_pengeluaran, tr_pengeluaran.tanggal, tr_pengeluaran.id_pegawai, pegawai.nama, tr_pengeluaran.id_Supplier, tr_pengeluaran.jenis, (CASE WHEN tr_pengeluaran.kode_frame IS NOT NULL THEN produk.merk WHEN tr_pengeluaran.kode_barang IS NOT NULL THEN tambahan.nama_barang WHEN tr_pengeluaran.kode_perkap IS NOT NULL THEN perlengkapan.nama_perlengkapan END) as barang, tr_pengeluaran.QTY, supplier.Nama_Supplier FROM tr_pengeluaran LEFT JOIN perlengkapan ON tr_pengeluaran.kode_perkap = perlengkapan.kode_perlengkapan LEFT JOIN tambahan ON tambahan.kode_barang = tr_pengeluaran.kode_barang LEFT JOIN produk ON produk.kode_frame = tr_pengeluaran.kode_frame JOIN pegawai ON tr_pengeluaran.id_pegawai = pegawai.id_pegawai JOIN supplier on tr_pengeluaran.id_Supplier = supplier.id_Supplier WHERE tr_pengeluaran.kategori = 'restock' AND tr_pengeluaran.kode_tr_pengeluaran LIKE '%".$_GET['search']."%'");
    foreach ($res as $value) {
      $json[] = array(
        'kode'=> $value['kode_tr_pengeluaran'],
        'tanggal'=> $value['tanggal'],
        'nama'=> $value['nama'],
        'supplier'=> $value['Nama_Supplier'],
        'jenis'=> $value['jenis'],
        'barang'=> $value['barang'],
        'jumlah'=> $value['QTY'],
      );
    }
  }

  if(count($json) != 0){
    echo json_encode($json);
  } else {
    echo "kosong";
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["type"])) {
    if ($_POST["type"] == "insert") {    
            $crud->execute($_POST["query"]);
            $response = array(
              'status' => 'success',
              'msg' => 'Berhasil Menambahkan Data'
            );
            echo json_encode($response);
            exit();       
    }

    if ($_POST["type"] == "delete") {
        $crud->execute($_POST["query"]);
        $response = array(
          'status' => 'success',
          'msg' => 'Data berhasil dihapus'
        );
        echo json_encode($response);
        exit();
    }

    if ($_POST["type"] == "update") {
            $crud->execute($_POST["query"]);
              $response = array(
                'status' => 'success',
                'msg' => 'Berhasil Mengubah Data'
              );
              echo json_encode($response);
              exit();
        } else{
            $response = array(
                'status' => 'error',
                'msg' => 'Perubahan Data Gagal'
              );
              echo json_encode($response);
              exit();
        }
    } else{
        $crud->execute($_POST["query"]);
        $response = array(
          'status' => 'success',
          'msg' => 'Data Berhasil Dirubah'
        );
        echo json_encode($response);
        exit();
    }
}





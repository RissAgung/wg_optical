<?php
include "../config/koneksi.php";
session_start();
$crud = new koneksi();
date_default_timezone_set("Asia/Bangkok");

$data = [];
$param = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["type"])) {
        if ($_POST["type"] == "insert_lunas") {

            $idCus = generateCustomerID($crud);
            // insert customer
            $crud->execute("INSERT INTO customer VALUES ('" . $idCus . "', '" . $_POST['txt_nama'] . "', '" . $_POST['txt_kecamatan'] . "', '" . $_POST['txt_desa'] . "', '" . $_POST['txt_alamat'] . "', '" . $_POST['txt_pekerjaan'] . "', '" . $_POST['txt_instansi'] . "')");

            foreach (json_decode($_POST['data']) as $value) {
                array_push($data, (array) $value);
            }

            // insert transaksi
            $crud->execute("INSERT INTO transaksi VALUES ('" . generateTransaksiID($data) . "', '1', NOW(), '" . $_SESSION["id_pegawai"] . "', '" . $_POST['total'] . "', '" . $_POST['total_harga'] . "', '" . $_POST['kembalian'] . "', '" . $idCus . "', '" . $_POST['tgljatuhtempo'] . "', NULL, NULL)");

            // insert transaksi
            for ($i = 0; $i < count($data); $i++) {
                $crud->execute("INSERT INTO detail_transaksi VALUES ('" . generateTransaksiID($data) . "', '" . $data[$i]["kode"] . "')");

                // move to frame transaksi
                $crud->execute("INSERT INTO frame_transaksi (kode_detail_pesanan, harga, kode_frame, id_detail_bawa) SELECT keranjang_frame.kode_pesanan, keranjang_frame.harga, detail_bawa.Kode_Frame, detail_bawa.Id_Bawa FROM keranjang_frame JOIN detail_bawa ON keranjang_frame.id_bawa = detail_bawa.Id_Bawa JOIN produk ON detail_bawa.Kode_Frame = produk.kode_frame WHERE kode_pesanan = '" . $data[$i]["kode"] . "'");

                // move to lensa transaksi
                $crud->execute("INSERT INTO lensa_transaksi (kode_detail_pesanan, kode_varian_lensa_transaksi, id_jenis_lensa, harga) SELECT kode_pesanan, kode_varian_lensa_keranjang, id_jenis_lensa, harga FROM keranjang_lensa WHERE kode_pesanan = '" . $data[$i]["kode"] . "'");

                // move resep lensa
                $crud->execute("INSERT INTO resep (kode_varian_lensa_transaksi, KN_SPH, KN_CYL, KN_AXIS, KR_SPH, KR_CYL, KR_AXIS, `KN_ADD+`, KN_PD, KN_SEG, `KR_ADD+`, KR_PD, KR_SEG) SELECT keranjang_resep.kode_varian_lensa_keranjang, keranjang_resep.KN_SPH, keranjang_resep.KN_CYL, keranjang_resep.KN_AXIS, keranjang_resep.KR_SPH, keranjang_resep.KR_CYL, keranjang_resep.KR_AXIS, keranjang_resep.`KN_ADD+`, keranjang_resep.KN_PD, keranjang_resep.KN_SEG, keranjang_resep.`KR_ADD+`, keranjang_resep.KR_PD, keranjang_resep.KR_SEG FROM keranjang_resep JOIN keranjang_lensa ON keranjang_resep.kode_varian_lensa_keranjang = keranjang_lensa.kode_varian_lensa_keranjang WHERE keranjang_lensa.kode_pesanan = '" . $data[$i]["kode"] . "'");

                // move detail varian lensa
                $crud->execute("INSERT INTO detail_varian_lensa_transaksi (kode_varian_lensa_transaksi, kode_lensa) SELECT detail_varian_lensa_keranjang.kode_varian_lensa_keranjang, detail_varian_lensa_keranjang.kode_lensa FROM detail_varian_lensa_keranjang JOIN keranjang_lensa ON detail_varian_lensa_keranjang.kode_varian_lensa_keranjang = keranjang_lensa.kode_varian_lensa_keranjang WHERE keranjang_lensa.kode_pesanan = '" . $data[$i]["kode"] . "'");

                // delete keranjang frame to trigger detail bawa
                $crud->execute("DELETE FROM keranjang_frame WHERE kode_pesanan = '" . $data[$i]["kode"] . "'");

                // hapus keranjang
                $crud->execute("DELETE FROM keranjang WHERE kode_pesanan = '" . $data[$i]["kode"] . "'");
            }

            $response = array(
                'status' => 'success',
                'msg' => 'Transaksi Berhasil'
            );
            echo json_encode($response);
            exit();
        } else if ($_POST["type"] == "insert_cicilan") {

            $idCus = generateCustomerID($crud);
            // insert customer
            $crud->execute("INSERT INTO customer VALUES ('" . $idCus . "', '" . $_POST['txt_nama'] . "', '" . $_POST['txt_kecamatan'] . "', '" . $_POST['txt_desa'] . "', '" . $_POST['txt_alamat'] . "', '" . $_POST['txt_pekerjaan'] . "', '" . $_POST['txt_instansi'] . "')");

            foreach (json_decode($_POST['data']) as $value) {
                array_push($data, (array) $value);
            }

            // insert transaksi
            $crud->execute("INSERT INTO transaksi VALUES ('" . generateTransaksiID($data) . "', '1', NOW(), '" . $_SESSION["id_pegawai"] . "', '" . $_POST['total'] . "', '" . $_POST['total_harga'] . "', '" . $_POST['kembalian'] . "', '" . $idCus . "', '" . $_POST['tgljatuhtempo'] . "', NULL, NULL)");

            // insert transaksi
            for ($i = 0; $i < count($data); $i++) {
                $crud->execute("INSERT INTO detail_transaksi VALUES ('" . generateTransaksiID($data) . "', '" . $data[$i]["kode"] . "')");

                // move to frame transaksi
                $crud->execute("INSERT INTO frame_transaksi (kode_detail_pesanan, harga, kode_frame, id_detail_bawa) SELECT keranjang_frame.kode_pesanan, keranjang_frame.harga, detail_bawa.Kode_Frame, detail_bawa.Id_Bawa FROM keranjang_frame JOIN detail_bawa ON keranjang_frame.id_bawa = detail_bawa.Id_Bawa JOIN produk ON detail_bawa.Kode_Frame = produk.kode_frame WHERE kode_pesanan = '" . $data[$i]["kode"] . "'");

                // move to lensa transaksi
                $crud->execute("INSERT INTO lensa_transaksi (kode_detail_pesanan, kode_varian_lensa_transaksi, id_jenis_lensa, harga) SELECT kode_pesanan, kode_varian_lensa_keranjang, id_jenis_lensa, harga FROM keranjang_lensa WHERE kode_pesanan = '" . $data[$i]["kode"] . "'");

                // move resep lensa
                $crud->execute("INSERT INTO resep (kode_varian_lensa_transaksi, KN_SPH, KN_CYL, KN_AXIS, KR_SPH, KR_CYL, KR_AXIS, `KN_ADD+`, KN_PD, KN_SEG, `KR_ADD+`, KR_PD, KR_SEG) SELECT keranjang_resep.kode_varian_lensa_keranjang, keranjang_resep.KN_SPH, keranjang_resep.KN_CYL, keranjang_resep.KN_AXIS, keranjang_resep.KR_SPH, keranjang_resep.KR_CYL, keranjang_resep.KR_AXIS, keranjang_resep.`KN_ADD+`, keranjang_resep.KN_PD, keranjang_resep.KN_SEG, keranjang_resep.`KR_ADD+`, keranjang_resep.KR_PD, keranjang_resep.KR_SEG FROM keranjang_resep JOIN keranjang_lensa ON keranjang_resep.kode_varian_lensa_keranjang = keranjang_lensa.kode_varian_lensa_keranjang WHERE keranjang_lensa.kode_pesanan = '" . $data[$i]["kode"] . "'");

                // move detail varian lensa
                $crud->execute("INSERT INTO detail_varian_lensa_transaksi (kode_varian_lensa_transaksi, kode_lensa) SELECT detail_varian_lensa_keranjang.kode_varian_lensa_keranjang, detail_varian_lensa_keranjang.kode_lensa FROM detail_varian_lensa_keranjang JOIN keranjang_lensa ON detail_varian_lensa_keranjang.kode_varian_lensa_keranjang = keranjang_lensa.kode_varian_lensa_keranjang WHERE keranjang_lensa.kode_pesanan = '" . $data[$i]["kode"] . "'");

                // delete keranjang frame to trigger detail bawa
                $crud->execute("DELETE FROM keranjang_frame WHERE kode_pesanan = '" . $data[$i]["kode"] . "'");

                // hapus keranjang
                $crud->execute("DELETE FROM keranjang WHERE kode_pesanan = '" . $data[$i]["kode"] . "'");
            }

            $idCicilan = "CL" . generateTransaksiID($data);
            $crud->execute("INSERT INTO cicilan VALUES ('" . $idCicilan . "','" . generateTransaksiID($data) . "','" . $_POST['total'] . "')");

            $response = array(
                'status' => 'success',
                'msg' => 'Transaksi Berhasil'
            );
            echo json_encode($response);
            exit();
        }
    }
}

function generateTransaksiID($arr)
{
    $datenow = getdate(time());
    return "TR" . count($arr) . "" . $datenow['mday'] . "" . $datenow['mon'] . "" . $datenow['year'] . "" . $datenow['hours'] . "" . $datenow['minutes'] . "" . $datenow['seconds'];
}

function generateCustomerID($kon)
{
    $res = $kon->showData("SELECT COUNT(id_customer) as jumlah FROM customer");

    foreach ($res as $data) {

        if ($data['jumlah'] == 0) {
            return 'CST001';
        } else {
            return 'CST00' . ($data['jumlah'] + 1);
        }
    }
}

<?php
include '../config/koneksi.php';
date_default_timezone_set("Asia/Bangkok");
$api_key = 'aoi12j1h7dwgopticalw1dggwuawdki';
$crud = new koneksi();

$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['apikey'])) {
        if ($_POST['apikey'] == $api_key) {
            if ($_POST['type'] == 'getProses') {
                $res = $crud->showData("SELECT transaksi.status_pengiriman, transaksi.status_confirm, transaksi.tanggal, transaksi.kode_pesanan, pegawai.nama AS nama_sales, customer.nama AS nama_cus, transaksi.bukti_pengiriman, customer.alamat_jalan, transaksi.total_harga, transaksi.total_bayar, transaksi.status_pengiriman, cicilan.depan_pembayaran, cicilan.kode_cicilan FROM pegawai JOIN transaksi ON pegawai.id_pegawai = transaksi.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN cicilan ON transaksi.kode_pesanan = cicilan.kode_pesanan WHERE (transaksi.status_confirm = 1 AND transaksi.id_pegawai = '" . $_POST['id_pegawai'] . "') OR (transaksi.status_pengiriman = 'produksi' AND transaksi.id_pegawai = '" . $_POST['id_pegawai'] . "')");

                foreach ($res as $value) {
                    array_push($data, array(
                        'status_pengiriman' => $value['status_pengiriman'],
                        'bukti_pengiriman' => $value['bukti_pengiriman'],
                        'tanggal' => $value['tanggal'],
                        'kode_pesanan' => $value['kode_pesanan'],
                        'alamat' => $value['alamat_jalan'],
                        'nama_sales' => $value['nama_sales'],
                        'nama_customer' => $value['nama_cus'],
                        'total_harga' => $value['total_harga'],
                        'status_confirm' => $value['status_confirm'],
                        'total_bayar' => $value['total_bayar'],
                        'depan_pembayaran' => $value['depan_pembayaran'],
                        'kode_cicilan' => $value['kode_cicilan'],
                    ));
                }

                echo json_encode($data);
            } else if ($_POST['type'] == 'getKirim') {
                $res = $crud->showData("SELECT transaksi.status_pengiriman, transaksi.status_confirm, transaksi.tanggal, transaksi.kode_pesanan, pegawai.nama AS nama_sales, customer.nama AS nama_cus, transaksi.bukti_pengiriman, customer.alamat_jalan, transaksi.total_harga, transaksi.total_bayar, transaksi.status_pengiriman, cicilan.depan_pembayaran, cicilan.kode_cicilan FROM pegawai JOIN transaksi ON pegawai.id_pegawai = transaksi.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN cicilan ON transaksi.kode_pesanan = cicilan.kode_pesanan WHERE transaksi.status_pengiriman = 'kirim' AND transaksi.bukti_pengiriman IS NULL AND transaksi.id_pegawai = '" . $_POST['id_pegawai'] . "'");
                foreach ($res as $value) {
                    array_push($data, array(
                        'status_pengiriman' => $value['status_pengiriman'],
                        'bukti_pengiriman' => $value['bukti_pengiriman'],
                        'tanggal' => $value['tanggal'],
                        'kode_pesanan' => $value['kode_pesanan'],
                        'alamat' => $value['alamat_jalan'],
                        'nama_sales' => $value['nama_sales'],
                        'nama_customer' => $value['nama_cus'],
                        'total_harga' => $value['total_harga'],
                        'status_confirm' => $value['status_confirm'],
                        'total_bayar' => $value['total_bayar'],
                        'depan_pembayaran' => $value['depan_pembayaran'],
                        'kode_cicilan' => $value['kode_cicilan'],
                    ));
                }

                echo json_encode($data);
            } else if ($_POST['type'] == 'getKonfirmasi') {
                $res = $crud->showData("SELECT transaksi.status_pengiriman, transaksi.status_confirm, transaksi.tanggal, transaksi.kode_pesanan, pegawai.nama AS nama_sales, customer.nama AS nama_cus, transaksi.bukti_pengiriman, customer.alamat_jalan, transaksi.total_harga, transaksi.total_bayar, transaksi.status_pengiriman, cicilan.depan_pembayaran, cicilan.kode_cicilan FROM pegawai JOIN transaksi ON pegawai.id_pegawai = transaksi.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN cicilan ON transaksi.kode_pesanan = cicilan.kode_pesanan WHERE (transaksi.status_pengiriman = 'kirim' AND transaksi.bukti_pengiriman IS NOT NULL AND transaksi.id_pegawai = '" . $_POST['id_pegawai'] . "') OR (transaksi.status_pengiriman = 'terima' AND transaksi.total_bayar < transaksi.total_harga)");
                foreach ($res as $value) {
                    array_push($data, array(
                        'status_pengiriman' => $value['status_pengiriman'],
                        'bukti_pengiriman' => $value['bukti_pengiriman'],
                        'tanggal' => $value['tanggal'],
                        'kode_pesanan' => $value['kode_pesanan'],
                        'alamat' => $value['alamat_jalan'],
                        'nama_sales' => $value['nama_sales'],
                        'nama_customer' => $value['nama_cus'],
                        'total_harga' => $value['total_harga'],
                        'status_confirm' => $value['status_confirm'],
                        'total_bayar' => $value['total_bayar'],
                        'depan_pembayaran' => $value['depan_pembayaran'],
                        'kode_cicilan' => $value['kode_cicilan'],
                    ));
                }

                echo json_encode($data);
            } else if ($_POST["type"] == "up_bukti") {
                $imgproduk_name = $_FILES['foto']['name'];
                $imgproduk_size = $_FILES['foto']['size'];
                $tmpproduk_name = $_FILES['foto']['tmp_name'];
                $errorproduk    = $_FILES['foto']['error'];
                $allowed_exs = array("jpg", "jpeg", "png");

                $namefile = uniqid('bukti-pengiriman-', true) . '.' . $_POST['extFile'];

                $kode_transaksi = $_POST["kode_tr"];

                $img_upload_path_produk = "../images/bukti_pengiriman/" . $namefile;
                move_uploaded_file($tmpproduk_name, $img_upload_path_produk);
                $crud->execute("UPDATE transaksi SET bukti_pengiriman = '" . $namefile . "' WHERE kode_pesanan = '" . $kode_transaksi . "'");
                $response = array(
                    'status' => 'success',
                    'msg' => 'Berhasil Mengirim Bukti Pengiriman'
                );
                echo json_encode($response);
                exit();
            } else if ($_POST['type'] == 'detail_invoice') {

                $arr1 = [];
                $arr2 = [];
                $arr3 = [];
                $arr4 = [];

                $data1 = $crud->showData("SELECT transaksi.status_confirm, transaksi.status_pengiriman, transaksi.kode_pesanan, transaksi.tanggal, pegawai.nama AS nama_sales, customer.nama AS nama_cus, customer.kecamatan, customer.desa, customer.no_hp, customer.alamat_jalan, customer.pekerjaan, customer.instansi FROM pegawai JOIN transaksi ON pegawai.id_pegawai = transaksi.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer WHERE transaksi.kode_pesanan = '" . $_GET['detail'] . "'");

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

                            array_push($arr2[$i]["lensa"], $index["nama_lensa"]);
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

                foreach ($data5 as $index) {
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
                        "no_hp" => $index['no_hp'],
                        "kecamatan" => $index["kecamatan"],
                        "desa" => $index["desa"],
                        "alamat_jalan" => $index["alamat_jalan"],
                        "pekerjaan" => $index["pekerjaan"],
                        "instansi" => $index["instansi"],
                        "data_pesanan" => $arr2,
                        "data_pembayaran" => $arr3,
                        "data_cicilan" => $arr4,
                        "status_confirm" => $index['status_confirm'],
                    ));
                }

                echo json_encode($arr1, JSON_PRETTY_PRINT);
                exit();
            }
        }
    }
}

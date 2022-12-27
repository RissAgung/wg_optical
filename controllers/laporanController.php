<?php
include '../config/koneksi.php';

$crud = new koneksi();

$wilayah = [];
$data = [];

if (isset($_GET['filter'])) {
    if ($_GET['filter'] == 'harian') {
        $res = $crud->showData("SELECT customer.kecamatan FROM transaksi JOIN customer ON transaksi.id_customer = customer.id_customer AND date(tanggal) = '" . $_POST['tanggal'] . "' GROUP BY customer.kecamatan
        ");
        foreach ($res as $value) {
            array_push($wilayah, $value);
            array_push($data, array(
                "jumlah" => 0,
                "kecamatan" => $value['kecamatan'],
            ));
        }
    }
} else {
    $res = $crud->showData("SELECT customer.kecamatan FROM transaksi JOIN customer ON transaksi.id_customer = customer.id_customer GROUP BY customer.kecamatan
        ");
    foreach ($res as $value) {
        array_push($wilayah, $value);
        array_push($data, array(
            "jumlah" => 0,
            "kecamatan" => $value['kecamatan'],
        ));
    }
}



// echo json_encode($wilayah);

if (isset($_GET['type'])) {
    if ($_GET['type'] == 'getFrame') {
        if (isset($_GET['filter'])) {
            if ($_GET['filter'] == 'harian') {
                $res = $crud->showData("SELECT COUNT(*) AS jumlah, customer.kecamatan FROM transaksi INNER JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN detail_transaksi ON detail_transaksi.kode_pesanan = transaksi.kode_pesanan LEFT JOIN frame_transaksi ON frame_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan LEFT JOIN lensa_transaksi ON lensa_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan WHERE frame_transaksi.kode_detail_pesanan IS NOT NULL AND lensa_transaksi.kode_detail_pesanan IS NULL AND date(tanggal) = '" . $_POST['tanggal'] . "' GROUP BY customer.kecamatan");
                foreach ($res as $value) {
                    for ($i = 0; $i < count($wilayah); $i++) {
                        if ($wilayah[$i]['kecamatan'] == $value['kecamatan']) {
                            $data[$i]['jumlah'] = $value['jumlah'];
                        }
                    }
                }
            }
        } else {
            $res = $crud->showData("SELECT COUNT(*) AS jumlah, customer.kecamatan FROM transaksi INNER JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN detail_transaksi ON detail_transaksi.kode_pesanan = transaksi.kode_pesanan LEFT JOIN frame_transaksi ON frame_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan LEFT JOIN lensa_transaksi ON lensa_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan WHERE frame_transaksi.kode_detail_pesanan IS NOT NULL AND lensa_transaksi.kode_detail_pesanan IS NULL GROUP BY customer.kecamatan");
            foreach ($res as $value) {
                for ($i = 0; $i < count($wilayah); $i++) {
                    if ($wilayah[$i]['kecamatan'] == $value['kecamatan']) {
                        $data[$i]['jumlah'] = $value['jumlah'];
                    }
                }
            }
        }

        echo json_encode($data);
        exit();
    } else if ($_GET['type'] == 'getLensa') {
        if (isset($_GET['filter'])) {
            if ($_GET['filter'] == 'harian') {
                $res = $crud->showData("SELECT COUNT(*) AS jumlah, customer.kecamatan FROM transaksi INNER JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN detail_transaksi ON detail_transaksi.kode_pesanan = transaksi.kode_pesanan LEFT JOIN frame_transaksi ON frame_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan LEFT JOIN lensa_transaksi ON lensa_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan WHERE frame_transaksi.kode_detail_pesanan IS NULL AND lensa_transaksi.kode_detail_pesanan IS NOT NULL AND date(tanggal) = '" . $_POST['tanggal'] . "' GROUP BY customer.kecamatan");
                foreach ($res as $value) {
                    for ($i = 0; $i < count($wilayah); $i++) {
                        if ($wilayah[$i]['kecamatan'] == $value['kecamatan']) {
                            $data[$i]['jumlah'] = $value['jumlah'];
                        }
                    }
                }
            }
        } else {
            $res = $crud->showData("SELECT COUNT(*) AS jumlah, customer.kecamatan FROM transaksi INNER JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN detail_transaksi ON detail_transaksi.kode_pesanan = transaksi.kode_pesanan LEFT JOIN frame_transaksi ON frame_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan LEFT JOIN lensa_transaksi ON lensa_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan WHERE frame_transaksi.kode_detail_pesanan IS NULL AND lensa_transaksi.kode_detail_pesanan IS NOT NULL GROUP BY customer.kecamatan");
            foreach ($res as $value) {
                for ($i = 0; $i < count($wilayah); $i++) {
                    if ($wilayah[$i]['kecamatan'] == $value['kecamatan']) {
                        $data[$i]['jumlah'] = $value['jumlah'];
                    }
                }
            }
        }


        echo json_encode($data);
        exit();
    } else if ($_GET['type'] == 'getFullset') {
        if (isset($_GET['filter'])) {
            if ($_GET['filter'] == 'harian') {
                $res = $crud->showData("SELECT COUNT(*) AS jumlah, customer.kecamatan FROM transaksi INNER JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN detail_transaksi ON detail_transaksi.kode_pesanan = transaksi.kode_pesanan LEFT JOIN frame_transaksi ON frame_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan LEFT JOIN lensa_transaksi ON lensa_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan WHERE frame_transaksi.kode_detail_pesanan IS NOT NULL AND lensa_transaksi.kode_detail_pesanan IS NOT NULL AND date(tanggal) = '" . $_POST['tanggal'] . "' GROUP BY customer.kecamatan");

                foreach ($res as $value) {
                    for ($i = 0; $i < count($wilayah); $i++) {
                        if ($wilayah[$i]['kecamatan'] == $value['kecamatan']) {
                            $data[$i]['jumlah'] = $value['jumlah'];
                        }
                    }
                    // array_push($data, $value);
                }
            }
        } else {
            $res = $crud->showData("SELECT COUNT(*) AS jumlah, customer.kecamatan FROM transaksi INNER JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN detail_transaksi ON detail_transaksi.kode_pesanan = transaksi.kode_pesanan LEFT JOIN frame_transaksi ON frame_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan LEFT JOIN lensa_transaksi ON lensa_transaksi.kode_detail_pesanan = detail_transaksi.kode_detail_pesanan WHERE frame_transaksi.kode_detail_pesanan IS NOT NULL AND lensa_transaksi.kode_detail_pesanan IS NOT NULL GROUP BY customer.kecamatan");
            // echo $wilayah[0]['kecamatan'];
            // for ($i=0; $i < count($wilayah); $i++) { 
            //     if($wilayah[$i]['kecamatan'] == 'Kebonsari'){Kebonsari
            //         echo $i;
            //     }
            // }
            foreach ($res as $value) {
                for ($i = 0; $i < count($wilayah); $i++) {
                    if ($wilayah[$i]['kecamatan'] == $value['kecamatan']) {
                        $data[$i]['jumlah'] = $value['jumlah'];
                    }
                }
                // array_push($data, $value);
            }
        }



        echo json_encode($data);
        exit();
    } else if ($_GET['type'] == 'getWilayah') {
        $data = [];
        if (isset($_GET['filter'])) {
            if ($_GET['filter'] == 'harian') {
                $res = $crud->showData("SELECT customer.kecamatan FROM transaksi JOIN customer ON transaksi.id_customer = customer.id_customer AND date(tanggal) = '" . $_POST['tanggal'] . "' GROUP BY customer.kecamatan
            ");
                foreach ($res as $value) {
                    array_push($data, $value);
                }
            }
        } else {
            $res = $crud->showData("SELECT customer.kecamatan FROM transaksi JOIN customer ON transaksi.id_customer = customer.id_customer GROUP BY customer.kecamatan
            ");
            foreach ($res as $value) {
                array_push($data, $value);
            }
        }

        echo json_encode($data);
        exit();
    }
}

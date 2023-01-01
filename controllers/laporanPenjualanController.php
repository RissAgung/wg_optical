<?php
include '../config/koneksi.php';

$crud = new Koneksi();

$data = [];
$dataPengeluaran = [];
$labels = [];

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
} else {
    if (isset($_GET['getDataBarChart'])) {
        if ($_GET['getDataBarChart'] == 'harian') {
            $res = $crud->showData("SELECT kode_pesanan, SUM(total_bayar - kembalian) AS total, date(tanggal) AS tanggal, (CASE WHEN DAYNAME(tanggal)='Sunday' THEN 'Minggu' WHEN DAYNAME(tanggal)='Monday' THEN 'Senin' WHEN DAYNAME(tanggal)='Tuesday' THEN 'Selasa' WHEN DAYNAME(tanggal)='Wednesday' THEN 'Rabu' WHEN DAYNAME(tanggal)='Thursday' THEN 'Kamis' WHEN DAYNAME(tanggal)='Friday' THEN 'Jumat' ELSE 'Sabtu' END ) as hari FROM transaksi WHERE DATE(tanggal) = DATE('" . $_POST['tanggal'] . "') GROUP BY DATE(tanggal)");


            $resultnya = [];
            foreach ($res as $value) {
                array_push($resultnya, array(
                    'data' => $value['total'],
                    'labels' => $value['hari'],
                ));
            }

            $res1 = $crud->showData("SELECT kode_tr_pengeluaran, SUM(total_harga) as total, tanggal, (CASE WHEN DAYNAME(tanggal)='Sunday' THEN 'Minggu' WHEN DAYNAME(tanggal)='Monday' THEN 'Senin' WHEN DAYNAME(tanggal)='Tuesday' THEN 'Selasa' WHEN DAYNAME(tanggal)='Wednesday' THEN 'Rabu' WHEN DAYNAME(tanggal)='Thursday' THEN 'Kamis' WHEN DAYNAME(tanggal)='Friday' THEN 'Jumat' ELSE 'Sabtu' END ) as hari FROM tr_pengeluaran WHERE kategori = 'operasional' AND DATE(tanggal) = DATE('" . $_POST['tanggal'] . "') GROUP BY DATE(tanggal)");

            $result2 = [];

            foreach ($res1 as $value) {
                array_push($resultnya, array(
                    'data_pengeluaran' => $value['total'],
                ));
            }
            echo json_encode($resultnya);
        } else if ($_GET['getDataBarChart'] == 'mingguan') {
            $res = $crud->showData("SELECT kode_pesanan, (SUM(total_bayar) - SUM(kembalian)) AS total, YEARWEEK(DATE(tanggal)), (CASE WHEN DAYNAME(tanggal)='Sunday' THEN 'Minggu' WHEN DAYNAME(tanggal)='Monday' THEN 'Senin' WHEN DAYNAME(tanggal)='Tuesday' THEN 'Selasa' WHEN DAYNAME(tanggal)='Wednesday' THEN 'Rabu' WHEN DAYNAME(tanggal)='Thursday' THEN 'Kamis' WHEN DAYNAME(tanggal)='Friday' THEN 'Jumat' ELSE 'Sabtu' END ) as hari, date(tanggal) AS tanggal FROM transaksi WHERE YEARWEEK(DATE(tanggal)) = YEARWEEK(DATE('" . $_POST['tanggal'] . "')) GROUP BY DATE(tanggal)");
            $data = [0, 0, 0, 0, 0, 0, 0];
            $labels = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

            foreach ($res as $value) {
                for ($i = 0; $i < count($labels); $i++) {
                    if ($value['hari'] == $labels[$i]) {
                        $data[$i] = $value['total'];
                    }
                }
            }

            $dataPengeluaran = [0, 0, 0, 0, 0, 0, 0];
            $res1 = $crud->showData("SELECT kode_tr_pengeluaran, SUM(total_harga) as total, tanggal, (CASE WHEN DAYNAME(tanggal)='Sunday' THEN 'Minggu' WHEN DAYNAME(tanggal)='Monday' THEN 'Senin' WHEN DAYNAME(tanggal)='Tuesday' THEN 'Selasa' WHEN DAYNAME(tanggal)='Wednesday' THEN 'Rabu' WHEN DAYNAME(tanggal)='Thursday' THEN 'Kamis' WHEN DAYNAME(tanggal)='Friday' THEN 'Jumat' ELSE 'Sabtu' END ) as hari FROM tr_pengeluaran WHERE kategori = 'operasional' AND YEARWEEK(DATE(tanggal)) = YEARWEEK(DATE('" . $_POST['tanggal'] . "')) GROUP BY DATE(tanggal)");

            foreach ($res1 as $value) {
                for ($i = 0; $i < count($labels); $i++) {
                    if ($value['hari'] == $labels[$i]) {
                        $dataPengeluaran[$i] = $value['total'];
                    }
                }
            }

            echo json_encode(array(
                'data' => $data,
                'data_pengeluaran' => $dataPengeluaran,
                'labels' => $labels,
            ));
        } else if ($_GET['getDataBarChart'] == 'bulanan') {
            $yearweek = [];
            $getLabel = $crud->showData("WITH RECURSIVE 
            Years(y) AS 
                    (
                    SELECT '" . $_POST['tahun'] . "'
                    UNION ALL
                    SELECT y + 1 FROM Years WHERE y < 2021
                    ),
            Days (d) AS
                    (
                    SELECT 1
                    UNION ALL
                    SELECT d + 1 FROM Days WHERE d < 366
                    )
            SELECT YEARWEEK(DATE(Min(MakeDate(y,d)))) as yearweek,
            y AS Year,
            MONTH(MakeDate(y,d)) AS Month,
            WEEK(MakeDate(y,d))+1 -WEEK(TIMESTAMPADD(MONTH,MONTH(MakeDate(y,d))-1,MakeDate(y,1))) AS Week,
            DAY(Min(MakeDate(y,d))) AS StartDate,
            DAY(DATE(timestampadd(second,-1,timestampadd(day,1,MAx(MakeDate(y,d)))))) AS EndDate, (CASE WHEN MONTHNAME(DATE(Min(MakeDate(y,d)))) = 'January' THEN 'Jan' WHEN MONTHNAME(DATE(Min(MakeDate(y,d)))) = 'February' THEN 'Feb' WHEN MONTHNAME(DATE(Min(MakeDate(y,d)))) = 'March' THEN 'Mar' WHEN MONTHNAME(DATE(Min(MakeDate(y,d)))) = 'April' THEN 'Apr' WHEN MONTHNAME(DATE(Min(MakeDate(y,d)))) = 'May' THEN 'Mei' WHEN MONTHNAME(DATE(Min(MakeDate(y,d)))) = 'June' THEN 'Jun' WHEN MONTHNAME(DATE(Min(MakeDate(y,d)))) = 'July' THEN 'Jul' WHEN MONTHNAME(DATE(Min(MakeDate(y,d)))) = 'August' THEN 'Aug' WHEN MONTHNAME(DATE(Min(MakeDate(y,d)))) = 'September' THEN 'Sep' WHEN MONTHNAME(DATE(Min(MakeDate(y,d)))) = 'October' THEN 'Oct' WHEN MONTHNAME(DATE(Min(MakeDate(y,d)))) = 'November' THEN 'Nov' WHEN MONTHNAME(DATE(Min(MakeDate(y,d)))) = 'December' THEN 'Dec' END) AS bulan
            FROM Years,Days
            WHERE MONTH(MakeDate(y,d)) = '" . $_POST['bulan'] . "' AND Year(MakeDate(y,d)) <= y 
            GROUP BY y, MONTH(MakeDate(y,d)),WEEK(MakeDate(y,d))+1 -WEEK(TIMESTAMPADD(MONTH,MONTH(MakeDate(y,d))-1,MakeDate(y,1)))
            ORDER BY 1,2,3");

            foreach ($getLabel as $value) {
                array_push($labels, strval($value['StartDate'] . "\n" . ' - ' . "\n" . $value['EndDate'] . ' ' . $value['bulan']));
                array_push($yearweek, $value['yearweek']);
            }

            $res = $crud->showData("SELECT kode_pesanan, SUM(total_bayar - kembalian) AS total, YEARWEEK(date(tanggal)) AS yearweek FROM transaksi WHERE MONTH(DATE(tanggal)) = '" . $_POST['bulan'] . "' AND YEAR(DATE(tanggal)) = '" . $_POST['tahun'] . "' GROUP BY yearweek;");
            $data = [0, 0, 0, 0, 0, 0];


            foreach ($res as $value) {
                for ($i = 0; $i < count($yearweek); $i++) {
                    if ($value['yearweek'] == $yearweek[$i]) {
                        $data[$i] = $value['total'];
                    }
                }
            }

            echo json_encode(array(
                'data' => $data,
                'labels' => $labels,
            ));
        } else if ($_GET['getDataBarChart'] == 'tahunan') {
            $res = $crud->showData("SELECT kode_pesanan, SUM(total_bayar - kembalian) AS total, (CASE WHEN MONTHNAME(DATE(tanggal)) = 'January' THEN 'Jan' WHEN MONTHNAME(DATE(tanggal)) = 'February' THEN 'Feb' WHEN MONTHNAME(DATE(tanggal)) = 'March' THEN 'Mar' WHEN MONTHNAME(DATE(tanggal)) = 'April' THEN 'Apr' WHEN MONTHNAME(DATE(tanggal)) = 'May' THEN 'Mei' WHEN MONTHNAME(DATE(tanggal)) = 'June' THEN 'Jun' WHEN MONTHNAME(DATE(tanggal)) = 'July' THEN 'Jul' WHEN MONTHNAME(DATE(tanggal)) = 'August' THEN 'Aug' WHEN MONTHNAME(DATE(tanggal)) = 'September' THEN 'Sep' WHEN MONTHNAME(DATE(tanggal)) = 'October' THEN 'Oct' WHEN MONTHNAME(DATE(tanggal)) = 'November' THEN 'Nov' WHEN MONTHNAME(DATE(tanggal)) = 'December' THEN 'Dec' END) AS tahun FROM transaksi WHERE YEAR(DATE(tanggal)) = '" . $_POST['tahun'] . "' GROUP BY tahun;");
            $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            foreach ($res as $value) {
                for ($i = 0; $i < count($labels); $i++) {
                    if ($value['tahun'] == $labels[$i]) {
                        $data[$i] = $value['total'];
                    }
                }
            }

            echo json_encode(array(
                'data' => $data,
                'labels' => $labels,
            ));
        } else if ($_GET['getDataBarChart'] == 'range') {
            $res = $crud->showData("SELECT kode_pesanan, SUM(total_bayar - kembalian) AS total FROM transaksi WHERE DATE(tanggal) BETWEEN '" . $_POST['start'] . "' AND '" . $_POST['end'] . "'");

            foreach ($res as $value) {
                array_push($data, $value['total']);
            }

            echo json_encode(array(
                'data' => $data,
            ));
        } else {
            $res = $crud->showData("SELECT kode_pesanan, (SUM(total_bayar) - SUM(kembalian)) AS total, YEARWEEK(DATE(tanggal)), (CASE WHEN DAYNAME(tanggal)='Sunday' THEN 'Minggu' WHEN DAYNAME(tanggal)='Monday' THEN 'Senin' WHEN DAYNAME(tanggal)='Tuesday' THEN 'Selasa' WHEN DAYNAME(tanggal)='Wednesday' THEN 'Rabu' WHEN DAYNAME(tanggal)='Thursday' THEN 'Kamis' WHEN DAYNAME(tanggal)='Friday' THEN 'Jumat' ELSE 'Sabtu' END ) as hari, date(tanggal) AS tanggal FROM transaksi WHERE YEARWEEK(DATE(tanggal)) = YEARWEEK(DATE(NOW())) GROUP BY DATE(tanggal)");
            $data = [0, 0, 0, 0, 0, 0, 0];
            $labels = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

            foreach ($res as $value) {
                for ($i = 0; $i < count($labels); $i++) {
                    if ($value['hari'] == $labels[$i]) {
                        $data[$i] = $value['total'];
                    }
                }
            }

            $dataPengeluaran = [0, 0, 0, 0, 0, 0, 0];
            $res1 = $crud->showData("SELECT kode_tr_pengeluaran, SUM(total_harga) as total, tanggal, (CASE WHEN DAYNAME(tanggal)='Sunday' THEN 'Minggu' WHEN DAYNAME(tanggal)='Monday' THEN 'Senin' WHEN DAYNAME(tanggal)='Tuesday' THEN 'Selasa' WHEN DAYNAME(tanggal)='Wednesday' THEN 'Rabu' WHEN DAYNAME(tanggal)='Thursday' THEN 'Kamis' WHEN DAYNAME(tanggal)='Friday' THEN 'Jumat' ELSE 'Sabtu' END ) as hari FROM tr_pengeluaran WHERE kategori = 'operasional' AND YEARWEEK(DATE(tanggal)) = YEARWEEK(DATE(NOW())) GROUP BY DATE(tanggal)");

            foreach ($res1 as $value) {
                for ($i = 0; $i < count($labels); $i++) {
                    if ($value['hari'] == $labels[$i]) {
                        $dataPengeluaran[$i] = $value['total'];
                    }
                }
            }

            echo json_encode(array(
                'data' => $data,
                'data_pengeluaran' => $dataPengeluaran,
                'labels' => $labels,
            ));
        }
    }
}

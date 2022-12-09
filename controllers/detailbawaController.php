<?php
include '../config/koneksi.php';

$exec = new koneksi();

$data = [];
$tempData = [];


for ($i = 0; $i < count($_POST); $i++) {
    array_push($data, (array) json_decode($_POST['data-' . $i . '']));
    $res = $exec->showData("SELECT COUNT(Kode_Frame) as jumPerframe FROM detail_bawa WHERE Kode_Frame = '" . $data[$i]['kode'] . "'");
    foreach ($res as $value) {
        array_push($tempData, $value['jumPerframe']);
    }

    if ($tempData[$i] == 0) {
        for ($z = 1; $z <= $data[$i]['jumlah']; $z++) {
            $detailbawa = $data[$i]['kode'] . '-' . $z;
            $kodeframe = $data[$i]['kode'];
            $exec->execute("INSERT INTO detail_bawa VALUES ('" . $detailbawa . "', '" . $data[$i]['pegawai'] . "' ,'" . $kodeframe . "')");
        }
    } else {

        for ($g = 0; $g < $data[$i]['jumlah']; $g++) {
            $tempDataMissing = [];

            $res = $exec->showData("SELECT * FROM detail_bawa WHERE Kode_Frame = '" . $data[$i]['kode'] . "'");
            foreach ($res as $value) {
                $text = $value['Id_Bawa'];
                $indexfrom = strpos($text, '-') + 1;
                // ambil nomor
                array_push($tempDataMissing, substr($text, $indexfrom));
            }
            $range = range(1, max($tempDataMissing));
            $missing = array_diff($range, $tempDataMissing);

            if (count($missing) != 0) {

                // nembel
                $detailbawa = $data[$i]['kode'] . '-' . min($missing);
                $kodeframe = $data[$i]['kode'];

                $exec->execute("INSERT INTO detail_bawa VALUES ('" . $detailbawa . "', '" . $data[$i]['pegawai'] . "' ,'" . $kodeframe . "')");

                //var_dump($missing);
            } else {
                // ngelanjutin
                for ($z = (max($tempDataMissing) + 1); $z <= ($data[$i]['jumlah'] + $tempData[$i]); $z++) {
                    $detailbawa = $data[$i]['kode'] . '-' . $z;
                    $kodeframe = $data[$i]['kode'];

                    $exec->execute("INSERT INTO detail_bawa VALUES ('" . $detailbawa . "', '" . $data[$i]['pegawai'] . "' ,'" . $kodeframe . "')");
                    echo $detailbawa;
                }
            }
        }


        //   var_dump($tempDataMissing);
    }
}

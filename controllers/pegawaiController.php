<?php
include '../config/koneksi.php';

$crud = new Koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['type'])) {
        if ($_POST['type'] == 'tambah_pegawai') {
            # getting image data and store them in var
            // img peg
            $imgpeg_name = $_FILES['image_peg']['name'];
            $imgpeg_size = $_FILES['image_peg']['size'];
            $tmppeg_name = $_FILES['image_peg']['tmp_name'];
            $errorpeg    = $_FILES['image_peg']['error'];

            // img ktp
            $imgktp_name = $_FILES['image_ktp']['name'];
            $imgktp_size = $_FILES['image_ktp']['size'];
            $tmpktp_name = $_FILES['image_ktp']['tmp_name'];
            $errorktp    = $_FILES['image_ktp']['error'];

            // img kk
            $imgkk_name = $_FILES['image_kk']['name'];
            $imgkk_size = $_FILES['image_kk']['size'];
            $tmpkk_name = $_FILES['image_kk']['tmp_name'];
            $errorkk    = $_FILES['image_kk']['error'];
            $allowed_exs = array("jpg", "jpeg", "png");


            if ($errorpeg === 0 || $errorktp === 0 || $errorkk === 0) {
                if ($imgpeg_size > 2000000) {
                    $response = array(
                        'status' => 'error',
                        'msg' => 'File Foto Pegawai Terlalu Besar'
                    );
                    echo json_encode($response);
                    exit();
                } else if ($imgktp_size > 2000000) {
                    $response = array(
                        'status' => 'error',
                        'msg' => 'File Foto KTP Terlalu Besar'
                    );
                    echo json_encode($response);
                    exit();
                } else if ($imgkk_size > 2000000) {
                    $response = array(
                        'status' => 'error',
                        'msg' => 'File Foto KK Terlalu Besar'
                    );
                    echo json_encode($response);
                    exit();
                } else {

                    if (!in_array(pathinfo($imgpeg_name, PATHINFO_EXTENSION), $allowed_exs)) {
                        $response = array(
                            'status' => 'error',
                            'msg' => 'Ekstensi Foto Pegawai Tidak Sesuai'
                        );
                        echo json_encode($response);
                        exit();
                    } else if (!in_array(pathinfo($imgktp_name, PATHINFO_EXTENSION), $allowed_exs)) {
                        $response = array(
                            'status' => 'error',
                            'msg' => 'Ekstensi Foto KTP Tidak Sesuai'
                        );
                        echo json_encode($response);
                        exit();
                    } else if (!in_array(pathinfo($imgkk_name, PATHINFO_EXTENSION), $allowed_exs)) {
                        $response = array(
                            'status' => 'error',
                            'msg' => 'Ekstensi Foto KK Tidak Sesuai'
                        );
                        echo json_encode($response);
                        exit();
                    } else {
                        # crating upload path on root directory
                        $img_upload_path_peg = "../images/pegawai/foto_pegawai/" . $_POST['img_file_peg'];
                        $img_upload_path_ktp = "../images/pegawai/foto_ktp/" . $_POST['img_file_ktp'];
                        $img_upload_path_kk = "../images/pegawai/foto_kk/" . $_POST['img_file_kk'];
                        # move uploaded image to 'uploads' folder
                        move_uploaded_file($tmppeg_name, $img_upload_path_peg);
                        move_uploaded_file($tmpktp_name, $img_upload_path_ktp);
                        move_uploaded_file($tmpkk_name, $img_upload_path_kk);
                        // echo $_POST['query'];
                        $crud->insertData($_POST['query']);
                        $response = array(
                            'status' => 'success',
                            'msg' => 'Berhasil Menambahkan Data'
                        );
                        echo json_encode($response);
                        exit();
                    }
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'msg' => 'Gagal Menambahkan Data'
                );
                echo json_encode($response);
                exit();
            }
        }
    }

    // if (isset($_FILES['my_image'])) {
    //   echo $_POST['img_file'];
    //   echo $_POST['query'];
    //   var_dump($_FILES['my_image']);
    // }
}

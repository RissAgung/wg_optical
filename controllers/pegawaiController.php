<?php
date_default_timezone_set("Asia/Bangkok");
include '../config/koneksi.php';

$crud = new Koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['type'])) {
        if ($_POST['type'] == 'tambah_pegawai') {

            $email = $_POST['txt_email'];
            $query = "SELECT * FROM pegawai WHERE email = '$email'";
            $result = $crud->execute($query);
            $num = mysqli_num_rows($result);

            while ($row = mysqli_fetch_array($result)) {
                $emailval = $row['email'];
            }

            if ($num != 0) {
                if ($emailval == $email) {
                    $response = array(
                        'status' => 'error',
                        'msg' => 'Email telah terdaftar'
                    );
                    echo json_encode($response);
                    exit();
                }
            } else {
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
        } else if ($_POST['type'] == 'ubah_pegawai') {
            $allowed_exs = array("jpg", "jpeg", "png");
            if ($_POST['opsifoto'] == 'tanpa-foto') {
                $crud->execute($_POST['query']);
                $response = array(
                    'status' => 'success',
                    'msg' => 'Berhasil Mengubah Data',
                );
                echo json_encode($response);
                exit();
                // form_data.append('opsifoto', "tanpa-foto");
            } else if ($_POST['opsifoto'] == 'fotopegawai-dan-ktp') {
                $imgpeg_name = $_FILES['image_peg']['name'];
                $imgpeg_size = $_FILES['image_peg']['size'];
                $tmppeg_name = $_FILES['image_peg']['tmp_name'];
                $errorpeg    = $_FILES['image_peg']['error'];

                // img ktp
                $imgktp_name = $_FILES['image_ktp']['name'];
                $imgktp_size = $_FILES['image_ktp']['size'];
                $tmpktp_name = $_FILES['image_ktp']['tmp_name'];
                $errorktp    = $_FILES['image_ktp']['error'];

                if ($errorpeg === 0 || $errorktp === 0) {
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
                    } else {

                        if (!in_array(pathinfo($imgpeg_name, PATHINFO_EXTENSION), $allowed_exs)) {
                            $response = array(
                                'status' => 'error',
                                'msg' => 'Ekstensi Foto Pegawai Tidak Sesuai'
                            );

                            $response = array(
                                'status' => 'success',
                                'msg' => 'Berhasil Mengubah Data'
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
                        } else {
                            # crating upload path on root directory
                            $img_upload_path_peg = "../images/pegawai/foto_pegawai/" . $_POST['img_file_peg'];
                            $img_upload_path_ktp = "../images/pegawai/foto_ktp/" . $_POST['img_file_ktp'];


                            $img_upload_path_peg_old = "../images/pegawai/foto_pegawai/" . $_POST['img_file_peg_old'];
                            $img_upload_path_ktp_old = "../images/pegawai/foto_ktp/" . $_POST['img_file_ktp_old'];

                            // hapus foto lama
                            if(file_exists($img_upload_path_peg_old)){
                                unlink($img_upload_path_peg_old);
                            }
                            if(file_exists($img_upload_path_ktp_old)){
                                unlink($img_upload_path_ktp_old);
                            }

                            # move uploaded image to 'uploads' folder
                            move_uploaded_file($tmppeg_name, $img_upload_path_peg);
                            move_uploaded_file($tmpktp_name, $img_upload_path_ktp);

                            // echo $_POST['query'];

                            $crud->execute($_POST['query']);
                            $response = array(
                                'status' => 'success',
                                'msg' => 'Berhasil Mengubah Data'
                            );
                            echo json_encode($response);
                            exit();
                        }
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'msg' => 'Gagal Mengubah Data'
                    );
                    echo json_encode($response);
                    exit();
                }
            } else if ($_POST['opsifoto'] == 'fotopegawai-dan-kk') {

                $imgpeg_name = $_FILES['image_peg']['name'];
                $imgpeg_size = $_FILES['image_peg']['size'];
                $tmppeg_name = $_FILES['image_peg']['tmp_name'];
                $errorpeg    = $_FILES['image_peg']['error'];

                // img kk
                $imgkk_name = $_FILES['image_kk']['name'];
                $imgkk_size = $_FILES['image_kk']['size'];
                $tmpkk_name = $_FILES['image_kk']['tmp_name'];
                $errorkk    = $_FILES['image_kk']['error'];


                if ($errorpeg === 0 || $errorkk === 0) {
                    if ($imgpeg_size > 2000000) {
                        $response = array(
                            'status' => 'error',
                            'msg' => 'File Foto Pegawai Terlalu Besar'
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

                            $response = array(
                                'status' => 'success',
                                'msg' => 'Berhasil Mengubah Data'
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
                            $img_upload_path_kk = "../images/pegawai/foto_kk/" . $_POST['img_file_kk'];

                            $img_upload_path_peg_old = "../images/pegawai/foto_pegawai/" . $_POST['img_file_peg_old'];
                            $img_upload_path_kk_old = "../images/pegawai/foto_kk/" . $_POST['img_file_kk_old'];

                            // hapus foto lama
                            if(file_exists($img_upload_path_peg_old)){
                                unlink($img_upload_path_peg_old);
                            }
                            if(file_exists($img_upload_path_kk_old)){
                                unlink($img_upload_path_kk_old);
                            }

                            # move uploaded image to 'uploads' folder
                            move_uploaded_file($tmppeg_name, $img_upload_path_peg);
                            move_uploaded_file($tmpkk_name, $img_upload_path_kk);
                            // echo $_POST['query'];

                            $crud->execute($_POST['query']);
                            $response = array(
                                'status' => 'success',
                                'msg' => 'Berhasil Mengubah Data'
                            );
                            echo json_encode($response);
                            exit();
                        }
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'msg' => 'Gagal Mengubah Data'
                    );
                    echo json_encode($response);
                    exit();
                }
            } else if ($_POST['opsifoto'] == 'fotopegawai') {
                $imgpeg_name = $_FILES['image_peg']['name'];
                $imgpeg_size = $_FILES['image_peg']['size'];
                $tmppeg_name = $_FILES['image_peg']['tmp_name'];
                $errorpeg    = $_FILES['image_peg']['error'];



                if ($errorpeg === 0) {
                    if ($imgpeg_size > 2000000) {
                        $response = array(
                            'status' => 'error',
                            'msg' => 'File Foto Pegawai Terlalu Besar'
                        );
                        echo json_encode($response);
                        exit();
                    } else {

                        if (!in_array(pathinfo($imgpeg_name, PATHINFO_EXTENSION), $allowed_exs)) {
                            $response = array(
                                'status' => 'error',
                                'msg' => 'Ekstensi Foto Pegawai Tidak Sesuai'
                            );

                            $response = array(
                                'status' => 'success',
                                'msg' => 'Berhasil Mengubah Data'
                            );
                            echo json_encode($response);
                            exit();
                        } else {
                            # crating upload path on root directory
                            $img_upload_path_peg = "../images/pegawai/foto_pegawai/" . $_POST['img_file_peg'];

                            $img_upload_path_peg_old = "../images/pegawai/foto_pegawai/" . $_POST['img_file_peg_old'];

                            // hapus foto lama
                            if(file_exists($img_upload_path_peg_old)){
                                unlink($img_upload_path_peg_old);
                            }

                            # move uploaded image to 'uploads' folder
                            move_uploaded_file($tmppeg_name, $img_upload_path_peg);

                            // echo $_POST['query'];

                            $crud->execute($_POST['query']);
                            $response = array(
                                'status' => 'success',
                                'msg' => 'Berhasil Mengubah Data'
                            );
                            echo json_encode($response);
                            exit();
                        }
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'msg' => 'Gagal Mengubah Data'
                    );
                    echo json_encode($response);
                    exit();
                }
            } else if ($_POST['opsifoto'] == 'fotoktp-dan-kk') {
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


                if ($errorktp === 0 || $errorkk === 0) {
                    if ($imgktp_size > 2000000) {
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
                        if (!in_array(pathinfo($imgktp_name, PATHINFO_EXTENSION), $allowed_exs)) {
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
                            $img_upload_path_ktp = "../images/pegawai/foto_ktp/" . $_POST['img_file_ktp'];
                            $img_upload_path_kk = "../images/pegawai/foto_kk/" . $_POST['img_file_kk'];

                            $img_upload_path_ktp_old = "../images/pegawai/foto_ktp/" . $_POST['img_file_ktp_old'];
                            $img_upload_path_kk_old = "../images/pegawai/foto_kk/" . $_POST['img_file_kk_old'];

                            // hapus foto lama
                            if(file_exists($img_upload_path_ktp_old)){
                                unlink($img_upload_path_ktp_old);
                            }
                            if(file_exists($img_upload_path_kk_old)){
                                unlink($img_upload_path_kk_old);
                            }

                            # move uploaded image to 'uploads' folder
                            move_uploaded_file($tmpktp_name, $img_upload_path_ktp);
                            move_uploaded_file($tmpkk_name, $img_upload_path_kk);
                            // echo $_POST['query'];

                            $crud->execute($_POST['query']);
                            $response = array(
                                'status' => 'success',
                                'msg' => 'Berhasil Mengubah Data'
                            );
                            echo json_encode($response);
                            exit();
                        }
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'msg' => 'Gagal Mengubah Data'
                    );
                    echo json_encode($response);
                    exit();
                }
            } else if ($_POST['opsifoto'] == 'fotoktp') {
                // img ktp
                $imgktp_name = $_FILES['image_ktp']['name'];
                $imgktp_size = $_FILES['image_ktp']['size'];
                $tmpktp_name = $_FILES['image_ktp']['tmp_name'];
                $errorktp    = $_FILES['image_ktp']['error'];

                if ($errorktp === 0) {
                    if ($imgktp_size > 2000000) {
                        $response = array(
                            'status' => 'error',
                            'msg' => 'File Foto KTP Terlalu Besar'
                        );
                        echo json_encode($response);
                        exit();
                    } else {
                        if (!in_array(pathinfo($imgktp_name, PATHINFO_EXTENSION), $allowed_exs)) {
                            $response = array(
                                'status' => 'error',
                                'msg' => 'Ekstensi Foto KTP Tidak Sesuai'
                            );
                            echo json_encode($response);
                            exit();
                        } else {
                            # crating upload path on root directory
                            $img_upload_path_ktp = "../images/pegawai/foto_ktp/" . $_POST['img_file_ktp'];

                            $img_upload_path_ktp_old = "../images/pegawai/foto_ktp/" . $_POST['img_file_ktp_old'];

                            // hapus foto lama
                            if(file_exists($img_upload_path_ktp_old)){
                                unlink($img_upload_path_ktp_old);
                            }

                            # move uploaded image to 'uploads' folder
                            move_uploaded_file($tmpktp_name, $img_upload_path_ktp);
                            // echo $_POST['query'];

                            $crud->execute($_POST['query']);
                            $response = array(
                                'status' => 'success',
                                'msg' => 'Berhasil Mengubah Data'
                            );
                            echo json_encode($response);
                            exit();
                        }
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'msg' => 'Gagal Mengubah Data'
                    );
                    echo json_encode($response);
                    exit();
                }
            } else if ($_POST['opsifoto'] == 'fotokk') {

                // img kk
                $imgkk_name = $_FILES['image_kk']['name'];
                $imgkk_size = $_FILES['image_kk']['size'];
                $tmpkk_name = $_FILES['image_kk']['tmp_name'];
                $errorkk    = $_FILES['image_kk']['error'];


                if ($errorkk === 0) {
                    if ($imgkk_size > 2000000) {
                        $response = array(
                            'status' => 'error',
                            'msg' => 'File Foto KK Terlalu Besar'
                        );
                        echo json_encode($response);
                        exit();
                    } else {
                        if (!in_array(pathinfo($imgkk_name, PATHINFO_EXTENSION), $allowed_exs)) {
                            $response = array(
                                'status' => 'error',
                                'msg' => 'Ekstensi Foto KK Tidak Sesuai'
                            );
                            echo json_encode($response);
                            exit();
                        } else {
                            # crating upload path on root directory
                            $img_upload_path_kk = "../images/pegawai/foto_kk/" . $_POST['img_file_kk'];

                            $img_upload_path_kk_old = "../images/pegawai/foto_kk/" . $_POST['img_file_kk_old'];

                            // hapus foto lama
                            if(file_exists($img_upload_path_kk_old)){
                                unlink($img_upload_path_kk_old);
                            }

                            # move uploaded image to 'uploads' folder
                            move_uploaded_file($tmpkk_name, $img_upload_path_kk);
                            // echo $_POST['query'];

                            $crud->execute($_POST['query']);
                            $response = array(
                                'status' => 'success',
                                'msg' => 'Berhasil Mengubah Data'
                            );
                            echo json_encode($response);
                            exit();
                        }
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'msg' => 'Gagal Mengubah Data'
                    );
                    echo json_encode($response);
                    exit();
                }
            } else if ($_POST['opsifoto'] == 'semua-foto') {
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

                            $response = array(
                                'status' => 'success',
                                'msg' => 'Berhasil Mengubah Data'
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

                            $img_upload_path_peg_old = "../images/pegawai/foto_pegawai/" . $_POST['img_file_peg_old'];
                            $img_upload_path_ktp_old = "../images/pegawai/foto_ktp/" . $_POST['img_file_ktp_old'];
                            $img_upload_path_kk_old = "../images/pegawai/foto_kk/" . $_POST['img_file_kk_old'];

                            // hapus foto lama
                            if(file_exists($img_upload_path_peg_old)){
                                unlink($img_upload_path_peg_old);
                            }
                            if(file_exists($img_upload_path_ktp_old)){
                                unlink($img_upload_path_ktp_old);
                            }
                            if(file_exists($img_upload_path_kk_old)){
                                unlink($img_upload_path_kk_old);
                            }

                            # move uploaded image to 'uploads' folder
                            move_uploaded_file($tmppeg_name, $img_upload_path_peg);
                            move_uploaded_file($tmpktp_name, $img_upload_path_ktp);
                            move_uploaded_file($tmpkk_name, $img_upload_path_kk);
                            // echo $_POST['query'];

                            $crud->execute($_POST['query']);
                            $response = array(
                                'status' => 'success',
                                'msg' => 'Berhasil Mengubah Data'
                            );
                            echo json_encode($response);
                            exit();
                        }
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'msg' => 'Gagal Mengubah Data'
                    );
                    echo json_encode($response);
                    exit();
                }
            }
        } else if ($_POST['type'] == 'ubah_password_pegawai') {
            $crud->execute($_POST['query']);
            $response = array(
                'status' => 'success',
                'msg' => 'Berhasil Mengubah Password'
            );
            echo json_encode($response);
            exit();
        } else if ($_POST['type'] == 'hapus_pegawai') {



            $img_upload_path_peg_old = "../images/pegawai/foto_pegawai/" . $_POST['pathfotopegawai'];
            $img_upload_path_ktp_old = "../images/pegawai/foto_ktp/" . $_POST['pathfotoktp'];
            $img_upload_path_kk_old = "../images/pegawai/foto_kk/" . $_POST['pathfotokk'];

            // hapus foto lama

            if(file_exists($img_upload_path_peg_old)){
                unlink($img_upload_path_peg_old);
            }
            if(file_exists($img_upload_path_ktp_old)){
                unlink($img_upload_path_ktp_old);
            }
            if(file_exists($img_upload_path_kk_old)){
                unlink($img_upload_path_kk_old);
            }

            $crud->execute($_POST['query']);
            $response = array(
                'status' => 'success',
                'msg' => 'Berhasil Hapus Data'
            );
            echo json_encode($response);
            exit();
        }
    }

    // if (isset($_FILES['my_image'])) {
    //   echo $_POST['img_file'];
    //   echo $_POST['query'];
    //   var_dump($_FILES['my_image']);
    // }
}

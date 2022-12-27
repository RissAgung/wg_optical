<?php include '../config/koneksi.php';
$kon = new Koneksi();

$api_key = 'aoi12j1h7dwgopticalw1dggwuawdki';

if (isset($_POST['apikey'])) {
    if ($_POST['apikey'] == $api_key) {
        $email = $_POST['txt_email'];
        $password = $_POST['txt_password'];

        $query = "SELECT * FROM pegawai WHERE email = '$email'";
        $result = $kon->execute($query);
        $num = mysqli_num_rows($result);

        while ($row = mysqli_fetch_array($result)) {
            $idpeg = $row['id_pegawai'];
            $nama = $row['nama'];
            $emailval = $row['email'];
            $passwordval = $row['password'];
            $alamat = $row['alamat'];
            $nohp = $row['no.Telp'];
            $urlFoto = $row['foto_pegawai'];
            $idlevelval = $row['id_level'];
        }
        if ($num != 0) {
            if ($emailval == $email && $passwordval == md5($password)) {

                if ($idlevelval == 3) {
                    $response = array(
                        'status' => 'success',
                        'msg' => 'Login Berhasil',
                        'data' => array(
                            'id_pegawai' => $idpeg,
                            'nama' => $nama,
                            'alamat' => $alamat,
                            'notelepon' => $nohp,
                            'urlFoto' => $urlFoto,
                        ),
                    );
                    echo json_encode($response);
                    exit();
                } else {

                    $response = array(
                        'status' => 'error',
                        'msg' => 'Login hanya untuk sales'
                    );
                    echo json_encode($response);
                    exit();
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'msg' => 'Email atau password salah'
                );
                echo json_encode($response);
                exit();
            }
        } else {
            $response = array(
                'status' => 'error',
                'msg' => 'User tidak ditemukan'
            );
            echo json_encode($response);
            exit();
        }
    }
}

<?php include '../config/koneksi.php';

session_start();

$kon = new Koneksi();

if (isset($_POST['type'])) {
    if ($_POST['type'] == 'login') {

        $email = $_POST['txt_email'];
        $password = $_POST['txt_password'];

        $query = "SELECT * FROM pegawai WHERE email = '$email'";
        $result = $kon->execute($query);
        $num = mysqli_num_rows($result);

        while ($row = mysqli_fetch_array($result)) {
            $namaval = $row['nama'];
            $emailval = $row['email'];
            $passwordval = $row['password'];
            $idlevelval = $row['id_level'];
        }

        if ($num != 0) {
            if ($emailval == $email && $passwordval == md5($password)) {

                if ($idlevelval == 3) {
                    $response = array(
                        'status' => 'success_roles',
                        'msg' => 'Anda Login Sebagai Sales'
                    );
                    echo json_encode($response);
                    exit();
                } else {

                    $response = array(
                        'status' => 'success',
                        'msg' => 'Login Berhasil'
                    );
                    echo json_encode($response);
                    $_SESSION["statusLogin"] = "true";
                    $_SESSION["email"] = $namaval;
                    $_SESSION['level'] = $idlevelval;
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
    } else if ($_POST['type'] == 'logout') {
        session_destroy();
    }
}

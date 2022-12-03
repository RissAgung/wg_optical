<?php include '../config/koneksi.php';

$kon = new Koneksi();

if (isset($_POST['type'])) {
    $email = $_POST['txt_email'];
    $password = $_POST['txt_password'];

    $query = "SELECT * FROM pegawai WHERE email = '$email'";
    $result = $kon->execute($query);
    $num = mysqli_num_rows($result);

    while ($row = mysqli_fetch_array($result)) {
        $emailval = $row['email'];
        $passwordval = $row['password'];
    }

    if ($num != 0) {
        if ($emailval == $email && $passwordval == md5($password)) {
            $response = array(
                'status' => 'success',
                'msg' => 'Login Berhasil'
            );
            echo json_encode($response);
            exit();
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

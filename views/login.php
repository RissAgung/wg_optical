<?php require('../config/koneksi.php');
require('../config/query.php');


$_crud = new crud();


if (isset($_POST['login'])) {
    $email = $_POST['txt_email'];
    $password = $_POST['txt_password'];

    $query = "SELECT * FROM pegawai WHERE email = '$email'";
    $result = $_crud->execute($query);
    $num = mysqli_num_rows($result);

    while ($row = mysqli_fetch_array($result)) {
        $emailval = $row['email'];
        $passwordval = $row['password'];
    }

    if ($num != 0) {
        if ($emailval == $email && $passwordval == md5($password)) {
            header('Location: dashboard.php');
        } else {
            $error = 'Email atau password salah';
            header('Location: login.php?error='.$error);
        }
    } else {
        $error = 'User tidak ditemukan';
        header('Location: login.php?error='.$error);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WG Optical | Login Page</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/sweetalert2.min.css">
</head>

<body class="bg-[#171A23]">
    <section id="navbar">
        <header class="">
            <div class="w-full z-[9999] fixed bg-[#171A23]">
                <div class="flex justify-between px-12 my-6 relative">
                    <a href="index.html"><span class="text-white">WG <span class="font-bold">Optical</span></span></a>

                    <button name="menuu" id="menuu" type="button" class="flex flex-col md:hidden">
                        <span class="menu-line transition duration-500 ease-in-out origin-bottom-left"></span>
                        <span class="menu-line transition duration-500 ease-in-out"></span>
                        <span class="menu-line transition duration-500 ease-in-out origin-top-left"></span>
                    </button>

                    <nav id="showmenu" class="absolute top-14 right-8 px-4 py-5 bg-[#171A23] border-2 rounded-lg shadow-lg md:shadow-none max-w-[250px] w-full hidden md:py-0 md:w-3/4 md:block md:max-w-full md:static md:border-none md:bg-transparent">
                        <ul class="block md:flex md:gap-4 md:justify-end">
                            <li class="group">
                                <a href="login.html"><button class="text-white font-semibold px-4 py-2 bg-transparent md:bg-white md:text-black md:rounded-lg">Login</button></a>
                            </li>
                            <li class="group">
                                <a href="tracking.html"><button class="text-white font-semibold px-4 py-2 hover:bg-slate-700 hover:rounded-lg">Cari</button></a>
                            </li>
                            <li class="group">
                                <a href="index.html"><button class="py-2 text-white font-semibold px-4 hover:bg-slate-700 hover:rounded-lg">Home</button></a>
                            </li>
                        </ul>

                    </nav>

                </div>
            </div>
        </header>

    </section>

    <div class="flex flex-wrap w-full">
        <div class="w-full md:w-[60%]">
            <div class="flex flex-col pt-40 items-center md:items-start px-12 md:px-24 lg:px-32 md:pt-52 xl:px-44">
                <h1 class="text-white text-4xl lg:text-5xl text-center md:text-start font-bold">Welcome to</h1>
                <h1 class="text-white text-4xl lg:text-5xl text-center md:text-start font-semibold mb-8">Waluyo Group Optical
                </h1>
                <p class="text-white text-center md:text-start">Masukkan email dan password anda untuk login</p>
            </div>
        </div>

        <div class="w-full md:w-[40%]">
            <div class="flex flex-col mt-12 md:mt-48 items-center px-12">
                <form action="login.php" method="POST">
                    <input name="txt_email" class="w-full rounded-lg md:w-[100%] lg:w-[70%] h-[50px] px-4 border-none mb-6" placeholder="Email" type="text">
                    <input name="txt_password" class="w-full rounded-lg md:w-[100%] lg:w-[70%] h-[50px] px-4 border-none" placeholder="Password" type="password">
                    <div class="w-full md:w-[100%] lg:w-[70%] py-4 px-4">

                    </div>

                    <button type="submit" name="login" class="w-full mb-32 md:w-[100%] lg:w-[70%] py-4 px-4 bg-[#3E5FC1] rounded-lg">
                        <p class="text-white font-semibold text-center">LOGIN</p>
                    </button>

                </form>
            </div>
        </div>
    </div>
    <script src="../js/script.js"></script>
    <script src="../js/sweetalert2.min.js"></script>
    <?php if(isset($_GET['error'])){ ?><script>
        Swal.fire(
            'Gagal',
            '<?php echo $_GET['error']; ?>',
            'error'
        ).then((result)=> {
            location.replace('login.php');
        });
    </script><?php } ?>


</body>

</html>
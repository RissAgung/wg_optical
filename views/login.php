<?php
date_default_timezone_set("Asia/Bangkok");
session_start();
if (isset($_SESSION['statusLogin'])) {
    header('Location: dashboard.php');
}

echo '<script>Swal.fire({
    icon: "error",
    title: "Gagal",
    text: "aa",
});</script>';
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
                                <a href="login.php"><button class="text-white font-semibold px-4 py-2 bg-transparent md:bg-white md:text-black md:rounded-lg">Login</button></a>
                            </li>
                            <li class="group">
                                <a href="tracking.html"><button class="text-white font-semibold px-4 py-2 hover:bg-slate-700 hover:rounded-lg">Cari</button></a>
                            </li>
                            <li class="group">
                                <a href="index.php"><button class="py-2 text-white font-semibold px-4 hover:bg-slate-700 hover:rounded-lg">Home</button></a>
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

        <div class="w-full px-12 md:w-[40%] lg:w-[30%]">
            <div class="flex flex-col mt-12 md:mt-48 items-center px-0">
                <input id="txt_email" name="txt_email" class="w-full rounded-lg h-[50px] px-4 border-none mb-6" placeholder="Email" type="text">
                <div class="relative flex w-full rounded-lg ">
                    <div id="buttonShowHide" onclick="changeHide()" class="absolute right-0 h-full px-4">
                        <svg class="h-full" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 9C11.206 9.00524 10.4459 9.32299 9.88447 9.88447C9.32299 10.4459 9.00524 11.206 9 12C9 13.642 10.358 15 12 15C13.641 15 15 13.642 15 12C15 10.359 13.641 9 12 9Z" fill="black" />
                            <path d="M11.9998 5C4.3668 5 2.0728 11.617 2.0518 11.684L1.9458 12L2.0508 12.316C2.0728 12.383 4.3668 19 11.9998 19C19.6328 19 21.9268 12.383 21.9478 12.316L22.0538 12L21.9488 11.684C21.9268 11.617 19.6328 5 11.9998 5ZM11.9998 17C6.6488 17 4.5758 13.154 4.0738 12C4.5778 10.842 6.6518 7 11.9998 7C17.3508 7 19.4238 10.846 19.9258 12C19.4218 13.158 17.3478 17 11.9998 17V17Z" fill="black" />
                        </svg>
                    </div>
                    <input id="txt_password" name="txt_password" class="pr-16 w-full rounded-lg h-[50px] px-4 border-none" placeholder="Password" type="password">
                </div>
                <div class="py-4 px-4">
                </div>
                <button id="login" type="button" name="login" class="w-full mb-32 py-4 px-4 bg-[#3E5FC1] rounded-lg">
                    <p class="text-white font-semibold text-center">LOGIN</p>
                </button>

            </div>
        </div>
    </div>
    <script src="../js/script.js"></script>
    <script src="../js/sweetalert2.min.js"></script>
    <script src="../js/jquery-3.6.1.min.js"></script>

    <script>
        function changeHide() {
            var type = $('#txt_password').attr('type') == 'password' ? 'text' : 'password';
            $('#txt_password').attr('type', type);
            if (type == 'password') {
                $('#buttonShowHide').html('<svg class="h-full" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 9C11.206 9.00524 10.4459 9.32299 9.88447 9.88447C9.32299 10.4459 9.00524 11.206 9 12C9 13.642 10.358 15 12 15C13.641 15 15 13.642 15 12C15 10.359 13.641 9 12 9Z" fill="black" /><path d="M11.9998 5C4.3668 5 2.0728 11.617 2.0518 11.684L1.9458 12L2.0508 12.316C2.0728 12.383 4.3668 19 11.9998 19C19.6328 19 21.9268 12.383 21.9478 12.316L22.0538 12L21.9488 11.684C21.9268 11.617 19.6328 5 11.9998 5ZM11.9998 17C6.6488 17 4.5758 13.154 4.0738 12C4.5778 10.842 6.6518 7 11.9998 7C17.3508 7 19.4238 10.846 19.9258 12C19.4218 13.158 17.3478 17 11.9998 17V17Z" fill="black" /></svg>');
            } else {
                $('#buttonShowHide').html('<svg class="h-full" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1435_5)"><path d="M12.2465 7.44666C11.707 7.44729 11.1719 7.54437 10.6665 7.73332L16.5332 13.6C16.7246 13.0884 16.8218 12.5463 16.8198 12C16.8145 10.7905 16.3304 9.63242 15.4733 8.77908C14.6162 7.92573 13.456 7.44664 12.2465 7.44666V7.44666Z" fill="black"/><path d="M22.8598 11.6867C20.6132 7.53335 16.6732 5.02002 12.3132 5.02002C11.1261 5.02281 9.94693 5.21408 8.81982 5.58669L9.89316 6.66669C10.6837 6.46237 11.4966 6.35712 12.3132 6.35335C16.0665 6.35335 19.4798 8.44669 21.5132 11.9734C20.7673 13.2818 19.7785 14.4357 18.5998 15.3734L19.5465 16.32C20.9105 15.2196 22.0434 13.8601 22.8798 12.32L23.0532 12L22.8598 11.6867Z" fill="black"/><path d="M3.24643 3.85332L6.21976 6.82665C4.34037 8.03673 2.80436 9.7105 1.75976 11.6867L1.58643 12L1.75976 12.32C4.00643 16.4733 7.94642 18.9867 12.3064 18.9867C14.0082 18.9863 15.6879 18.6011 17.2198 17.86L20.5531 21.1933L21.7198 20.1933L4.38643 2.85999L3.24643 3.85332ZM8.77976 9.38665C8.15605 10.2663 7.86371 11.3382 7.9545 12.4126C8.0453 13.4871 8.51336 14.4948 9.27583 15.2572C10.0383 16.0197 11.046 16.4878 12.1204 16.5786C13.1949 16.6694 14.2668 16.377 15.1464 15.7533L16.2131 16.82C14.9783 17.3478 13.6493 17.62 12.3064 17.62C8.55309 17.62 5.13976 15.5267 3.10643 12C4.08223 10.2721 5.48758 8.82545 7.18643 7.79998L8.77976 9.38665Z" fill="black"/></g><defs><clipPath id="clip0_1435_5"><rect width="24" height="24" fill="white"/></clipPath></defs></svg>');
            }
        }

        $('#login').on('click', function() {

            $.ajax({
                type: "post",
                url: "../controllers/salaryController.php",
                data: {
                    type: "salary",
                },
                success: function(res) {
                    $.ajax({
                        url: '../controllers/loginController.php',
                        type: 'post',
                        data: {
                            'type': 'login',
                            'txt_email': $('#txt_email').val(),
                            'txt_password': $('#txt_password').val(),
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Loading',
                                html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
                                allowOutsideClick: false,
                                showConfirmButton: false,

                            });
                        },
                        success: function(res) {
                            const data = JSON.parse(res);
                            if (data.status == 'error') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.msg,
                                });
                            } else if (data.status == 'success_roles') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: data.msg,
                                }).then(function() {
                                    window.location.replace("../sales/dashboard.php");
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: data.msg,
                                }).then(function() {
                                    window.location.replace("dashboard.php");
                                });
                            }
                        }
                    });
                }
            });

        });
    </script>

    <?php if (isset($_GET['error'])) { ?><script>
            Swal.fire(
                'Gagal',
                '<?php echo $_GET['error']; ?>',
                'error'
            ).then((result) => {
                location.replace('login.php');
            });
        </script><?php } ?>


</body>

</html>
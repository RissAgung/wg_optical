<?php
include '../../config/koneksi.php';
session_start();
$level = $_SESSION["level"];
$crud = new koneksi();
$res = $crud->showData("SELECT COUNT(*) as count FROM transaksi WHERE status_confirm = 1");
foreach ($res as $value) {
    $count = $value['count'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/output copy.css">
    <link rel="stylesheet" href="../css/sweetalert2.min.css">
    <title>Document</title>
</head>

<body>
    <div class="overflow-y-scroll scrollbar-hide flex flex-col h-screen w-72 bg-[#343948] px-5 pt-10 pb-12">

        <!-- Header -->
        <div>
            <h1 class="font-ex-extrabold text-white ml-6"><span class="text-[#F9511C]">WG </span>OPTICAL</h1>

        </div>
        <!-- End Header -->

        <!-- Menu -->
        <div class="h-full flex flex-col justify-between uppercase font-ex-bold text-white mt-12">

            <!-- atas -->
            <div class="flex flex-col">
                <!-- dashboard -->
                <a href="../views/dashboard.php">
                    <div id="dashboard" class="cursor-pointer ex-hover-sidebar h-14 flex flex-row items-center justify-start rounded-lg px-5">
                        <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.5138 18H9.17431V12H16.5138V18ZM7.33945 18H0V8H7.33945V18ZM16.5138 10H9.17431V0H16.5138V10ZM7.33945 6H0V0H7.33945V6Z" fill="white" />
                        </svg>

                        <h2 class="ml-3">dashboard</h2>
                    </div>
                </a>
                <!-- end dashboard -->

                <!-- Master -->
                <!-- <a href="../views/master_product.php">
                </a> -->
                <div id="master_data" class="cursor-pointer ex-hover-sidebar h-14 flex flex-col items-start justify-center rounded-lg px-5">
                    <div id="masterdatamain" class="h-[50px] w-full">
                        <div class="flex flex-row w-full py-3 mt-2 justify-between">
                            <div class="flex flex-row">

                                <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0H16.5138V4H0V0ZM14.0367 5H0.825688V16C0.825688 16.5304 0.999672 17.0391 1.30936 17.4142C1.61906 17.7893 2.03909 18 2.47706 18H14.0367C14.4747 18 14.8947 17.7893 15.2044 17.4142C15.5141 17.0391 15.6881 16.5304 15.6881 16V5H14.0367ZM11.5596 11H4.95413V9H11.5596V11Z" fill="white" />
                                </svg>
                                <h2 class="ml-3">master data</h2>
                            </div>
                            <div id="dropdownicon" class="flex items-center transition duration-[0.5s] mr-2">
                                <svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.5 10L0.870834 0.25L12.1292 0.25L6.5 10Z" fill="white" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 y-8 w-full h-full overflow-hidden">
                        <div id="dropdown-msbarang" class="h-11 items-start flex flex-col transitionsidebar">
                            <div id="msbarangmain" class=" w-full py-3">
                                <div class="flex flex-row justify-between">
                                    <h2 class="ml-8">Barang</h2>
                                    <div id="dropdownicon1" class="flex items-center transition duration-[0.5s] mr-2">
                                        <svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.5 10L0.870834 0.25L12.1292 0.25L6.5 10Z" fill="white" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="y-8 w-full h-full overflow-hidden">
                                <div class=" h-10 items-center flex">

                                    <a href="../views/master_product.php" class="ml-14">PRODUK</a>
                                </div>
                                <div class=" h-10 items-center flex">
                                    <a href="../views/master_product_tambahan.php" class="ml-14">TAMBAHAN</a>
                                    <!-- <h2 class="ml-14">TAMBAHAN</h2> -->
                                </div>
                                <div class=" h-10 items-center flex">
                                    <a href="../views/master_barang_perlengkapan.php" class="ml-14">PERLENGKAPAN</a>
                                    <!-- <h2 class="ml-14">PERLENGKAPAN</h2> -->
                                </div>

                            </div>
                        </div>
                        <div class="h-10 items-center flex">
                            <a href="../views/master_supplier.php" class="ml-8">Supplier</a>
                        </div>
                        <div class="h-10 items-center flex">
                            <a href="../views/master_pegawai.php" class="ml-8">Pegawai</a>
                        </div>

                    </div>

                </div>




                <!-- end Master -->

                <!-- invoice -->
                <a href="../views/invoice.php">
                    <div class="cursor-pointer ex-hover-sidebar h-14 flex flex-row items-center justify-start rounded-lg px-5 relative" id="tab_invoice">
                        <?php if ($count != 0) : ?>
                            <div class="bg-red-600 right-3 px-4 py-1 rounded-lg absolute scale-[80%]">
                                <h1><?= $count; ?></h1>
                            </div>
                        <?php endif; ?>
                        <svg width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.4325 10.3726V11.6765H8.89192V10.3726H11.4325ZM11.4325 7.78418V9.07513H8.89192V7.78418H11.4325ZM7.62163 7.78418H5.08105V9.07513H7.62163V7.78418ZM7.62163 10.3726H5.08105V11.6765H7.62163V10.3726Z" fill="white" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.94615C0 1.43 0.200751 0.93499 0.558089 0.570015C0.915427 0.205041 1.40008 0 1.90543 0L12.3307 0L16.5138 4.27246V17.5154C16.5138 18.0315 16.313 18.5265 15.9557 18.8915C15.5983 19.2565 15.1137 19.4615 14.6083 19.4615H1.90543C1.40008 19.4615 0.915427 19.2565 0.558089 18.8915C0.200751 18.5265 0 18.0315 0 17.5154V1.94615ZM3.81087 5.18974H7.62174V3.89231H3.81087V5.18974ZM12.7029 6.48718H3.81087V12.9744H12.7029V6.48718ZM12.7029 15.5692H8.89202V14.2718H12.7029V15.5692Z" fill="white" />
                        </svg>
                        <p class="ml-3">invoice</p>
                    </div>
                </a>
                <!-- end invoice -->

                <!-- riwayat -->
                <a href="../views/riwayat.php">
                    <div id="riwayat" class="cursor-pointer ex-hover-sidebar h-14 flex flex-row items-center justify-start rounded-lg px-5">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.91277 0C7.46667 0.00719098 5.10754 0.908165 3.27938 2.53336L2.16853 1.42251C2.05199 1.306 1.90352 1.22666 1.74189 1.19452C1.58026 1.16238 1.41273 1.17889 1.26048 1.24195C1.10823 1.30501 0.978091 1.41179 0.88652 1.5488C0.794949 1.68581 0.746056 1.84689 0.74602 2.01169V5.83339C0.74602 6.0544 0.833818 6.26637 0.9901 6.42265C1.14638 6.57893 1.35835 6.66673 1.57936 6.66673H5.40106C5.56586 6.66669 5.72694 6.6178 5.86395 6.52623C6.00096 6.43466 6.10774 6.30452 6.1708 6.15227C6.23386 6.00002 6.25036 5.83249 6.21822 5.67086C6.18608 5.50923 6.10674 5.36076 5.99024 5.24421L5.04439 4.29837C6.14815 3.35548 7.50182 2.75317 8.94118 2.56451C10.3805 2.37586 11.8437 2.60896 13.1532 3.23556C14.4626 3.86215 15.5621 4.85529 16.3183 6.09449C17.0744 7.33369 17.4546 8.7657 17.4128 10.2168C17.3592 12.0917 16.6051 13.8784 15.299 15.2247C13.993 16.571 12.2299 17.379 10.3575 17.4895C8.48512 17.5999 6.63927 17.0048 5.18402 15.8214C3.72876 14.6381 2.76972 12.9524 2.49604 11.0968C2.45696 10.7951 2.30989 10.5177 2.08207 10.3161C1.85424 10.1145 1.56108 10.0022 1.25686 10.0001C1.08033 9.99781 0.905342 10.0332 0.743592 10.104C0.581841 10.1747 0.43705 10.2792 0.318891 10.4104C0.200731 10.5415 0.111923 10.6964 0.0583993 10.8646C0.00487553 11.0329 -0.0121317 11.2106 0.00851361 11.3859C0.355359 13.8409 1.60052 16.08 3.50304 17.6699C5.40557 19.2598 7.83021 20.0874 10.3078 19.9927C12.8142 19.8719 15.1859 18.822 16.9603 17.0476C18.7347 15.2732 19.7846 12.9016 19.9054 10.3951C19.957 9.05001 19.7369 7.70833 19.2581 6.45028C18.7794 5.19223 18.0518 4.04365 17.1189 3.07323C16.1861 2.10281 15.0671 1.33049 13.829 0.80244C12.5908 0.274394 11.2588 0.00147359 9.91277 0V0Z" fill="white" />
                            <path d="M9.49611 5.83301C9.16458 5.83301 8.84664 5.9647 8.61221 6.19913C8.37779 6.43355 8.24609 6.7515 8.24609 7.08302V10.6606C8.24619 11.1025 8.42185 11.5264 8.73443 11.8389L10.2286 13.3331C10.4644 13.5608 10.7801 13.6868 11.1079 13.6839C11.4356 13.6811 11.7491 13.5496 11.9809 13.3178C12.2127 13.0861 12.3441 12.7726 12.347 12.4448C12.3498 12.1171 12.2238 11.8013 11.9961 11.5656L10.7461 10.3155V7.08302C10.7461 6.7515 10.6144 6.43355 10.38 6.19913C10.1456 5.9647 9.82763 5.83301 9.49611 5.83301Z" fill="white" />
                        </svg>
                        <h2 class="ml-3">riwayat</h2>
                    </div>
                </a>
                <!-- end riwayat -->

                <!-- salary -->
                <a href="../views/salary.php">
                    <div id="salary" class="ex-hover-sidebar h-14 flex flex-row items-center justify-start rounded-lg px-5">
                        <svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.6108 15.0964C10.8994 15.7985 10.4996 16.7502 10.4996 17.7434V19H11.7726C12.7788 19 13.7431 18.6053 14.4544 17.9032L20.4103 12.0244C21.1951 11.2497 21.1951 9.99227 20.4103 9.21759C19.6254 8.44291 18.3515 8.44291 17.5666 9.21759L11.6108 15.0964V15.0964ZM10.3736 13.8752L14.807 9.5H13.1253C11.9809 9.49482 11.9818 7.77705 13.1253 7.77273H16.6059C17.8038 6.74673 19.6797 6.62582 21 7.49118V4.31818C21 1.93714 19.0375 0 16.6252 0H4.37482C1.96254 0 0 1.93714 0 4.31818V12.9545C0 15.3356 1.96254 17.2727 4.37482 17.2727H8.77326C8.88351 15.9894 9.43998 14.7967 10.3736 13.8752V13.8752ZM13.1253 4.31818H16.6252C17.7696 4.32336 17.7688 6.04114 16.6252 6.04545H13.1253C11.9809 6.04027 11.9818 4.3225 13.1253 4.31818V4.31818ZM6.12475 14.6818C5.64089 14.6818 5.24978 14.2949 5.24978 13.8182V12.9545H5.01529C4.0817 12.9545 3.21024 12.4588 2.74214 11.66C2.49977 11.2471 2.64326 10.7195 3.06062 10.4802C3.48061 10.2401 4.01521 10.3826 4.25582 10.7955C4.41244 11.0615 4.70293 11.2273 5.01442 11.2273H6.99883C7.87117 11.2834 8.26053 9.88864 7.31032 9.70727L4.64956 9.26941C1.58543 8.70891 2.24516 4.30091 5.24891 4.31818V3.45455C5.25416 2.32491 6.99446 2.32577 6.99883 3.45455V4.31818H7.23332C8.16691 4.31818 9.03837 4.81477 9.50648 5.61364C9.74884 6.02645 9.60535 6.55414 9.18799 6.79336C8.76714 7.03173 8.23341 6.89095 7.99279 6.47814C7.83617 6.21127 7.54569 6.04632 7.2342 6.04632H5.24978C4.37744 5.99018 3.98808 7.38495 4.93829 7.56632L7.59906 8.00418C10.6632 8.56468 10.0035 12.9727 6.99971 12.9554V13.819C6.99971 14.2958 6.6086 14.6827 6.12475 14.6827V14.6818Z" fill="white" />
                        </svg>

                        <h2 class="ml-3">salary</h2>
                    </div>
                </a>
                <!-- end salary -->

                <!-- grafik -->
                <a href="../views/grafik_keuangan.php">
                    <div id="grafik_keuangan" class="ex-hover-sidebar h-14 flex flex-row items-center justify-start rounded-lg px-5">
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.6455 11.3457L18.5548 17.255C19.9665 15.5886 20.8215 13.5224 21 11.3457H12.6455Z" fill="white" />
                            <path d="M9.91123 11.0888L9.65453 10.8321V0C8.00379 0.135272 6.40837 0.658648 4.99828 1.52748C3.58818 2.39631 2.40331 3.58601 1.54023 4.99963C0.677143 6.41326 0.160266 8.0108 0.0317153 9.66207C-0.0968352 11.3133 0.166579 12.9716 0.800491 14.5018C1.4344 16.032 2.42088 17.3907 3.67952 18.4673C4.93817 19.5439 6.43338 20.3079 8.04329 20.697C9.65321 21.0861 11.3323 21.0893 12.9437 20.7064C14.5551 20.3235 16.0532 19.5653 17.316 18.4935L9.91123 11.0888Z" fill="white" />
                            <path d="M11.4067 9.59327H21C20.7932 7.11818 19.7161 4.79644 17.9598 3.04019C16.2036 1.28394 13.8818 0.206809 11.4067 0V9.59327Z" fill="white" />
                        </svg>

                        <h2 class="ml-3">grafik</h2>
                    </div>
                </a>
                <!-- end grafik -->

                <!-- Pengeluaran -->
                <a href="../views/tr_pengeluaran.php">
                    <div id="pengeluaran" class="ex-hover-sidebar h-14 flex flex-row items-center justify-start rounded-lg px-5">
                        <svg width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.5 11.7C4.61212 11.7 0 9.1305 0 5.85C0 2.5695 4.61212 0 10.5 0C16.3879 0 21 2.5695 21 5.85C21 9.1305 16.3879 11.7 10.5 11.7ZM14 17.6724C14.9476 17.4915 15.8287 17.2395 16.625 16.9245V12.5325C15.8112 12.8151 14.9292 13.0356 14 13.1976V17.6715V17.6724ZM4.375 16.9245C5.17125 17.2386 6.05237 17.4906 7 17.6724V13.1985C6.07075 13.0365 5.18875 12.816 4.375 12.5334V16.9254V16.9245ZM12.25 13.4262C11.6804 13.473 11.0976 13.5 10.5 13.5C9.90238 13.5 9.31962 13.473 8.75 13.4262V17.9154C9.31962 17.9667 9.90063 18 10.5 18C11.0994 18 11.6804 17.9667 12.25 17.9154V13.4262ZM18.375 11.7738V16.0488C20.0104 15.0201 21 13.6629 21 12.15V9.8883C20.3053 10.6137 19.4093 11.2428 18.375 11.7747V11.7738ZM2.625 11.7738C1.59075 11.2419 0.69475 10.6128 0 9.8874V12.1491C0 13.662 0.989625 15.0201 2.625 16.0479V11.7729V11.7738Z" fill="white"></path>
                        </svg>
                        <h2 class="ml-3">Pengeluaran</h2>
                    </div>
                </a>
                <!-- end pengeluaran -->

                <!-- Setting landing -->
                <?php if ($level == 1) : ?>
                    <a href="../views/setting_landing.php">
                        <div id="setting" class="ex-hover-sidebar h-14 flex flex-row items-center justify-start rounded-lg px-5">
                            <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="21" height="21">
                                <path d="M21,12a9.143,9.143,0,0,0-.15-1.645L23.893,8.6l-3-5.2L17.849,5.159A9,9,0,0,0,15,3.513V0H9V3.513A9,9,0,0,0,6.151,5.159L3.107,3.4l-3,5.2L3.15,10.355a9.1,9.1,0,0,0,0,3.29L.107,15.4l3,5.2,3.044-1.758A9,9,0,0,0,9,20.487V24h6V20.487a9,9,0,0,0,2.849-1.646L20.893,20.6l3-5.2L20.85,13.645A9.143,9.143,0,0,0,21,12Zm-6,0a3,3,0,1,1-3-3A3,3,0,0,1,15,12Z" fill="white" />
                            </svg>
                            <h2 class="ml-3">Setting Landing</h2>
                        </div>
                    </a>
                <?php endif ?>
                <!-- end setting landing -->

            </div>
            <!-- end atas -->

            <!-- bawah -->

            <div id="button-logout" class="ex-hover-sidebar py-14 cursor-pointer h-14 flex flex-row items-center justify-start rounded-lg px-5">
                <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.00003 0C2.20438 0 1.44131 0.316071 0.87869 0.87868C0.316074 1.44129 0 2.20435 0 3V17C0 17.7956 0.316074 18.5587 0.87869 19.1213C1.44131 19.6839 2.20438 20 3.00003 20H9.0001C9.79576 20 10.5588 19.6839 11.1214 19.1213C11.6841 18.5587 12.0001 17.7956 12.0001 17V3C12.0001 2.20435 11.6841 1.44129 11.1214 0.87868C10.5588 0.316071 9.79576 0 9.0001 0H3.00003ZM13.2931 5.293C13.4807 5.10553 13.735 5.00021 14.0002 5.00021C14.2653 5.00021 14.5196 5.10553 14.7072 5.293L18.7072 9.293C18.8947 9.48053 19 9.73484 19 10C19 10.2652 18.8947 10.5195 18.7072 10.707L14.7072 14.707C14.5186 14.8892 14.266 14.99 14.0038 14.9877C13.7416 14.9854 13.4907 14.8802 13.3053 14.6948C13.1199 14.5094 13.0147 14.2586 13.0125 13.9964C13.0102 13.7342 13.111 13.4816 13.2931 13.293L15.5862 11H7.00008C6.73486 11 6.4805 10.8946 6.29296 10.7071C6.10543 10.5196 6.00007 10.2652 6.00007 10C6.00007 9.73478 6.10543 9.48043 6.29296 9.29289C6.4805 9.10536 6.73486 9 7.00008 9H15.5862L13.2931 6.707C13.1057 6.51947 13.0004 6.26516 13.0004 6C13.0004 5.73484 13.1057 5.48053 13.2931 5.293Z" fill="#F0F0F0" />
                </svg>

                <h2 class="ml-3 ">log out</h2>
            </div>

            <!-- end bawah -->

        </div>
        <!-- End Menu -->

    </div>

    <script src="../js/jquery-3.6.1.min.js"></script>
    <script>
        $("#masterdatamain").on("click", function() {

            $('#dropdownicon').toggleClass('rotate-[60deg] & origin-center');
            $('#dropdownicon1').removeClass('rotate-[60deg] & origin-center');

            $('#master_data').toggleClass('h-[220px]');
            $('#master_data').removeClass('h-[320px]');
            $('#dropdown-msbarang').removeClass('h-[170px]');

        });

        $("#msbarangmain").on("click", function() {

            $('#dropdown-msbarang').toggleClass('h-[170px]');
            $('#master_data').toggleClass('h-[220px]');
            $('#master_data').toggleClass('h-[320px]');
            $('#dropdownicon1').toggleClass('rotate-[60deg] & origin-center');
        });

        $('#button-logout').on('click', function() {
            console.log('aawas');
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin keluar?',
                showDenyButton: true,
                confirmButtonText: 'Ya',
                denyButtonText: `Batal`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../controllers/loginController.php',
                        type: 'post',
                        data: {
                            'type': 'logout',
                        },
                        success: function() {
                            window.location.replace('../views/login.php');
                        }
                    });

                } else if (result.isDenied) {

                }
            })
        });
    </script>
</body>

</html>
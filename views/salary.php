<?php
date_default_timezone_set("Asia/Bangkok");
require "../config/koneksi.php";
session_start();

if (!isset($_SESSION['statusLogin'])) {
    header('Location: login.php');
} else if ($_SESSION['level'] == 3) {
    header('Location: ../sales/dashboard.php');
}
$crud = new koneksi();

$datagaji = (isset($_GET["search"])) ? $crud->showData("SELECT gaji.id_gaji , pegawai.nama , gaji.bulan, gaji.total_penjualan, gaji.gaji FROM gaji JOIN pegawai ON gaji.id_pegawai = pegawai.id_pegawai WHERE pegawai.nama LIKE '%" . $_GET['search'] . "%'") : $crud->showData("SELECT gaji.id_gaji , pegawai.nama , gaji.bulan, gaji.total_penjualan, gaji.gaji FROM gaji JOIN pegawai ON gaji.id_pegawai = pegawai.id_pegawai");

function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary | WG Optical</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/apexcharts.css">
    <link rel="stylesheet" href="../css/sweetalert2.min.css">
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">


    <!-- modal detail -->
    <div id="modal-detail" class=""></div>
    <!-- end modal detail -->

    <!-- modal bonus -->
    <div id="modal-bonus" class=""></div>
    <!-- end modal bonus -->

    <!-- Background hitam saat sidebar show -->
    <div id="bgbody" class="w-full h-screen bg-black fixed z-50 bg-opacity-50 hidden"></div>
    <!-- End Background hitam saat sidebar show -->
    <!-- sidebar -->
    <div id="ex-sidebar" class="ex-sidebar ex-hide-sidebar fixed z-50 max-lg:transition max-lg:duration-[1s]"></div>
    <!-- end sidebar -->
    <div class="lg:ml-72">

        <!-- header -->
        <div id="top_bar">

        </div>
        <!-- end header -->

        <div class="mt-3 flex items-center flex-col md:flex-row md:justify-between md:px-16 lg:justify-between md:py-[3px]">
            <!-- Search -->
            <div class="flex flex-row shadow-sm rounded-md items-center bg-white box-border">
                <div class="flex flex-row items-center">
                    <svg width="19" height="19" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-3">
                        <path d="M19.2502 19.25L15.138 15.1305M17.4168 9.62501C17.4168 11.6915 16.5959 13.6733 15.1347 15.1346C13.6735 16.5958 11.6916 17.4167 9.62516 17.4167C7.55868 17.4167 5.57684 16.5958 4.11562 15.1346C2.6544 13.6733 1.8335 11.6915 1.8335 9.62501C1.8335 7.55853 2.6544 5.57669 4.11562 4.11547C5.57684 2.65425 7.55868 1.83334 9.62516 1.83334C11.6916 1.83334 13.6735 2.65425 15.1347 4.11547C16.5959 5.57669 17.4168 7.55853 17.4168 9.62501V9.62501Z" stroke="#797E8D" stroke-width="2" stroke-linecap="round" />
                    </svg>

                    <input id="search" type="text" placeholder="Cari Sales" class="h-11 bg-transparent ml-2 outline-none" />
                </div>
                <div onclick="search_reset()" class="cursor-pointer justify-center items-center pr-3">
                    <?php if (isset($_GET["search"])) : ?>
                        <svg class="cursor-pointer fill-[#535A6D]" width="10" height="10" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.3289 5.47926L10.6264 2.18142C10.8405 1.93831 10.9539 1.62288 10.9436 1.29924C10.9332 0.975599 10.7999 0.668037 10.5707 0.439072C10.3415 0.210106 10.0337 0.0769213 9.70976 0.0665883C9.38581 0.0562553 9.07009 0.16955 8.82676 0.383443L5.52586 3.67789L2.21901 0.373252C2.10056 0.254916 1.95995 0.161048 1.80519 0.097005C1.65044 0.0329623 1.48457 1.24687e-09 1.31706 0C1.14956 -1.24687e-09 0.983689 0.0329623 0.828933 0.097005C0.674177 0.161048 0.533562 0.254916 0.415117 0.373252C0.296672 0.491587 0.202716 0.632072 0.138614 0.786685C0.0745119 0.941298 0.041519 1.10701 0.041519 1.27436C0.041519 1.44171 0.0745119 1.60743 0.138614 1.76204C0.202716 1.91665 0.296672 2.05714 0.415117 2.17547L3.72282 5.47926L0.425318 8.77625C0.295996 8.89175 0.19162 9.03239 0.118574 9.18957C0.0455293 9.34676 0.00535166 9.51718 0.000499102 9.69041C-0.00435345 9.86364 0.0262212 10.036 0.0903528 10.1971C0.154484 10.3581 0.250824 10.5043 0.373478 10.6269C0.496133 10.7494 0.642522 10.8457 0.80369 10.9097C0.964858 10.9738 1.13742 11.0043 1.31081 10.9995C1.4842 10.9947 1.65478 10.9545 1.81211 10.8815C1.96944 10.8086 2.11021 10.7043 2.22581 10.5751L5.52586 7.28063L8.82251 10.5751C9.06172 10.8141 9.38616 10.9483 9.72446 10.9483C10.0628 10.9483 10.3872 10.8141 10.6264 10.5751C10.8656 10.3361 11 10.0119 11 9.67396C11 9.33598 10.8656 9.01184 10.6264 8.77286L7.3289 5.47926Z" fill="#535A6D" />
                        </svg>
                    <?php endif ?>
                </div>
            </div>

            <!-- End Search -->
        </div>

        <!-- konten table -->
        <div class="" id="table">
            <!-- Table -->
            <?php ?>
            <div class="overflow-x-auto  text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 py-6 px-6 ex-table">
                <table class="w-full ">
                    <thead class="border-b-2 border-gray-100">
                        <tr>
                            <th class="p-3 text-sm tracking-wide text-center">Tanggal</th>
                            <th class="p-3 text-sm tracking-wide text-center">Sales</th>
                            <th class="p-3 text-sm tracking-wide text-center">Salery Final</th>
                            <th class="p-3 text-sm tracking-wide text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $jumlahData = 0 ?>
                        <?php foreach ($datagaji as $index) : ?>
                            <?php $jumlahData = $jumlahData + 1 ?>
                            <tr>
                                <td class="p-3 text-sm tracking-wide text-center "><?= $index["bulan"] ?></td>
                                <td class="p-3 text-sm tracking-wide text-center"><?= $index["nama"] ?></td>
                                <td class="p-3 text-sm tracking-wide text-center"><?= rupiah($index["gaji"]) ?></td>
                                <td class="p-3 text-sm tracking-wide text-center">
                                    <button onclick="showmodal('<?= $index['nama'] ?>')" id="detail-button">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="40" height="40" rx="5" fill="#EDC683" />
                                            <path d="M18.4947 25.1339C18.496 23.8785 18.8727 22.6513 19.5781 21.6044C20.2835 20.5576 21.2864 19.7373 22.4624 19.2455C23.6383 18.7537 24.9355 18.6121 26.1928 18.8381C27.45 19.0641 28.6119 19.648 29.5343 20.517V10.8418C29.5343 10.0575 29.2171 9.30539 28.6524 8.75085C28.0878 8.1963 27.322 7.88477 26.5235 7.88477L14.4804 7.88477C13.15 7.88633 11.8746 8.40606 10.9339 9.32996C9.99318 10.2539 9.464 11.5065 9.4624 12.8131V26.6123C9.464 27.9189 9.99318 29.1716 10.9339 30.0955C11.8746 31.0194 13.15 31.5391 14.4804 31.5407H25.0181C23.288 31.5407 21.6287 30.8657 20.4054 29.6641C19.182 28.4626 18.4947 26.833 18.4947 25.1339ZM14.4804 14.7844C14.4804 14.523 14.5861 14.2723 14.7743 14.0874C14.9625 13.9026 15.2178 13.7987 15.484 13.7987H23.5127C23.7789 13.7987 24.0341 13.9026 24.2223 14.0874C24.4106 14.2723 24.5163 14.523 24.5163 14.7844C24.5163 15.0458 24.4106 15.2965 24.2223 15.4814C24.0341 15.6662 23.7789 15.7701 23.5127 15.7701H15.484C15.2178 15.7701 14.9625 15.6662 14.7743 15.4814C14.5861 15.2965 14.4804 15.0458 14.4804 14.7844ZM31.2474 31.2519C31.0592 31.4366 30.804 31.5404 30.5378 31.5404C30.2717 31.5404 30.0165 31.4366 29.8283 31.2519L27.4127 28.8794C26.6973 29.3278 25.8668 29.5671 25.0181 29.5693C24.1249 29.5693 23.2517 29.3092 22.509 28.8218C21.7664 28.3344 21.1875 27.6417 20.8457 26.8312C20.5039 26.0208 20.4144 25.1289 20.5887 24.2685C20.763 23.4081 21.1931 22.6178 21.8247 21.9975C22.4563 21.3772 23.261 20.9547 24.137 20.7836C25.0131 20.6125 25.9211 20.7003 26.7464 21.036C27.5716 21.3717 28.2769 21.9402 28.7731 22.6696C29.2694 23.399 29.5343 24.2566 29.5343 25.1339C29.532 25.9674 29.2883 26.783 28.8317 27.4856L31.2474 29.8581C31.4355 30.043 31.5412 30.2936 31.5412 30.555C31.5412 30.8164 31.4355 31.067 31.2474 31.2519Z" fill="#51514F" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Info Data -->
            <div class="w-[95%] h-8 mt-4 flex flex-row md:justify-end justify-center gap-1 md:pr-4">
                <p>Total</p>
                <p class="font-ex-semibold"><?= $jumlahData ?></p>
                <p>data riwayat</p>
            </div>
            <!-- End Info Data -->
        </div>
        <!-- end konten table -->
    </div>
    <script src="../js/jquery-3.6.1.min.js"></script>
    <script src="../js/sweetalert2.min.js"></script>
    <script src="../js/jquery.iddle.min.js"></script>
    <script>
        // $(document).idle({
        //     onIdle: function() {
        //         $.ajax({
        //             url: '../controllers/loginController.php',
        //             type: 'post',
        //             data: {
        //                 'type': 'logout',
        //             },
        //             success: function() {

        //             }
        //         });
        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Informasi',
        //             text: 'Sesi anda telah habis, silahkan login kembali',

        //         }).then(function() {
        //             window.location.replace('../views/login.php');
        //         });

        //     },
        //     idle: 50000
        // });
        // load sidebar

        $('#top_bar').load("../assets/components/top_bar.php", function() {
            $('#title-header').html('Master Data Product');
            $("#burger").on("click", function() {
                $('#bgbody').removeClass("hidden");

                $('#ex-sidebar').toggleClass("ex-hide-sidebar");
                $('#burger').toggleClass("show");
            });

            $("#bgbody").on("click", function() {
                $('#ex-sidebar').removeAttr("ex-hide-sidebar");
                $('#burger').removeAttr("show");

                $('#bgbody').addClass("hidden");

            });

            $('#loading').hide();

        });

        $("#ex-sidebar").load("../assets/components/sidebar.html", function() {
            $('#salary').addClass("hover-sidebar");

        });

        $("#modal-detail").load("../assets/components/modal_detail_salary.html", function() {

            $('#closemodal').on('click', function() {
                $('#modalkonten').toggleClass("scale-100");
                $('#bgmodal').removeClass("effectmodal");
            });

        });

        async function showmodal(nama_pegawai) {

            await $.ajax({
                type: "post",
                url: "../controllers/salaryController.php",
                data: {
                    type: "show_data",
                    nama: nama_pegawai,
                },
                success: function(res) {
                    const data = JSON.parse(res);
                    let finalData = data[0];
                    console.log(finalData);

                    $('#nama_sales').html(finalData.nama);
                    $('#tgl_gaji').html(finalData.bulan);
                    $('#komisi').html(formatRupiah("" + finalData.gaji, "Rp. "));
                    $('#total_gaji').html(formatRupiah("" + finalData.gaji, "Rp. "));
                }
            })

            $('#modalkonten').toggleClass("scale-100");
            $('#bgmodal').addClass("effectmodal");
        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        $("#modal-bonus").load("../assets/components/modal_bonus_gaji.html", function() {
            for (var index = 1; index < 20; index++) {
                $("#add-bonus-" + index).on('click', function() {
                    $('#modalkontenbonus').toggleClass("scale-100");
                    $('#bgmodalbonus').addClass("effectmodal");
                });
            }
            $('#closemodalbonus').on('click', function() {
                $('#modalkontenbonus').toggleClass("scale-100");
                $('#bgmodalbonus').removeClass("effectmodal");
            });
        });



        // auto hide sidebar

        $("#burger").on("click", function() {
            $('#bgbody').toggleClass("hidden");

            $('#ex-sidebar').toggleClass("ex-hide-sidebar");
            $('#burger').toggleClass("show");
        });

        $("#bgbody").on("click", function() {
            $('#ex-sidebar').toggleClass("ex-hide-sidebar");
            $('#burger').toggleClass("show");

            $('#bgbody').toggleClass("hidden");

        });

        $('#click-modal').on('click', function() {
            $('#title-modal').html('Tambah Pegawai');
            $('#modalkonten').toggleClass("scale-100");
            $('#bgmodal').addClass("effectmodal");
        });

        $('#closemodal').on('click', function() {

            $('#modalkonten').toggleClass("scale-100");
            $('#bgmodal').removeClass("effectmodal");
        });

        //search
        $('#search').keypress(function(e) {
            if (e.which == 13) {
                window.location.replace("salary.php?search=" + $('#search').val());
            }
        });

        function search_reset() {
            window.location.replace("salary.php?");
        }
    </script>


</body>

</html>
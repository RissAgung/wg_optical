<?php
date_default_timezone_set("Asia/Bangkok");
include '../controllers/pengeluaran.php';
session_start();


if (!isset($_SESSION['statusLogin'])) {
    header('Location: login.php');
} else if ($_SESSION['level'] == 3) {
    header('Location: ../sales/dashboard.php');
}


$execute = $crud->showData("SELECT * FROM tr_pengeluaran JOIN pegawai ON tr_pengeluaran.id_pegawai = pegawai.id_pegawai ORDER BY tanggal DESC");
$restock = $crud->showData("SELECT tr_pengeluaran.kode_tr_pengeluaran, tr_pengeluaran.tanggal, tr_pengeluaran.id_pegawai, tr_pengeluaran.id_Supplier, tr_pengeluaran.jenis, (CASE WHEN tr_pengeluaran.kode_frame IS NOT NULL THEN produk.merk WHEN tr_pengeluaran.kode_barang IS NOT NULL THEN tambahan.nama_barang WHEN tr_pengeluaran.kode_perkap IS NOT NULL THEN perlengkapan.nama_perlengkapan END) as barang, tr_pengeluaran.QTY FROM tr_pengeluaran LEFT JOIN perlengkapan ON tr_pengeluaran.kode_perkap = perlengkapan.kode_perlengkapan LEFT JOIN tambahan ON tambahan.kode_barang = tr_pengeluaran.kode_barang LEFT JOIN produk ON produk.kode_frame = tr_pengeluaran.kode_frame WHERE tr_pengeluaran.kategori = 'restock';");
$profileDB = $crud->showData("SELECT foto_pegawai FROM pegawai WHERE id_pegawai = '" . $_SESSION['id_pegawai'] . "'");
$imgProfile = "";
foreach ($profileDB as $index) {
    $imgProfile = $index["foto_pegawai"];
}

function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

// header("Content-type: application/vnd-ms-excel");
// header("Content-Disposition: attachment; filename=ini.xls");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengeluaran | WG Optical</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/datepicker.css">
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">

    <div id="loading" class="fixed w-full h-full top-0 left-0 flex flex-col justify-center items-center bg-slate-50 z-[99]">
        <div class="loadingspinner"></div>
    </div>

    <!-- modal  -->
    <div id="modal"></div>
    <!-- end modal  -->


    <!-- modal filter date -->
    <div id="modal_date"></div>
    <!-- end modal filter date -->

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

        <!-- tab bar -->

        <div class="px-8">
            <div class="mt-3 flex justify-between max-[550px]:justify-center md:py-[3px]">
                <div class="box-border p-1.5 drop-shadow-sm rounded-md flex justify-between flex-row text-sm font-ex-semibold bg-white z-[1]">
                    <div id="hovertab" class="transitionsidebar translate-x-[0px] ease-in-out h-[35px] rounded-lg w-[120px] absolute bg-[#343948]"></div>
                    <div id="tabOperasional" class="flex cursor-pointer justify-center py-1.5 px-4 rounded-md tab-focus">Operasional</div>
                    <div id="tabRestock" class="flex cursor-pointer justify-center py-1.5 px-4 rounded-md">Restock</div>
                </div>
                <!-- End tab bar -->
            </div>


            <div class=" md:mx-auto rounded-md py-0 px-0">
                <div class="mt-0 flex items-center content-center flex-wrap justify-between max-[550px]:justify-center py-4 gap-2">
                    <!-- Search -->
                    <div class="flex flex-row shadow-sm rounded-md items-center justify-center bg-white w-72 box-border px-2">
                        <div class="w-full flex flex-row items-center">
                            <svg width="19" height="19" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-3">
                                <path d="M19.2502 19.25L15.138 15.1305M17.4168 9.62501C17.4168 11.6915 16.5959 13.6733 15.1347 15.1346C13.6735 16.5958 11.6916 17.4167 9.62516 17.4167C7.55868 17.4167 5.57684 16.5958 4.11562 15.1346C2.6544 13.6733 1.8335 11.6915 1.8335 9.62501C1.8335 7.55853 2.6544 5.57669 4.11562 4.11547C5.57684 2.65425 7.55868 1.83334 9.62516 1.83334C11.6916 1.83334 13.6735 2.65425 15.1347 4.11547C16.5959 5.57669 17.4168 7.55853 17.4168 9.62501V9.62501Z" stroke="#797E8D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <?php $input = (isset($_GET["search"])) ? $_GET["search"] : null ?>
                            <input id="search" value="<?= $input ?>" type="text" placeholder="Cari Transaksi" class="h-11 bg-transparent ml-2 outline-none" />
                        </div>
                        <div id="btn_reset" class="cursor-pointer hidden justify-center items-center">
                            <svg class="cursor-pointer fill-[#535A6D]" width="10" height="10" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.3289 5.47926L10.6264 2.18142C10.8405 1.93831 10.9539 1.62288 10.9436 1.29924C10.9332 0.975599 10.7999 0.668037 10.5707 0.439072C10.3415 0.210106 10.0337 0.0769213 9.70976 0.0665883C9.38581 0.0562553 9.07009 0.16955 8.82676 0.383443L5.52586 3.67789L2.21901 0.373252C2.10056 0.254916 1.95995 0.161048 1.80519 0.097005C1.65044 0.0329623 1.48457 1.24687e-09 1.31706 0C1.14956 -1.24687e-09 0.983689 0.0329623 0.828933 0.097005C0.674177 0.161048 0.533562 0.254916 0.415117 0.373252C0.296672 0.491587 0.202716 0.632072 0.138614 0.786685C0.0745119 0.941298 0.041519 1.10701 0.041519 1.27436C0.041519 1.44171 0.0745119 1.60743 0.138614 1.76204C0.202716 1.91665 0.296672 2.05714 0.415117 2.17547L3.72282 5.47926L0.425318 8.77625C0.295996 8.89175 0.19162 9.03239 0.118574 9.18957C0.0455293 9.34676 0.00535166 9.51718 0.000499102 9.69041C-0.00435345 9.86364 0.0262212 10.036 0.0903528 10.1971C0.154484 10.3581 0.250824 10.5043 0.373478 10.6269C0.496133 10.7494 0.642522 10.8457 0.80369 10.9097C0.964858 10.9738 1.13742 11.0043 1.31081 10.9995C1.4842 10.9947 1.65478 10.9545 1.81211 10.8815C1.96944 10.8086 2.11021 10.7043 2.22581 10.5751L5.52586 7.28063L8.82251 10.5751C9.06172 10.8141 9.38616 10.9483 9.72446 10.9483C10.0628 10.9483 10.3872 10.8141 10.6264 10.5751C10.8656 10.3361 11 10.0119 11 9.67396C11 9.33598 10.8656 9.01184 10.6264 8.77286L7.3289 5.47926Z" fill="#535A6D" />
                            </svg>
                        </div>

                    </div>
                    <!-- End Search -->

                    <!-- Button Add + Filter + Ekspor -->
                    <div class="flex flex-row items-center justify-center gap-2">
                        <div>
                            <button href="../controllers/export.php" class="bg-[#ffffff] drop-shadow-sm rounded-md items-center justify-center px-2 py-2">
                                <!-- onclick="tableHtmlToExcel('tableOPR')" -->
                                <svg width="26px" height="26px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="100" height="100" fill="#Ffff" />
                                    <path d="M18 22a2 2 0 0 0 2-2v-5l-5 4v-3H8v-2h7v-3l5 4V8l-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12zM13 4l5 5h-5V4z" fill="#000000" />
                                </svg>
                            </button>
                        </div>
                        <div id="click-filter">
                            <button class="bg-[#ffffff] drop-shadow-sm rounded-md px-2 py-2 items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6 11.1707L6 4C6 3.44771 5.55228 3 5 3C4.44771 3 4 3.44771 4 4L4 11.1707C2.83481 11.5825 2 12.6938 2 14C2 15.3062 2.83481 16.4175 4 16.8293L4 20C4 20.5523 4.44772 21 5 21C5.55228 21 6 20.5523 6 20L6 16.8293C7.16519 16.4175 8 15.3062 8 14C8 12.6938 7.16519 11.5825 6 11.1707ZM5 13C4.44772 13 4 13.4477 4 14C4 14.5523 4.44772 15 5 15C5.55228 15 6 14.5523 6 14C6 13.4477 5.55228 13 5 13Z" fill="black" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19 21C18.4477 21 18 20.5523 18 20L18 18C18 17.9435 18.0047 17.8881 18.0137 17.8341C16.8414 17.4262 16 16.3113 16 15C16 13.6887 16.8414 12.5738 18.0137 12.1659C18.0047 12.1119 18 12.0565 18 12L18 4C18 3.44771 18.4477 3 19 3C19.5523 3 20 3.44771 20 4L20 12C20 12.0565 19.9953 12.1119 19.9863 12.1659C21.1586 12.5738 22 13.6887 22 15C22 16.3113 21.1586 17.4262 19.9863 17.8341C19.9953 17.8881 20 17.9435 20 18V20C20 20.5523 19.5523 21 19 21ZM18 15C18 14.4477 18.4477 14 19 14C19.5523 14 20 14.4477 20 15C20 15.5523 19.5523 16 19 16C18.4477 16 18 15.5523 18 15Z" fill="black" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9 9C9 7.69378 9.83481 6.58254 11 6.17071V4C11 3.44772 11.4477 3 12 3C12.5523 3 13 3.44772 13 4V6.17071C14.1652 6.58254 15 7.69378 15 9C15 10.3113 14.1586 11.4262 12.9863 11.8341C12.9953 11.8881 13 11.9435 13 12L13 20C13 20.5523 12.5523 21 12 21C11.4477 21 11 20.5523 11 20L11 12C11 11.9435 11.0047 11.8881 11.0137 11.8341C9.84135 11.4262 9 10.3113 9 9ZM11 9C11 8.44772 11.4477 8 12 8C12.5523 8 13 8.44772 13 9C13 9.55229 12.5523 10 12 10C11.4477 10 11 9.55229 11 9Z" fill="black" />
                                </svg>
                            </button>
                        </div>
                        <div class="md:my-auto h-10 w-24 font-ex-semibold text-white" id="add">
                            <button class="bg-[#3DBD9E] h-full w-full rounded-md">Tambah</button>
                        </div>
                        <!-- End Button Add + Filter + Ekspor -->
                    </div>
                </div>
            </div>
            <!-- End Search and Button -->

            <div id="pageOperasional">
                <!-- konten table -->
                <div class="relative ex-table" id="tableOPR">
                    <div id="loadingTableOperasional" class="absolute h-full w-full flex flex-col justify-center items-center bg-slate-50 z-[20]">
                        <div class="loadingspinner"></div>
                    </div>
                    <!-- Table -->
                    <div class="overflow-x-auto text-sm mx-auto md:mx-auto bg-white rounded-md py-6 px-6 h-full">
                        <table class="w-full ">
                            <thead class="border-b-2 border-gray-100">
                                <tr>
                                    <th class="p-3 text-sm tracking-wide text-center">No</th>
                                    <th class="p-3 text-sm tracking-wide text-center">Kode Transaksi</th>
                                    <th class="p-3 text-sm tracking-wide text-center">Tanggal</th>
                                    <th class="p-3 text-sm tracking-wide text-center">User</th>
                                    <th class="p-3 text-sm tracking-wide text-center">Keterangan</th>
                                    <th class="p-3 text-sm tracking-wide text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody id="isiTableOp">

                                <?php

                                $i = 0;
                                foreach ($execute as $data) {
                                    if ($data['kategori'] == "operasional") {
                                        $i++;
                                ?>
                                        <tr>
                                            <td class="p-3 text-sm tracking-wide text-center"><?php echo $i; ?></td>
                                            <td class="p-3 text-sm tracking-wide text-center"><?php echo $data['kode_tr_pengeluaran'] ?></td>
                                            <td class="p-3 text-sm tracking-wide text-center"><?php echo $data['tanggal'] ?></td>
                                            <td class="p-3 text-sm tracking-wide text-center"><?php echo $data['nama'] ?></td>
                                            <td class="p-3 text-sm tracking-wide text-center"><?php echo $data['keterangan'] ?></td>
                                            <td class="p-3 text-sm tracking-wide text-center"><?php echo rupiah($data['total_harga']) ?></td>
                                        </tr>
                                        <script>
                                        </script>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table -->

                    <!-- Pagination And Info Data -->
                    <div class="mx-auto w-[90%] md:w-[90%] md:mx-autorounded-md py-2 px-0">
                        <div class="flex flex-col md:flex-row justify-end  items-center mt-3 text-sm">
                            <div class="mb-3"><?= count($execute) ?> from <?= count($execute) ?> data</div>
                        </div>
                        <!-- End Pagination And Info Data -->


                    </div>
                </div>


            </div>

            <div id="pageRestock" class="hidden">
                <!-- konten table -->
                <div class="relative ex-table">
                    <div id="loadingTableRestock" class="absolute h-full w-full flex flex-col justify-center items-center bg-slate-50 z-[20]">
                        <div class="loadingspinner"></div>
                    </div>
                    <!-- Table -->
                    <div class="overflow-x-auto text-sm mx-auto md:mx-auto bg-white rounded-md py-6 px-6 h-full">

                        <table class="w-full ">
                            <thead class="border-b-2 border-gray-100">
                                <tr>
                                    <th class="p-3 text-sm tracking-wide text-center">No</th>
                                    <th class="p-3 text-sm tracking-wide text-center">Kode Transaksi</th>
                                    <th class="p-3 text-sm tracking-wide text-center">Tanggal</th>
                                    <th class="p-3 text-sm tracking-wide text-center">User</th>
                                    <th class="p-3 text-sm tracking-wide text-center">Supplier</th>
                                    <th class="p-3 text-sm tracking-wide text-center">Jenis</th>
                                    <th class="p-3 text-sm tracking-wide text-center">Barang</th>
                                    <th class="p-3 text-sm tracking-wide text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="isiTableRs">
                                <?php
                                $i = 0;
                                foreach ($restock as $restok) {
                                    $i++;
                                ?>
                                    <tr>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $i; ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['kode_tr_pengeluaran'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['tanggal'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['id_pegawai'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['id_Supplier'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['jenis'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['barang'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['QTY'] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table -->
                    <!-- Pagination And Info Data -->
                    <div class="mx-auto w-[90%] md:w-[90%] md:mx-autorounded-md py-2 px-0">
                        <div class="flex flex-col md:flex-row justify-end items-center mt-3 text-sm">
                            <div class="mb-3"><?= count($execute) ?> from <?= count($execute) ?> data</div>
                        </div>
                        <!-- End Pagination And Info Data -->
                    </div>
                </div>
            </div>
        </div>


        <script src="../js/jquery-3.6.1.min.js"></script>
        <script src="../js/sweetalert2.min.js"></script>
        <script src="../js/jquery.iddle.min.js"></script>
        <script src="../js/datepicker.js"></script>

        <script>
            $('#top_bar').load("../assets/components/top_bar.php", function() {
                $("#avatar_profile").attr("src", "../images/pegawai/foto_pegawai/<?= $imgProfile ?>");
                $('#title-header').html('Pengeluaran');
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

            });

            var tabSelected = 1;

            $(document).ready(function() {
                $('#loadingTableOperasional').hide();
                $('#loadingTableRestock').hide();
            });
            // load sidebar
            $("#ex-sidebar").load("../assets/components/sidebar.html", function() {
                $('#pengeluaran').addClass("hover-sidebar");
                $('#button-logout').on('click', function() {
                    // kosong
                });
                $('#loading').hide();
            });

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

            $("#modal_date").load("../assets/components/modal_filter_date.html", function() {
                $('#click-filter').on('click', function() {

                    $('#modalkonten2').toggleClass("scale-0");
                    $('#bgmodal2').addClass("effectmodal");
                });
            });

            // load modal input
            $("#modal").load("../assets/components/modal_pengeluaran.php", function() {
                modals("Opr");
                $('#pageOperasional').addClass('statusclick');

                //change tab
                $('#tabOperasional').on('click', function() {
                    tabSelected = 1;
                    $('#pageOperasional').removeClass("hidden");
                    $('#pageRestock').addClass("hidden");
                    $('#pageOperasional').toggleClass('statusclick');

                    $('#hovertab').addClass("translate-x-[0px]");
                    $('#hovertab').removeClass("translate-x-[125px]");

                    $('#hovertab').removeClass('w-[80px]');
                    $('#hovertab').addClass('w-[120px]');


                    $('#tabOperasional').addClass("tab-focus");
                    $('#tabRestock').removeClass("tab-focus");
                    modals("Opr");

                });

                $('#tabRestock').on('click', function() {
                    tabSelected = 2;
                    // $('#pageOperasional').addClass('hidden');
                    // $('#pageRestock').removeClass('hidden');

                    $('#pageOperasional').addClass("hidden");
                    $('#pageRestock').removeClass("hidden");

                    $('#pageRestock').removeClass("hidden");
                    $('#pageOperasional').addClass("hidden");
                    $('#pageRestock').toggleClass('statusclick');
                    $('#pageOperasional').removeClass('statusclick');

                    $('#hovertab').removeClass('w-[120px]');
                    $('#hovertab').addClass('w-[80px]');

                    $('#hovertab').addClass("translate-x-[125px]");
                    $('#hovertab').removeClass("translate-x-[0px]");

                    $('#tabOperasional').removeClass("tab-focus");
                    $('#tabRestock').addClass("tab-focus");
                    modals("Res");
                });

                //button close modal
                function closeModal() {
                    $('#modalkonten').addClass("scale-0");
                    $('#bgmodal').removeClass("effectmodal");

                    $('#date').val("");
                    $('#ket').val("");
                    $('#total').val("");
                    $('#jml').val("");
                }
                //end close modal


                //start add data

                $('#add').on('click', function() {

                    var idPegawai = "<?php echo $_SESSION["id_pegawai"] ?>";
                    var kode;
                    var tgl;
                    var daterestok;
                    var keterangan;
                    var total;
                    var jenis;
                    var barang;
                    var supplier;
                    var qty;

                    console.log("add");
                    console.log(idPegawai);


                    $('#modalkonten').removeClass("scale-0");
                    $('#bgmodal').addClass("effectmodal");
                    $('#title').html('Tambah Data');

                    function getData() {
                        tgl = $("#date").val();
                        daterestok = $("#daterestok").val();
                        keterangan = $('#ket').val();
                        total = parseInt($("#total").val().replace("Rp. ", "").replace(".", "").replace(".", "").replace(" ", ""));
                        kode = "TR" + Math.random().toString(9).slice(2, 10);
                        jenis = $("#jns").val();
                        barang = $("#brg").val();
                        supplier = $("#supplier").val();
                        qty = $("#jml").val();
                    };

                    //start query add
                    if (tabSelected == 1) {
                        $("#btn_tambah").on("click", function(e) {
                            e.preventDefault();
                            getData();
                            // alert(tgl);
                            let formData = new FormData();
                            let query;
                            formData.append('type', "insert");
                            formData.append('query', "INSERT INTO tr_pengeluaran VALUES ('" + kode + "' ,'" + tgl + "','" + idPegawai + "','operasional','" + keterangan + "','" + total + "',NULL,NULL,NULL,NULL,NULL,NULL)");

                            if ($('#date').val() == "") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: "Masukkan Tanggal",
                                })
                            } else if ($('#ket').val() == "") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: "Keterangan Tidak Boleh Kosong",
                                });
                            } else if ($('#total').val() == "") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: "Total Harga Tidak Boleh Kosong",
                                })
                            } else {
                                $.ajax({
                                    type: "POST",
                                    url: "../controllers/pengeluaran.php",
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    success: function(res) {
                                        // alert(res);
                                        const data = JSON.parse(res);
                                        if (data.status == 'error') {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Gagal',
                                                text: data.msg,
                                            })
                                        } else {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Berhasil',
                                                text: data.msg,

                                            }).then(function() {
                                                closeModal();
                                                window.location.replace("tr_pengeluaran.php");
                                            });
                                        }
                                    }
                                });
                            }
                        });
                        //end query add    
                    } else {
                        $("#btn_tambah").on("click", function(e) {
                            e.preventDefault();
                            getData();
                            // alert(supplier);
                            let formData = new FormData();
                            let query;
                            formData.append('type', "insert");
                            if (jenis == 'produk') {
                                formData.append('query', "INSERT INTO tr_pengeluaran VALUES ('" + kode + "' ,'" + daterestok + "','" + idPegawai + "','restock',NULL,NULL,'" + jenis + "','" + barang + "',NULL,NULL,'" + supplier + "','" + qty + "')");
                            } else if (jenis == 'tambahan') {
                                formData.append('query', "INSERT INTO tr_pengeluaran VALUES ('" + kode + "' ,'" + daterestok + "','" + idPegawai + "','restock',NULL,NULL,'" + jenis + "',NULL,'" + barang + "',NULL,'" + supplier + "','" + qty + "')");
                            } else {
                                formData.append('query', "INSERT INTO tr_pengeluaran VALUES ('" + kode + "' ,'" + daterestok + "','" + idPegawai + "','restock',NULL,NULL,'" + jenis + "',NULL,NULL,'" + barang + "','" + supplier + "','" + qty + "')");
                            }
                            if ($('#daterestok').val() == "") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: "Masukkan Tanggal",
                                })
                            } else if (jenis == "") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: "Pilih Jenis Terlebih Dahulu",
                                })
                            } else if (barang == "") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: "Pilih Barang Terlebih Dahulu",
                                })
                            } else if (supplier == "") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: "Pilih Supplier Terlebih Dahulu",
                                })
                            } else if (qty == "") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: "Masukkan QTY",
                                })
                            } else {

                                $.ajax({
                                    type: "POST",
                                    url: "../controllers/pengeluaran.php",
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    success: function(res) {
                                        // alert(res);
                                        const data = JSON.parse(res);
                                        if (data.status == 'error') {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Gagal',
                                                text: data.msg,
                                            })
                                        } else {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Berhasil',
                                                text: data.msg,

                                            }).then(function() {
                                                closeModal();
                                                window.location.replace("tr_pengeluaran.php");
                                            });
                                        }
                                    }
                                });
                            }

                        });
                    };
                }); //end code add    

                //close modal 
                $("#btn_out").on("click", function() {
                    closeModal();
                });

                $("#btn_batal").on("click", function() {
                    closeModal();
                });

            }); //end load modal add 

            // reset search
            var input = '<?= $input ?>';
            if (input !== "") {
                $('#btn_reset').removeClass('hidden');
                $('#btn_reset').addClass('flex');
                $('#btn_reset').on('click', function() {
                    window.location.replace("tr_pengeluaran.php");
                })
            }
            //search
            $('#search').keypress(function(e) {
                if (e.which == 13) {
                    if (tabSelected == 1) {
                        $.ajax({
                            url: '../controllers/pengeluaran.php?type=getOperasional&search=' + $('#search').val(),
                            type: 'GET',
                            beforeSend: function() {
                                $('#loadingTableOperasional').show();
                                $('#loadingTableOperasional').addClass('flex');
                            },
                            success: function(res) {
                                var kontenHtml = '';
                                if (res == 'kosong') {} else {
                                    const data = JSON.parse(res);

                                    for (let index = 0; index < data.length; index++) {
                                        const element = data[index];
                                        kontenHtml += '<tr>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + (index + 1) + '</td>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + element['kode_tr_pengeluaran'] + '</td>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + element['tanggal'] + '</td>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + element['nama'] + '</td>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + element['keterangan'] + '</td>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + element['total_harga'] + '</td>';
                                        kontenHtml += '</tr>';
                                    }
                                }
                                $('#isiTableOp').html(kontenHtml);
                                $('#loadingTableOperasional').hide();
                            }
                        })
                        // window.location.replace("tr_pengeluaran.php?search=" + $('#search').val());
                    } else {
                        $.ajax({
                            url: '../controllers/pengeluaran.php?type=getRestock&search=' + $('#search').val(),
                            type: 'GET',
                            beforeSend: function() {
                                $('#loadingTableRestock').show();
                                $('#loadingTableRestock').addClass('flex');
                            },
                            success: function(res) {
                                // alert(res);
                                var kontenHtml = '';
                                if (res == 'kosong') {} else {
                                    const data = JSON.parse(res);
                                    for (let index = 0; index < data.length; index++) {
                                        const element = data[index];
                                        kontenHtml += '<tr>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + (index + 1) + '</td>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + element['kode'] + '</td>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + element['tanggal'] + '</td>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + element['nama'] + '</td>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + element['supplier'] + '</td>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + element['jenis'] + '</td>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + element['barang'] + '</td>';
                                        kontenHtml += '<td class="p-3 text-sm tracking-wide text-center">' + element['jumlah'] + '</td>';
                                        kontenHtml += '</tr>';
                                    }
                                }
                                $('#isiTableRs').html(kontenHtml);
                                $('#loadingTableRestock').hide();
                            }
                        })
                    }
                }
            });
        </script>

</body>

</html>
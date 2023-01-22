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
$profileDB = $crud->showData("SELECT foto_pegawai FROM pegawai WHERE id_pegawai = '" . $_SESSION['id_pegawai'] . "'");
$imgProfile = "";
foreach ($profileDB as $index) {
  $imgProfile = $index["foto_pegawai"];
}

$datariwayat = (isset($_GET["search"])) ? $crud->showData("SELECT transaksi.status_pengiriman, transaksi.status_confirm, transaksi.tanggal, transaksi.kode_pesanan, pegawai.nama AS nama_sales, customer.nama AS nama_cus, transaksi.bukti_pengiriman, customer.alamat_jalan, transaksi.total_harga, transaksi.total_bayar, transaksi.status_pengiriman, cicilan.depan_pembayaran, cicilan.kode_cicilan FROM pegawai JOIN transaksi ON pegawai.id_pegawai = transaksi.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN cicilan ON transaksi.kode_pesanan = cicilan.kode_pesanan WHERE customer.nama LIKE '%" . $_GET['search'] . "%'") : $crud->showData("SELECT transaksi.status_pengiriman, transaksi.status_confirm, transaksi.tanggal, transaksi.kode_pesanan, pegawai.nama AS nama_sales, customer.nama AS nama_cus, transaksi.bukti_pengiriman, customer.alamat_jalan, transaksi.total_harga, transaksi.total_bayar, transaksi.status_pengiriman, cicilan.depan_pembayaran, cicilan.kode_cicilan FROM pegawai JOIN transaksi ON pegawai.id_pegawai = transaksi.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN cicilan ON transaksi.kode_pesanan = cicilan.kode_pesanan ORDER BY transaksi.tanggal DESC");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <link rel="stylesheet" href="../css/sweetalert2.min.css">
  <link rel="icon" type="image/x-icon" href="../assets/images/wgLogo.png">
  <title>Riwayat | WG Optical</title>
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">

  <div id="loading" class="fixed w-full h-full top-0 left-0 flex flex-col justify-center items-center bg-slate-50 z-[99]">
    <div class="loadingspinner"></div>
  </div>

  <!-- Logout modal -->
  <div id="bgmodal" class="w-full h-screen fixed hidden bg-black z-[51] opacity-0 transition duration-300"></div>
  <div id="modalLogout" class="w-[90%] md:w-[60%] lg:w-[30%] bg-white fixed z-[51] left-[50%] top-[50%] -translate-y-[50%] -translate-x-[50%] shadow-xl rounded-lg scale-0  transition ease-in-out">
    <div class="flex flex-row justify-between px-8 pt-[20px]">
      <h1 class="font-bold text-xl md:text-2xl">Keluar</h1>
      <h1>X</h1>
    </div>
    <div class="px-8 pt-[20px]">

      <p class="text-sm md:text-lg text-slate-600">Apakah anda yakin ingin keluar?</p>
    </div>

    <div class="flex flex-row justify-end px-8 gap-2 pt-8 pb-8">

      <div class="bg-[#3DBD9E] w-[70px] md:w-[80px] text-center rounded-md py-1 text-white text-sm sm:text-lg">
        <p>Cancel</p>
      </div>
      <div class="bg-[#F35E58] w-[70px] md:w-[80px] text-center rounded-md py-1 text-white text-sm sm:text-lg">
        <p>Oke</p>
      </div>

    </div>
  </div>
  <!-- end modal logout -->

  <!-- modal -->
  <div class="fixed left-[50%] top-[50%] -translate-y-[50%] -translate-x-[50%] z-[51] scale-0 transition ease-in-out" id="modal">

  </div>
  <!-- end modal -->
  <!-- modal detail invoice -->
  <div class="fixed z-[52] scale-0 transition ease-in-out" id="modal_detail_invoice">

  </div>
  <!-- end modal detail invoice -->

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

    <div class="mt-3 flex items-center justify-between flex-col md:flex-row md:justify-around lg:justify-between lg:px-16 md:py-[3px]">

      <!-- Search -->
      <div class="flex flex-col md:flex-row items-center mt-3 md:mt-0">

        <!-- Search -->
        <div class="flex flex-row shadow-sm rounded-md items-center bg-white box-border px-2 md:mr-6">
          <div class="flex flex-row items-center">
            <svg width="19" height="19" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-3">
              <path d="M19.2502 19.25L15.138 15.1305M17.4168 9.62501C17.4168 11.6915 16.5959 13.6733 15.1347 15.1346C13.6735 16.5958 11.6916 17.4167 9.62516 17.4167C7.55868 17.4167 5.57684 16.5958 4.11562 15.1346C2.6544 13.6733 1.8335 11.6915 1.8335 9.62501C1.8335 7.55853 2.6544 5.57669 4.11562 4.11547C5.57684 2.65425 7.55868 1.83334 9.62516 1.83334C11.6916 1.83334 13.6735 2.65425 15.1347 4.11547C16.5959 5.57669 17.4168 7.55853 17.4168 9.62501V9.62501Z" stroke="#797E8D" stroke-width="2" stroke-linecap="round" />
            </svg>
            <?php $input = (isset($_GET["search"])) ? $_GET["search"] : null ?>
            <input id="search" value="<?= $input ?>" type="text" placeholder="Type here" class="h-11 bg-transparent ml-2 outline-none pr-2" />
          </div>
          <div onclick="search_reset()" class="cursor-pointer justify-center items-center pr-2">
            <?php if (isset($_GET["search"])) : ?>
              <svg class="cursor-pointer fill-[#535A6D]" width="10" height="10" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.3289 5.47926L10.6264 2.18142C10.8405 1.93831 10.9539 1.62288 10.9436 1.29924C10.9332 0.975599 10.7999 0.668037 10.5707 0.439072C10.3415 0.210106 10.0337 0.0769213 9.70976 0.0665883C9.38581 0.0562553 9.07009 0.16955 8.82676 0.383443L5.52586 3.67789L2.21901 0.373252C2.10056 0.254916 1.95995 0.161048 1.80519 0.097005C1.65044 0.0329623 1.48457 1.24687e-09 1.31706 0C1.14956 -1.24687e-09 0.983689 0.0329623 0.828933 0.097005C0.674177 0.161048 0.533562 0.254916 0.415117 0.373252C0.296672 0.491587 0.202716 0.632072 0.138614 0.786685C0.0745119 0.941298 0.041519 1.10701 0.041519 1.27436C0.041519 1.44171 0.0745119 1.60743 0.138614 1.76204C0.202716 1.91665 0.296672 2.05714 0.415117 2.17547L3.72282 5.47926L0.425318 8.77625C0.295996 8.89175 0.19162 9.03239 0.118574 9.18957C0.0455293 9.34676 0.00535166 9.51718 0.000499102 9.69041C-0.00435345 9.86364 0.0262212 10.036 0.0903528 10.1971C0.154484 10.3581 0.250824 10.5043 0.373478 10.6269C0.496133 10.7494 0.642522 10.8457 0.80369 10.9097C0.964858 10.9738 1.13742 11.0043 1.31081 10.9995C1.4842 10.9947 1.65478 10.9545 1.81211 10.8815C1.96944 10.8086 2.11021 10.7043 2.22581 10.5751L5.52586 7.28063L8.82251 10.5751C9.06172 10.8141 9.38616 10.9483 9.72446 10.9483C10.0628 10.9483 10.3872 10.8141 10.6264 10.5751C10.8656 10.3361 11 10.0119 11 9.67396C11 9.33598 10.8656 9.01184 10.6264 8.77286L7.3289 5.47926Z" fill="#535A6D" />
              </svg>
            <?php endif ?>
          </div>
        </div>
      </div>
      <!-- End Search -->
    </div>

    <!-- konten table -->
    <div class="flex flex-col items-center" id="table">
      <!--table-->
      <div class="overflow-x-auto  text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 py-6 px-6 ex-table">
        <table class="w-full">
          <thead class="border-b-2 border-gray-100">
            <tr>
              <th class="p-3 text-sm tracking-wide text-center">No</th>
              <th class="p-3 text-sm tracking-wide text-center">Tanggal</th>
              <th class="p-3 text-sm tracking-wide text-center">Kode Pesanan</th>
              <th class="p-3 text-sm tracking-wide text-center">Sales</th>
              <th class="p-3 text-sm tracking-wide text-center">Customer</th>
              <th class="p-3 text-sm tracking-wide text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $totalData = 0;
            $no = 1; ?>
            <?php foreach ($datariwayat as $index) : ?>
              <?php if ($index['total_bayar'] >= $index['total_harga'] && $index['status_pengiriman'] == 'terima') : ?>
                <?php $totalData = $totalData + 1 ?>
                <tr>
                  <td class="p-3 text-sm tracking-wide text-center"><?= $no ?></td>
                  <td class="p-3 text-sm tracking-wide text-center"><?= $index['tanggal'] ?></td>
                  <td class="p-3 text-sm tracking-wide text-center"><?= $index['kode_pesanan'] ?></td>
                  <td class="p-3 text-sm tracking-wide text-center"><?= $index['nama_sales'] ?></td>
                  <td class="p-3 text-sm tracking-wide text-center"><?= $index['nama_cus'] ?></td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    <button onclick="show_detail('<?= $index['kode_pesanan'] ?>')">
                      <svg width="35" height="35" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="25.3637" height="25.3637" rx="5" fill="#EDC683" />
                        <path d="M11.7273 15.9375C11.7281 15.1415 11.967 14.3633 12.4143 13.6995C12.8615 13.0357 13.4975 12.5156 14.2432 12.2038C14.9888 11.8919 15.8114 11.8021 16.6086 11.9454C17.4058 12.0887 18.1426 12.4589 18.7274 13.01V6.875C18.7274 6.37772 18.5263 5.90081 18.1682 5.54917C17.8102 5.19754 17.3246 5 16.8183 5H9.18185C8.33828 5.00099 7.52955 5.33055 6.93306 5.91639C6.33656 6.50222 6.00101 7.2965 6 8.125V16.875C6.00101 17.7035 6.33656 18.4978 6.93306 19.0836C7.52955 19.6694 8.33828 19.999 9.18185 20H15.8637C14.7667 20 13.7146 19.572 12.9389 18.8101C12.1631 18.0483 11.7273 17.0149 11.7273 15.9375V15.9375ZM9.18185 9.375C9.18185 9.20924 9.2489 9.05027 9.36824 8.93306C9.48758 8.81585 9.64944 8.75 9.81822 8.75H14.9092C15.078 8.75 15.2398 8.81585 15.3592 8.93306C15.4785 9.05027 15.5455 9.20924 15.5455 9.375C15.5455 9.54076 15.4785 9.69973 15.3592 9.81694C15.2398 9.93415 15.078 10 14.9092 10H9.81822C9.64944 10 9.48758 9.93415 9.36824 9.81694C9.2489 9.69973 9.18185 9.54076 9.18185 9.375ZM19.8137 19.8169C19.6943 19.934 19.5325 19.9999 19.3638 19.9999C19.195 19.9999 19.0332 19.934 18.9139 19.8169L17.3821 18.3125C16.9285 18.5968 16.4019 18.7486 15.8637 18.75C15.2974 18.75 14.7437 18.585 14.2728 18.276C13.8018 17.967 13.4348 17.5277 13.2181 17.0138C13.0013 16.4999 12.9446 15.9344 13.0551 15.3888C13.1656 14.8432 13.4383 14.3421 13.8388 13.9488C14.2393 13.5554 14.7496 13.2876 15.3051 13.179C15.8606 13.0705 16.4363 13.1262 16.9596 13.3391C17.4829 13.552 17.9301 13.9124 18.2448 14.375C18.5594 14.8375 18.7274 15.3812 18.7274 15.9375C18.726 16.466 18.5715 16.9832 18.2819 17.4287L19.8137 18.9331C19.933 19.0503 20 19.2093 20 19.375C20 19.5407 19.933 19.6997 19.8137 19.8169Z" fill="#51514F" />
                      </svg>
                    </button>
                    <!-- <button>
                    <svg width="38" height="37" viewBox="0 0 38 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect x="0.444336" width="37" height="37" rx="5" fill="#F35E58" />
                      <path d="M23.3982 10.5062V8.67903C23.3982 8.19444 23.2105 7.72969 22.8764 7.38703C22.5423 7.04437 22.0892 6.85187 21.6167 6.85187H16.2723C15.7998 6.85187 15.3467 7.04437 15.0126 7.38703C14.6785 7.72969 14.4908 8.19444 14.4908 8.67903V10.5062H10.0371V12.3333H11.8186V26.0371C11.8186 26.7639 12.1001 27.4611 12.6013 27.975C13.1024 28.489 13.7821 28.7778 14.4908 28.7778H23.3982C24.1069 28.7778 24.7866 28.489 25.2878 27.975C25.7889 27.4611 26.0704 26.7639 26.0704 26.0371V12.3333H27.8519V10.5062H23.3982ZM18.0538 22.3827H16.2723V16.9012H18.0538V22.3827ZM21.6167 22.3827H19.8353V16.9012H21.6167V22.3827ZM21.6167 10.5062H16.2723V8.67903H21.6167V10.5062Z" fill="#501614" />
                    </svg>
                  </button> -->
                  </td>
                </tr>
                <?php $no++; ?>
              <?php endif ?>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <!-- end table -->

      <!-- total data -->
      <div class="w-[90%] h-8 mt-4 flex flex-row justify-end gap-1 lg:pr-4">
        <p>Total</p>
        <p class="font-ex-semibold"><?= $totalData ?></p>
        <p>data riwayat</p>
      </div>
      <!-- end total data -->
    </div>
  </div>

  <script src="../js/jquery-3.6.1.min.js"></script>
  <script src="../js/sweetalert2.min.js"></script>
  <script src="../js/jquery.iddle.min.js"></script>
  <script>
    $('#top_bar').load("../assets/components/top_bar.php", function() {
      $("#avatar_profile").attr("src", "../images/pegawai/foto_pegawai/<?= $imgProfile ?>");
      $('#title-header').html('Riwayat');
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

    $("#ex-sidebar").load("../assets/components/sidebar.php", function() {
      $('#riwayat').addClass("hover-sidebar");
      $('#loading').hide();
    });


    // load modal input
    $("#modal").load("../assets/components/modal_tambah_master_product.html", function() {

      $("#btn_out").on("click", function() {
        $('#modal').addClass("scale-0");
        $('#bgmodal').removeClass("effectmodal");
      });

      $("#btn_batal").on("click", function() {
        $('#modal').addClass("scale-0");
        $('#bgmodal').removeClass("effectmodal");
      });

      $("#btn_tambah").on("click", function() {
        $('#modal').addClass("scale-0");
        $('#bgmodal').removeClass("effectmodal");
      });

    });

    // tab focus
    $('#tab_catalog').on("click", function() {
      $('#bgtab').removeClass("translate-x-0");
      $('#bgtab').addClass("translate-x-[83px]");
      $('#tab_catalog').addClass("tab-focus");
      $('#tab_table').removeClass("tab-focus");
      $('#table').addClass("hidden");
      $('#catalog').removeClass("hidden");
    });

    $('#tab_table').on("click", function() {
      $('#bgtab').removeClass("translate-x-[83px]");
      $('#bgtab').addClass("translate-x-0");
      $('#tab_catalog').removeClass("tab-focus");
      $('#tab_table').addClass("tab-focus");
      $('#table').removeClass("hidden");
      $('#catalog').addClass("hidden");
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

    $('#bgmodal').on('click', function() {
      $('#modalLogout').toggleClass("scale-0");
      $('#bgmodal').removeClass("effectmodal");
    });

    $('#click-modal').on('click', function() {
      console.log("modal click");
      $('#modal').removeClass("scale-0");
      $('#bgmodal').addClass("effectmodal");
    });

    // modal detail invoiceimage.png
    $("#modal_detail_invoice").load("../assets/components/modal_detail_invoice.html", function() {
      $('#title_detail_tr').html('Detail Riwayat');

      $('#ok_btn').on('click', function() {
        console.log("btn_ok");
        $('#modal_detail_invoice').addClass("scale-0");
        $('#bgbody').addClass('scale-0');
        $('#bgbody').removeClass('effectmodal');
      })
      $('#close_detail').on('click', function() {
        console.log("tutup modal");
        $('#modal_detail_invoice').addClass("scale-0");
        $('#bgbody').addClass('scale-0');
        $('#bgbody').removeClass('effectmodal');
      })
    });

    function show_detail(id) {
      $('#bgbody').addClass('effectmodal');
      $('#bgbody').removeClass('scale-0');
      $('#modal_detail_invoice').removeClass('scale-0');

      var kontenHtml = "";
      $.ajax({
        url: '../controllers/detailInvoiceController.php?detail=' + id,
        type: 'GET',
        success: function(res) {
          const data = JSON.parse(res);
          const finalData = data[0];

          // const dataPesanan = finalData.data_pesanan[0];
          // const finallData = dataPesanan.frame;
          const dataPesanan = finalData.data_pesanan;
          const dataPembayaran = finalData.data_pembayaran;
          const dataCicilan = finalData.data_cicilan;

          console.log(finalData);
          console.log(dataPesanan.length);

          // status pesanan
          kontenHtml += '<div class="flex flex-col w-full max-md:p-5 p-9 bg-white mb-1">'

          let status_pengiriman = finalData.status_pengiriman != "" ? "Di " + finalData.status_pengiriman : "Menunggu Konfirmasi";
          kontenHtml += '<h1 class="pb-4 font-ex-semibold">' + status_pengiriman + '</h1>'

          kontenHtml += '<div class="flex flex-row w-full">'
          kontenHtml += '<div class="w-[40%] py-1">Kode Pesanan</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          kontenHtml += '<div class="w-[50%] py-1">' + finalData.kode_pesanan + '</div>'
          kontenHtml += '</div>'
          kontenHtml += '<div class="flex flex-row w-full">'
          kontenHtml += '<div class="w-[40%] py-1">Tgl Pesan</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'

          var index = finalData.tanggal.indexOf(' ');
          var textModified = finalData.tanggal.substring(0, index);

          kontenHtml += '<div class="w-[50%] py-1">' + textModified + '</div>'
          kontenHtml += '</div>'
          kontenHtml += '<div class="flex flex-row w-full">'
          kontenHtml += '<div class="w-[40%] py-1">Sales</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          kontenHtml += '<div class="w-[50%] py-1">' + finalData.nama_sales + '</div>'
          kontenHtml += '</div>'
          kontenHtml += '</div>'

          // info custommer
          kontenHtml += '<div class="flex flex-col w-full max-md:p-5 p-9 bg-white mb-1">'

          kontenHtml += '<h1 class="pb-4 font-ex-semibold">Info Custommer</h1>'

          kontenHtml += '<div class="flex flex-row w-full">'
          kontenHtml += '<div class="w-[40%] py-1">Nama</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          kontenHtml += '<div class="w-[50%] py-1">' + finalData.nama_cus + '</div>'
          kontenHtml += '</div>'
          kontenHtml += '<div class="flex flex-row w-full">'
          kontenHtml += '<div class="w-[40%] py-1">No Telepon</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          kontenHtml += '<div class="w-[50%] py-1">' + finalData.nomor_hp + '</div>'
          kontenHtml += '</div>'
          kontenHtml += '<div class="flex flex-row w-full">'
          kontenHtml += '<div class="w-[40%] py-1">Kecamatan</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          kontenHtml += '<div class="w-[50%] py-1">' + finalData.kecamatan + '</div>'
          kontenHtml += '</div>'
          kontenHtml += '<div class="flex flex-row w-full">'
          kontenHtml += '<div class="w-[40%] py-1">Desa</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          kontenHtml += '<div class="w-[50%] py-1">' + finalData.desa + '</div>'
          kontenHtml += '</div>'
          kontenHtml += '<div class="flex flex-row w-full">'
          kontenHtml += '<div class="w-[40%] py-1">Alamat</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          kontenHtml += '<div class="w-[50%] py-1">' + finalData.alamat_jalan + '</div>'
          kontenHtml += '</div>'
          kontenHtml += '<div class="flex flex-row w-full">'
          kontenHtml += '<div class="w-[40%] py-1">Pekerjaan / Instansi</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          kontenHtml += '<div class="w-[50%] py-1">' + finalData.pekerjaan + ' / ' + finalData.instansi + '</div>'
          kontenHtml += '</div>'
          kontenHtml += '</div>'

          // detail pesanan
          kontenHtml += '<div class="flex flex-col w-full max-md:p-5 p-9 bg-white mb-1">'

          kontenHtml += '<h1 class="pb-4 font-ex-semibold">Detail Pesanan</h1>'

          for (var i = 0; i < dataPesanan.length; i++) {

            let data_content = dataPesanan[i];
            let data_lensa = data_content.lensa;
            let final_data_lensa = "";

            if (data_lensa[0] != "") {
              for (var j = 0; j < data_lensa.length; j++) {
                final_data_lensa += data_lensa[j] + ", ";
              }
            } else {
              final_data_lensa = "-  ";
            }
            console.log(final_data_lensa);

            let jenis_transaksi = "";

            if (data_lensa[0] != null && data_content.frame != null) {
              jenis_transaksi = "Set";
            } else if (data_lensa[0] != null && data_content.frame == null) {
              jenis_transaksi = "Lensa";
            } else if (data_lensa[0] == null && data_content.frame != null) {
              jenis_transaksi = "Frame";
            }

            kontenHtml += '<div class="flex flex-row w-full">'
            kontenHtml += '<div class="w-[40%] py-1">Kode Frame</div>'
            kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
            let frame = data_content.frame != null ? data_content.frame : "-";
            kontenHtml += '<div class="w-[50%] py-1">' + frame + '</div>'
            kontenHtml += '</div>'

            kontenHtml += '<div class="flex flex-row w-full">'
            kontenHtml += '<div class="w-[40%] py-1">Jenis Lensa</div>'
            kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
            kontenHtml += '<div class="w-[50%] py-1">' + final_data_lensa.substring(0, final_data_lensa.length - 2) + '</div>'
            kontenHtml += '</div>'

            kontenHtml += '<div class="flex flex-row w-full">'
            kontenHtml += '<div class="w-[40%] py-1">Jenis Tranksi</div>'
            kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
            kontenHtml += '<div class="w-[50%] py-1">' + jenis_transaksi + '</div>'
            kontenHtml += '</div>'
            kontenHtml += '<div class="flex flex-row w-full">'
            kontenHtml += '<div class="w-[40%] py-1">Harga Frame</div>'
            kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
            let harga_frame = data_content.harga_frame != null ? formatRupiah(data_content.harga_frame, "Rp. ") : "-";
            kontenHtml += '<div class="w-[50%] py-1">' + harga_frame + '</div>'
            kontenHtml += '</div>'
            kontenHtml += '<div class="flex flex-row w-full">'
            kontenHtml += '<div class="w-[40%] py-1">Harga Lensa</div>'
            kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
            let harga_lensa = data_content.harga_lensa != null ? formatRupiah(data_content.harga_lensa, "Rp. ") : "-";
            kontenHtml += '<div class="w-[50%] py-1">' + harga_lensa + '</div>'
            kontenHtml += '</div>'

            if (data_content.harga_lensa != null) {
              kontenHtml += '<h1 class="pb-4 font-ex-semibold max-md:mt-5 mt-9">Resep Lensa</h1>'

              kontenHtml += '<h2 class="mb-2 font-ex-semibold">Kanan</h2>'
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">SPH</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + data_content.kn_sph + '</div>'
              kontenHtml += '</div>'
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">CYL</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + data_content.kn_cyl + '</div>'
              kontenHtml += '</div>'
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">AXIS</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + data_content.kn_axis + '</div>'
              kontenHtml += '</div>'
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">ADD+</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + data_content.kn_add + '</div>'
              kontenHtml += '</div>'
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">PD.</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + data_content.kn_pd + '</div>'
              kontenHtml += '</div>'
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">SEG.</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + data_content.kn_seg + '</div>'
              kontenHtml += '</div>'

              kontenHtml += '<h2 class="mb-2 mt-3 font-ex-semibold">Kiri</h2>'
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">SPH</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + data_content.kr_sph + '</div>'
              kontenHtml += '</div>'
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">CYL</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + data_content.kr_cyl + '</div>'
              kontenHtml += '</div>'
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">AXIS</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + data_content.kr_axis + '</div>'
              kontenHtml += '</div>'
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">ADD+</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + data_content.kr_add + '</div>'
              kontenHtml += '</div>'
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">PD.</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + data_content.kr_add + '</div>'
              kontenHtml += '</div>'
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">SEG.</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + data_content.kr_seg + '</div>'
              kontenHtml += '</div>'
            }
            if (i != dataPesanan.length - 1) {
              kontenHtml += '<hr class="w-full my-4">'
            }
          }
          kontenHtml += '</div>'

          // pembayaran
          kontenHtml += '<div class="flex flex-col w-full max-md:p-5 p-9 bg-white mb-1">'

          kontenHtml += '<h1 class="pb-4 font-ex-semibold">Info Pembayaran</h1>'

          let final_data_pembayaran = dataPembayaran[0];

          kontenHtml += '<div class="flex flex-row w-full">'
          kontenHtml += '<div class="w-[40%] py-1">Total Harga</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          kontenHtml += '<div class="w-[50%] py-1">' + formatRupiah(final_data_pembayaran.total_harga, "Rp. ") + '</div>'
          kontenHtml += '</div>'

          kontenHtml += '<div class="flex flex-row w-full mb-2">'
          let status = final_data_pembayaran.depan_pembayaran == null ? "Total Bayar" : "Uang Muka";
          kontenHtml += '<div class="w-[40%] py-1">' + status + '</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          let dataStatus = final_data_pembayaran.depan_pembayaran == null ? final_data_pembayaran.total_bayar : final_data_pembayaran.depan_pembayaran;
          kontenHtml += '<div class="w-[50%] py-1">' + formatRupiah("" + dataStatus, "Rp. ") + '</div>'
          kontenHtml += '</div>'

          for (let k = 0; k < dataCicilan.length; k++) {
            let finalDataCicilan = dataCicilan[k];
            if (finalDataCicilan.total_bayar != null) {
              kontenHtml += '<div class="flex flex-row w-full">'
              kontenHtml += '<div class="w-[40%] py-1">Pembayaran ' + (k + 1) + '</div>'
              kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
              kontenHtml += '<div class="w-[50%] py-1">' + formatRupiah("" + finalDataCicilan.total_bayar, "Rp. ") + '</div>'
              kontenHtml += '</div>'
            }
          }

          kontenHtml += '<div class="flex flex-row w-full mt-2">'
          kontenHtml += '<div class="w-[40%] py-1">Kembalian</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          let kembalian = final_data_pembayaran.kembalian <= 0 ? "0" : final_data_pembayaran.kembalian;
          kontenHtml += '<div class="w-[50%] py-1">' + formatRupiah("" + kembalian, "Rp. ") + '</div>'
          kontenHtml += '</div>'

          kontenHtml += '<div class="flex flex-row w-full">'
          kontenHtml += '<div class="w-[40%] py-1">Kurang Bayar</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          let kurang_bayar = final_data_pembayaran.total_harga - final_data_pembayaran.total_bayar;
          kurang_bayar = kurang_bayar < 0 ? "0" : kurang_bayar;
          kontenHtml += '<div class="w-[50%] py-1">' + formatRupiah("" + kurang_bayar, "Rp. ") + '</div>'
          kontenHtml += '</div>'

          kontenHtml += '<div class="flex flex-row w-full">'
          kontenHtml += '<div class="w-[40%] py-1">Tgl Pelunasan</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          kontenHtml += '<div class="w-[50%] py-1">' + final_data_pembayaran.tanggal_jatuh_tempo + '</div>'
          kontenHtml += '</div>'

          kontenHtml += '<div class="flex flex-row w-full">'
          let status_lunas = kurang_bayar == 0 ? "Lunas" : "Belum";
          kontenHtml += '<div class="w-[40%] py-1">Lunas / Belum</div>'
          kontenHtml += '<div class="w-[10%] py-1 flex justify-center">:</div>'
          kontenHtml += '<div class="w-[50%] py-1">' + status_lunas + '</div>'
          kontenHtml += '</div>'

          kontenHtml += '<div class="flex flex-row w-full">'
          let urlBill = "../views/digitalbill.php?status='" + finalData.kode_pesanan + "'"
          kontenHtml += '<a href="' + urlBill + '" class="cursor-pointer flex flex-row items-center justify-center gap-3 bg-[#3C9781] hover:bg-[#2C6A5B] transition ease-in-out text-center max-[359px]:w-full w-[45%] mx-auto rounded-md mt-5 p-2 text-xs">'
          kontenHtml += '<svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="20px" height="20px" fill="#FFFFFF"><path d="M5.521,19.9h5.322l3.519,3.515a2.035,2.035,0,0,0,1.443.6,2.1,2.1,0,0,0,.523-.067,2.026,2.026,0,0,0,1.454-1.414L23.989,1.425Z"/><path d="M4.087,18.5,22.572.012,1.478,6.233a2.048,2.048,0,0,0-.886,3.42l3.495,3.492Z"/></svg>'
          kontenHtml += '<p class="font-ex-semibold text-white">Cek Nota</p>'
          kontenHtml += '</a>'
          kontenHtml += '</div>'

          kontenHtml += '</div>'

          $('#main_content').html(kontenHtml);
        }
      });
    }

    //search
    $('#search').keypress(function(e) {
      if (e.which == 13) {
        window.location.replace("riwayat.php?search=" + $('#search').val());
      }
    });

    function search_reset() {
      window.location.replace("riwayat.php?");
    }
  </script>

</body>

</html>
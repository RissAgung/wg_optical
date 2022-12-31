<?php
require "../config/koneksi.php";
session_start();

if (!isset($_SESSION['statusLogin'])) {
  header('Location: login.php');
} else if ($_SESSION['level'] == 3) {
  header('Location: ../sales/dashboard.php');
}

$crud = new koneksi();
$jumlahDataPerHalaman = 6;
$jumlahData = (isset($_GET["search"])) ? count( $crud -> showData("SELECT transaksi.kode_pesanan, transaksi.status_confirm, transaksi.tanggal, pegawai.nama AS nama_pegawai , transaksi.total_bayar, transaksi.total_harga, transaksi.kembalian, customer.nama AS nama_customer, transaksi.tanggal_jatuh_tempo, transaksi.status_pengiriman FROM transaksi JOIN pegawai ON transaksi.id_pegawai = pegawai.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer LIKE'%" . $_GET["search"] . "%' LIMIT 0, $jumlahDataPerHalaman")) : count($crud -> showData("SELECT transaksi.kode_pesanan, transaksi.status_confirm, transaksi.tanggal, pegawai.nama AS nama_pegawai , transaksi.total_bayar, transaksi.total_harga, transaksi.kembalian, customer.nama AS nama_customer, transaksi.tanggal_jatuh_tempo, transaksi.status_pengiriman FROM transaksi JOIN pegawai ON transaksi.id_pegawai = pegawai.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$datariwayat = (isset($_GET["search"])) ? $crud->showData("SELECT transaksi.kode_pesanan, transaksi.status_confirm, transaksi.tanggal, pegawai.nama AS nama_pegawai , transaksi.total_bayar, transaksi.total_harga, transaksi.kembalian, customer.nama AS nama_customer, transaksi.tanggal_jatuh_tempo, transaksi.status_pengiriman FROM transaksi JOIN pegawai ON transaksi.id_pegawai = pegawai.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer LIKE'%" . $_GET["search"] . "%' LIMIT $awalData, $jumlahDataPerHalaman") : $crud -> showData("SELECT transaksi.kode_pesanan, transaksi.status_confirm, transaksi.tanggal, pegawai.nama AS nama_pegawai , transaksi.total_bayar, transaksi.total_harga, transaksi.kembalian, customer.nama AS nama_customer, transaksi.tanggal_jatuh_tempo, transaksi.status_pengiriman FROM transaksi JOIN pegawai ON transaksi.id_pegawai = pegawai.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer LIMIT $awalData, $jumlahDataPerHalaman")
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <link rel="stylesheet" href="../css/sweetalert2.min.css">
  <title>Riwayat</title>
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">
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
    <div class="w-full h-16 bg-white flex items-center md:justify-between md:px-5 justify-between px-6 overflow-hidden">
      <div class="flex flex-row uppercase font-ex-bold text-sm items-center">

        <!-- hamburger -->
        <div class="ex-burger mr-2 lg:hidden absolute" id="burger">
          <svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="20" height="20">
            <rect y="10.5" width="24" height="3" />
            <rect y="3.5" width="24" height="3" />
            <rect y="17.5" width="24" height="3" />
          </svg>
        </div>
        <div class="ex-burger mr-2 lg:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="20" height="20">
            <rect y="10.5" width="24" height="3" />
            <rect y="3.5" width="24" height="3" />
            <rect y="17.5" width="24" height="3" />
          </svg>
        </div>

        <h1>Riwayat</h1>
      </div>

      <div class="flex flex-row items-center">
        <div class="mr-4">
          <svg width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M23.8313 21.0763L23.5594 20.8364C22.788 20.1491 22.1129 19.361 21.5521 18.4933C20.9397 17.2957 20.5727 15.9879 20.4725 14.6467V10.6961C20.4778 8.58936 19.7136 6.55319 18.3235 4.97017C16.9334 3.38714 15.013 2.36623 12.9233 2.09923V1.06761C12.9233 0.784463 12.8108 0.512912 12.6106 0.312696C12.4104 0.11248 12.1388 0 11.8557 0C11.5725 0 11.301 0.11248 11.1008 0.312696C10.9005 0.512912 10.7881 0.784463 10.7881 1.06761V2.11523C8.71703 2.40147 6.81989 3.42855 5.44804 5.00626C4.07618 6.58396 3.32257 8.60538 3.32679 10.6961V14.6467C3.22663 15.9879 2.85958 17.2957 2.24718 18.4933C1.69609 19.3588 1.03178 20.1468 0.271901 20.8364L0 21.0763V23.3315H23.8313V21.0763Z" fill="#444D68" />
            <path d="M9.81348 24.1712C9.8836 24.6781 10.1348 25.1425 10.5206 25.4787C10.9065 25.8148 11.401 26 11.9127 26C12.4245 26 12.9189 25.8148 13.3048 25.4787C13.6906 25.1425 13.9418 24.6781 14.0119 24.1712H9.81348Z" fill="#444D68" />
          </svg>
        </div>
        <img class="w-10 h-10 rounded-full" src="https://upload.wikimedia.org/wikipedia/id/d/d5/Aang_.jpg" alt="Rounded avatar">
      </div>
    </div>
    <div class="mt-3 flex items-center justify-between flex-col md:flex-row md:justify-around  lg:justify-between lg:px-16 md:py-[3px]">

      <!-- Tab Bar -->
      <!-- <div class="w-44 box-border p-1.5 shadow-sm rounded-md flex justify-between flex-row text-sm font-ex-semibold bg-white">
        <div class="transition bg-[#343948] h-8 w-[80px] absolute rounded-md translate-x-0 ease-in-out" id="bgtab">
        </div>
        <div class="flex justify-center py-1.5 w-20 rounded-md tab-focus cursor-pointer" id="tab_table">Table</div>
        <div class="flex justify-center py-1.5 w-20 rounded-md cursor-pointer" id="tab_catalog">Catalog</div>
      </div> -->

      <!-- Search and Button Add -->
      <div class="flex flex-col md:flex-row items-center mt-3 md:mt-0">

        <!-- Search -->
        <div class="flex flex-row shadow-sm rounded-md items-center bg-white box-border px-2 md:mr-6">
          <svg width="19" height="19" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-3">
            <path d="M19.2502 19.25L15.138 15.1305M17.4168 9.62501C17.4168 11.6915 16.5959 13.6733 15.1347 15.1346C13.6735 16.5958 11.6916 17.4167 9.62516 17.4167C7.55868 17.4167 5.57684 16.5958 4.11562 15.1346C2.6544 13.6733 1.8335 11.6915 1.8335 9.62501C1.8335 7.55853 2.6544 5.57669 4.11562 4.11547C5.57684 2.65425 7.55868 1.83334 9.62516 1.83334C11.6916 1.83334 13.6735 2.65425 15.1347 4.11547C16.5959 5.57669 17.4168 7.55853 17.4168 9.62501V9.62501Z" stroke="#797E8D" stroke-width="2" stroke-linecap="round" />
          </svg>
          <?php $input = (isset($_GET["search"])) ? $_GET["search"] : null ?>
          <input id="search"  type="text" placeholder="Type here" class="h-11 bg-transparent ml-2 outline-none" />
        </div>

      </div>
      <!-- End Search -->

      <!-- Button Add -->
      <!-- <div class="  md:my-auto h-10 w-24 font-ex-semibold text-white mt-3 md:mt-0" id="click-modal">
        <button class="bg-[#3DBD9E] h-full w-full rounded-md">Tambah</button>
      </div> -->
      <!-- End Button Add -->
      <!-- End Search and Button Add -->
    </div>
    <!-- konten table -->
    <div class="" id="table">
      <!--table-->
      <div class="overflow-x-auto  text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 ex-table">
        <table class="w-full">
          <thead class="border-b-2 border-gray-100">
            <tr>
              <th class="p-3 text-sm tracking-wide text-center">Tanggal</th>
              <th class="p-3 text-sm tracking-wide text-center">Kode Pesanan</th>
              <th class="p-3 text-sm tracking-wide text-center">Sales</th>
              <th class="p-3 text-sm tracking-wide text-center">Customer</th>
              <!-- <th class="p-3 text-sm tracking-wide text-center">Detail</th> -->
              <th class="p-3 text-sm tracking-wide text-center">aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($datariwayat as $index) : ?>
              <?php if ($index['total_bayar'] >= $index['total_harga'] && $index['status_pengiriman'] == 'terima') : ?>
                <tr>
                <td class="p-3 text-sm tracking-wide text-center"><?= $index['tanggal']?></td>
                <td class="p-3 text-sm tracking-wide text-center"><?= $index['kode_pesanan']?></td>
                <td class="p-3 text-sm tracking-wide text-center"><?= $index['nama_pegawai']?></td>
                <td class="p-3 text-sm tracking-wide text-center"><?= $index['nama_customer']?></td>
                <!-- <td class="p-3 text-sm tracking-wide text-center"><?= $index['tanggal_jatuh_tempo']?></td> -->
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
              <?php endif ?>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <!-- Pagination And Info Data -->
      <div class="flex flex-col-reverse md:flex-row lg:flex-row lg:justify-between md:justify-around lg:px-16 lg:mt-5 items-center mt-3 text-sm">
        <div class="flex flex-row mb-3 font-ex-semibold">
          <?php if ($halamanAktif > 4 && $jumlahHalaman > 4) : ?>
            <a class="no-underline" href="?halaman=<?= $halamanAktif - 1 ?>">
              <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white transition ease-in-out hover:bg-[#e7e7e7] drop-shadow-md">
                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8 0.748694C7.99976 0.947765 7.89284 1.13862 7.70275 1.2793L2.51977 5.11966C2.36289 5.23587 2.23845 5.37384 2.15354 5.52569C2.06864 5.67754 2.02494 5.84029 2.02494 6.00466C2.02494 6.16903 2.06864 6.33178 2.15354 6.48363C2.23845 6.63549 2.36289 6.77346 2.51977 6.88967L7.69599 10.7275C7.88058 10.8691 7.98272 11.0588 7.98042 11.2557C7.97811 11.4525 7.87153 11.6409 7.68365 11.7801C7.49576 11.9193 7.2416 11.9983 6.9759 12C6.71021 12.0017 6.45423 11.926 6.26311 11.7892L1.08689 7.95437C0.390892 7.43766 4.76837e-07 6.73745 4.76837e-07 6.00741C4.76837e-07 5.27738 0.390892 4.57717 1.08689 4.06045L6.26986 0.220095C6.41138 0.115167 6.59168 0.0436506 6.78799 0.0145702C6.98431 -0.0145102 7.18786 0.000148773 7.37294 0.0566969C7.55803 0.113245 7.71636 0.209149 7.82796 0.332306C7.93956 0.455462 7.99942 0.600353 8 0.748694Z" fill="#343948" />
                </svg>
              </div>
            </a>
          <?php endif ?>

          <?php if ($jumlahHalaman > 1) : ?>
            <?php if ($halamanAktif > 4) : ?>
              <?php for ($i = $halamanAktif - 3; $i <= $halamanAktif; $i++) : ?>
                <?php if ($i == $halamanAktif) : ?>
                  <a class="no-underline text-white" href="?halaman=<?= $i ?>">
                    <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-[#5C6171] drop-shadow-md"><?= $i ?></div>
                  </a>
                <?php else : ?>
                  <a class="no-underline" href="?halaman=<?= $i ?>">
                    <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white transition ease-in-out hover:bg-[#e7e7e7] drop-shadow-md"><?= $i ?></div>
                  </a>
                <?php endif ?>
              <?php endfor ?>
            <?php else : ?>
              <?php if ($jumlahHalaman > 4) : ?>
                <?php for ($i = 1; $i <= 4; $i++) : ?>
                  <?php if ($i == $halamanAktif) : ?>
                    <a class="no-underline text-white" href="?halaman=<?= $i ?>">
                      <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-[#5C6171] drop-shadow-md"><?= $i ?></div>
                    </a>
                  <?php else : ?>
                    <a class="no-underline" href="?halaman=<?= $i ?>">
                      <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white transition ease-in-out hover:bg-[#e7e7e7] drop-shadow-md"><?= $i ?></div>
                    </a>
                  <?php endif ?>
                <?php endfor ?>
              <?php else : ?>
                <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                  <?php if ($i == $halamanAktif) : ?>
                    <a class="no-underline text-white" href="?halaman=<?= $i ?>">
                      <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-[#5C6171] drop-shadow-md"><?= $i ?></div>
                    </a>
                  <?php else : ?>
                    <a class="no-underline" href="?halaman=<?= $i ?>">
                      <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white transition ease-in-out hover:bg-[#e7e7e7] drop-shadow-md"><?= $i ?></div>
                    </a>
                  <?php endif ?>
                <?php endfor ?>
              <?php endif ?>

            <?php endif ?>
          <?php endif ?>

          <?php if ($halamanAktif < $jumlahHalaman && $jumlahHalaman > 4) : ?>
            <a class="no-underline" href="?halaman=<?= $halamanAktif + 1 ?>">
              <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white transition ease-in-out hover:bg-[#e7e7e7] drop-shadow-md">
                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 11.2513C0.00023652 11.0522 0.107156 10.8614 0.297251 10.7207L5.48023 6.88034C5.63711 6.76413 5.76155 6.62616 5.84646 6.47431C5.93136 6.32246 5.97506 6.15971 5.97506 5.99534C5.97506 5.83097 5.93136 5.66822 5.84646 5.51637C5.76155 5.36451 5.63711 5.22654 5.48023 5.11033L0.304007 1.27248C0.119416 1.13087 0.0172752 0.941199 0.019584 0.744328C0.0218929 0.547457 0.128467 0.359134 0.316351 0.21992C0.504235 0.0807055 0.758398 0.00173914 1.0241 2.83842e-05C1.28979 -0.00168237 1.54577 0.0739993 1.73689 0.210773L6.91311 4.04563C7.60911 4.56234 8 5.26255 8 5.99259C8 6.72262 7.60911 7.42283 6.91311 7.93955L1.73014 11.7799C1.58862 11.8848 1.40832 11.9563 1.21201 11.9854C1.01569 12.0145 0.812142 11.9999 0.627057 11.9433C0.441971 11.8868 0.283639 11.7909 0.17204 11.6677C0.0604405 11.5445 0.000575787 11.3996 0 11.2513Z" fill="#343948" />
                </svg>
              </div>
            </a>
          <?php endif ?>

        </div>
        <div class="mb-3"><?= count($datariwayat) ?> from <?= $jumlahData ?> data</div>
      </div>
      <!-- End Pagination And Info Data -->
    </div>
  </div>

  <script src="../js/jquery-3.6.1.min.js"></script>
  <script src="../js/sweetalert2.min.js"></script>
  <script src="../js/jquery.iddle.min.js"></script>
  <script>
    $(document).idle({
      onIdle: function() {
        $.ajax({
          url: '../controllers/loginController.php',
          type: 'post',
          data: {
            'type': 'logout',
          },
          success: function() {

          }
        });
        Swal.fire({
          icon: 'warning',
          title: 'Informasi',
          text: 'Sesi anda telah habis, silahkan login kembali',

        }).then(function() {
          window.location.replace('../views/login.php');
        });

      },
      idle: 50000
    });
    // load sidebar
    $("#ex-sidebar").load("../assets/components/sidebar.html", function() {
      $('#riwayat').addClass("hover-sidebar");

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

      $('#ok_btn').on('click', function(){
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
          kontenHtml += '<div class="w-[50%] py-1">081233764580</div>'
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

            if (data_lensa[0] != "" && data_content.frame != "") {
              jenis_transaksi = "Set";
            } else if (data_lensa[0] != "" && data_content.frame == "") {
              jenis_transaksi = "Lensa";
            } else if (data_lensa[0] == "" && data_content.frame != "") {
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
          kontenHtml += '</div>'

          $('#main_content').html(kontenHtml);
        }
      });
    }
    //searc
    $('#search').keypress(function(e){
        if(e.which == 13){
          window.location.replace("riwayat.php?search="+$('#search').val());
        }
      });
  </script>

</body>

</html>
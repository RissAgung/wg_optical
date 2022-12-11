<?php

include "../config/koneksi.php";

$crud = new koneksi();

$dataPembelian = $crud->showData("SELECT transaksi.tanggal, transaksi.kode_pesanan, pegawai.nama FROM transaksi JOIN pegawai ON transaksi.id_pegawai = pegawai.id_pegawai WHERE transaksi.Status_transaksi = 'proses'")

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <link rel="stylesheet" href="../css/sweetalert2.min.css">
  <style>
    @media(min-width: 768px) {
      .main-content {
        height: calc(100vh - 100px);
      }
    }
  </style>
  <title>Master Data | WG Optical</title>
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border text-[#343948]">


  <!-- modal edit pembayaran -->
  <div class="fixed z-[52] scale-0 transition ease-in-out" id="modal_edit_bayar">

  </div>
  <!-- end modal edit pembayaran-->

  <!-- modal detail invoice -->
  <div class="fixed z-[52] scale-0 transition ease-in-out" id="modal_detail_invoice">

  </div>
  <!-- end modal detail invoice -->

  <!-- modal edit tracking -->
  <div class="fixed z-[52] scale-0 transition ease-in-out" id="modal_edit_tracking">

  </div>
  <!-- end modal edit tracking -->

  <!-- Background hitam saat sidebar show -->
  <div id="bgbody" class="w-full h-screen fixed z-[51] scale-0"></div>
  <!-- End Background hitam saat sidebar show -->

  <!-- sidebar -->
  <div id="ex-sidebar" class="ex-sidebar ex-hide-sidebar fixed z-50 max-lg:transition max-lg:duration-[1s]"></div>
  <!-- end sidebar -->


  <!-- main container -->
  <div class="flex flex-col h-screen lg:ml-72">
    <!-- Header -->
    <div>
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

          <h1>invoice</h1>
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
    </div>
    <!-- End header -->

    <!-- main content -->
    <div class="flex flex-col justify-between main-content w-[90%] mx-auto mt-4 max-[374px]:text-[13px] text-sm p-5 bg-white rounded-md relative">

      <!-- atas -->
      <div>
        <!-- tab bar -->
        <div class="overflow-x-auto">
          <div class="tab-invoice flex flex-row">
            <h2 class="max-[374px]:mr-3 mr-8 font-ex-semibold cursor-pointer" onclick="tab('1')" id="tab_Pembelian">Pembelian</h2>
            <h2 class="max-[374px]:mr-3 mr-8 cursor-pointer" onclick="tab('2')" id="tab_Proses">Di proses</h2>
            <h2 class="tab_Pembayaran cursor-pointer" onclick="tab('3')" id="tab_Pembayaran">Pembayaran</h2>
          </div>
          <hr class="mt-3 bg-[#343948] h-[0.3px]">
          <div id="tab_bar_invoice" class="transition ease-in-out h-[5px] max-[374px]:w-[70px] w-[80px] bg-[#209F80] rounded-md absolute top-[50px]"></div>
        </div>
        <!-- end tab bar -->

        <!-- table pembelian -->
        <div class="table-invoice flex mt-12 overflow-x-auto" id="table_Pembelian">
          <table class="w-full">
            <thead class="font-ex-bold border-b-2 border-gray-100">
              <tr>
                <th class="p-3 text-sm tracking-wide text-center">
                  Tanggal
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Kode Pesanan
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Sales
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Customer
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Pembelian
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Pembayaran
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dataPembelian as $index) : ?>
                <tr>
                  <td class="p-3 text-sm tracking-wide text-center">
                    <?= $index["tanggal"] ?>
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    <?= $index["kode_pesanan"] ?>
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    <?= $index["nama"] ?>
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    Fathur Maulana
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    Full Sett
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    DP
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    <button class="" onclick="show_detail()">
                      <svg width="35" height="35" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="25.3637" height="25.3637" rx="5" fill="#EDC683" />
                        <path d="M11.7273 15.9375C11.7281 15.1415 11.967 14.3633 12.4143 13.6995C12.8615 13.0357 13.4975 12.5156 14.2432 12.2038C14.9888 11.8919 15.8114 11.8021 16.6086 11.9454C17.4058 12.0887 18.1426 12.4589 18.7274 13.01V6.875C18.7274 6.37772 18.5263 5.90081 18.1682 5.54917C17.8102 5.19754 17.3246 5 16.8183 5H9.18185C8.33828 5.00099 7.52955 5.33055 6.93306 5.91639C6.33656 6.50222 6.00101 7.2965 6 8.125V16.875C6.00101 17.7035 6.33656 18.4978 6.93306 19.0836C7.52955 19.6694 8.33828 19.999 9.18185 20H15.8637C14.7667 20 13.7146 19.572 12.9389 18.8101C12.1631 18.0483 11.7273 17.0149 11.7273 15.9375V15.9375ZM9.18185 9.375C9.18185 9.20924 9.2489 9.05027 9.36824 8.93306C9.48758 8.81585 9.64944 8.75 9.81822 8.75H14.9092C15.078 8.75 15.2398 8.81585 15.3592 8.93306C15.4785 9.05027 15.5455 9.20924 15.5455 9.375C15.5455 9.54076 15.4785 9.69973 15.3592 9.81694C15.2398 9.93415 15.078 10 14.9092 10H9.81822C9.64944 10 9.48758 9.93415 9.36824 9.81694C9.2489 9.69973 9.18185 9.54076 9.18185 9.375ZM19.8137 19.8169C19.6943 19.934 19.5325 19.9999 19.3638 19.9999C19.195 19.9999 19.0332 19.934 18.9139 19.8169L17.3821 18.3125C16.9285 18.5968 16.4019 18.7486 15.8637 18.75C15.2974 18.75 14.7437 18.585 14.2728 18.276C13.8018 17.967 13.4348 17.5277 13.2181 17.0138C13.0013 16.4999 12.9446 15.9344 13.0551 15.3888C13.1656 14.8432 13.4383 14.3421 13.8388 13.9488C14.2393 13.5554 14.7496 13.2876 15.3051 13.179C15.8606 13.0705 16.4363 13.1262 16.9596 13.3391C17.4829 13.552 17.9301 13.9124 18.2448 14.375C18.5594 14.8375 18.7274 15.3812 18.7274 15.9375C18.726 16.466 18.5715 16.9832 18.2819 17.4287L19.8137 18.9331C19.933 19.0503 20 19.2093 20 19.375C20 19.5407 19.933 19.6997 19.8137 19.8169Z" fill="#51514F" />
                      </svg>
                    </button>
                    <button>
                      <svg width="35" height="35" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="25.36" height="25.36" rx="5" fill="#82DCC6" />
                        <path d="M17.8211 7.38155C18.063 7.13348 18.3849 6.99634 18.7189 6.99906C19.0529 7.00179 19.3728 7.14416 19.6112 7.39614C19.8495 7.64813 19.9877 7.99001 19.9965 8.34965C20.0054 8.70929 19.8842 9.05856 19.6585 9.32377L12.807 18.5539C12.6892 18.6906 12.547 18.8003 12.389 18.8764C12.2309 18.9526 12.0602 18.9936 11.8871 18.9971C11.7139 19.0005 11.542 18.9663 11.3814 18.8965C11.2208 18.8267 11.0749 18.7228 10.9525 18.5909L6.40892 13.6965C6.28239 13.5695 6.1809 13.4164 6.11051 13.2462C6.04012 13.076 6.00227 12.8923 5.99922 12.706C5.99617 12.5198 6.02798 12.3347 6.09276 12.162C6.15753 11.9892 6.25394 11.8323 6.37623 11.7006C6.49852 11.5689 6.6442 11.465 6.80456 11.3952C6.96492 11.3255 7.13669 11.2912 7.30961 11.2945C7.48253 11.2978 7.65307 11.3385 7.81104 11.4144C7.96902 11.4902 8.1112 11.5995 8.2291 11.7358L11.8248 15.6073L17.7885 7.42225C17.7992 7.40801 17.8107 7.39442 17.8228 7.38155H17.8211Z" fill="#073D2F" />
                      </svg>
                    </button>
                    <button>
                      <svg width="35" height="35" viewBox="0 0 38 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.444336" width="37" height="37" rx="5" fill="#F35E58" />
                        <path d="M23.3982 10.5062V8.67903C23.3982 8.19444 23.2105 7.72969 22.8764 7.38703C22.5423 7.04437 22.0892 6.85187 21.6167 6.85187H16.2723C15.7998 6.85187 15.3467 7.04437 15.0126 7.38703C14.6785 7.72969 14.4908 8.19444 14.4908 8.67903V10.5062H10.0371V12.3333H11.8186V26.0371C11.8186 26.7639 12.1001 27.4611 12.6013 27.975C13.1024 28.489 13.7821 28.7778 14.4908 28.7778H23.3982C24.1069 28.7778 24.7866 28.489 25.2878 27.975C25.7889 27.4611 26.0704 26.7639 26.0704 26.0371V12.3333H27.8519V10.5062H23.3982ZM18.0538 22.3827H16.2723V16.9012H18.0538V22.3827ZM21.6167 22.3827H19.8353V16.9012H21.6167V22.3827ZM21.6167 10.5062H16.2723V8.67903H21.6167V10.5062Z" fill="#501614" />
                      </svg>
                    </button>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
        <!-- end table pembelian -->

        <!-- table di Proses-->
        <div class="table-invoice mt-12 overflow-x-auto hidden" id="table_Proses">
          <table class="w-full">
            <thead class="font-ex-bold border-b-2 border-gray-100">
              <tr>
                <th class="p-3 text-sm tracking-wide text-center">
                  Pesanan
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Customer
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Pembelian
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Pembayaan
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i = 0; $i < 3; $i++) : ?>
                <tr>
                  <td class="p-3 text-sm tracking-wide text-center">
                    TR0000043
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    Fathur Maulana
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    Full Sett
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    Cicilan 1
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    <button class="">
                      <svg width="35" height="35" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="25.3637" height="25.3637" rx="5" fill="#EDC683" />
                        <path d="M11.7273 15.9375C11.7281 15.1415 11.967 14.3633 12.4143 13.6995C12.8615 13.0357 13.4975 12.5156 14.2432 12.2038C14.9888 11.8919 15.8114 11.8021 16.6086 11.9454C17.4058 12.0887 18.1426 12.4589 18.7274 13.01V6.875C18.7274 6.37772 18.5263 5.90081 18.1682 5.54917C17.8102 5.19754 17.3246 5 16.8183 5H9.18185C8.33828 5.00099 7.52955 5.33055 6.93306 5.91639C6.33656 6.50222 6.00101 7.2965 6 8.125V16.875C6.00101 17.7035 6.33656 18.4978 6.93306 19.0836C7.52955 19.6694 8.33828 19.999 9.18185 20H15.8637C14.7667 20 13.7146 19.572 12.9389 18.8101C12.1631 18.0483 11.7273 17.0149 11.7273 15.9375V15.9375ZM9.18185 9.375C9.18185 9.20924 9.2489 9.05027 9.36824 8.93306C9.48758 8.81585 9.64944 8.75 9.81822 8.75H14.9092C15.078 8.75 15.2398 8.81585 15.3592 8.93306C15.4785 9.05027 15.5455 9.20924 15.5455 9.375C15.5455 9.54076 15.4785 9.69973 15.3592 9.81694C15.2398 9.93415 15.078 10 14.9092 10H9.81822C9.64944 10 9.48758 9.93415 9.36824 9.81694C9.2489 9.69973 9.18185 9.54076 9.18185 9.375ZM19.8137 19.8169C19.6943 19.934 19.5325 19.9999 19.3638 19.9999C19.195 19.9999 19.0332 19.934 18.9139 19.8169L17.3821 18.3125C16.9285 18.5968 16.4019 18.7486 15.8637 18.75C15.2974 18.75 14.7437 18.585 14.2728 18.276C13.8018 17.967 13.4348 17.5277 13.2181 17.0138C13.0013 16.4999 12.9446 15.9344 13.0551 15.3888C13.1656 14.8432 13.4383 14.3421 13.8388 13.9488C14.2393 13.5554 14.7496 13.2876 15.3051 13.179C15.8606 13.0705 16.4363 13.1262 16.9596 13.3391C17.4829 13.552 17.9301 13.9124 18.2448 14.375C18.5594 14.8375 18.7274 15.3812 18.7274 15.9375C18.726 16.466 18.5715 16.9832 18.2819 17.4287L19.8137 18.9331C19.933 19.0503 20 19.2093 20 19.375C20 19.5407 19.933 19.6997 19.8137 19.8169Z" fill="#51514F" />
                      </svg>
                    </button>
                    <button onclick="show_tracking()">
                      <svg width="35" height="35" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="25.3637" height="25.3637" rx="5" fill="#82DCC6" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0511 6.117C19.2375 6.19425 19.4068 6.30746 19.5493 6.45018C19.692 6.59274 19.8052 6.76204 19.8825 6.94839C19.9597 7.13474 19.9995 7.33448 19.9995 7.53621C19.9995 7.73793 19.9597 7.93768 19.8825 8.12402C19.8052 8.31037 19.692 8.47967 19.5493 8.62223L17.4961 10.6749L15.3246 8.50338L17.3773 6.45018C17.5198 6.30746 17.6891 6.19425 17.8755 6.117C18.0618 6.03976 18.2616 6 18.4633 6C18.665 6 18.8648 6.03976 19.0511 6.117ZM6 18.7987C6.00013 18.1776 6.24695 17.5821 6.68616 17.143L14.4979 9.33123L16.6694 11.5027L8.85763 19.3145C8.41855 19.7537 7.82299 20.0005 7.20195 20.0006H6V18.7987Z" fill="#073D2F" />
                      </svg>

                    </button>
                  </td>
                </tr>
              <?php endfor ?>
            </tbody>
          </table>
        </div>
        <!-- end table di proses -->

        <!-- table Pembayaran-->
        <div class="table-invoice mt-12 overflow-x-auto hidden" id="table_Pembayaran">
          <table class="w-full">
            <thead class="font-ex-bold border-b-2 border-gray-100">
              <tr>
                <th class="p-3 text-sm tracking-wide text-center">
                  Pesanan
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Customer
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Pembelian
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Pembayaan
                </th>
                <th class="p-3 text-sm tracking-wide text-center">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i = 0; $i < 3; $i++) : ?>
                <tr>
                  <td class="p-3 text-sm tracking-wide text-center">
                    TR0000043
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    Fathur Maulana
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    Full Sett
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    Cicilan 1
                  </td>
                  <td class="p-3 text-sm tracking-wide text-center">
                    <!-- edit -->
                    <button onclick="show_pembayaran()">
                      <svg width="35" height="35" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="25.3637" height="25.3637" rx="5" fill="#EDC683" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0511 6.117C19.2375 6.19425 19.4068 6.30746 19.5493 6.45018C19.692 6.59274 19.8052 6.76204 19.8825 6.94839C19.9597 7.13474 19.9995 7.33448 19.9995 7.53621C19.9995 7.73793 19.9597 7.93768 19.8825 8.12402C19.8052 8.31037 19.692 8.47967 19.5493 8.62223L17.4961 10.6749L15.3246 8.50338L17.3773 6.45018C17.5198 6.30746 17.6891 6.19425 17.8755 6.117C18.0618 6.03976 18.2616 6 18.4633 6C18.665 6 18.8648 6.03976 19.0511 6.117ZM6 18.7987C6.00013 18.1776 6.24695 17.5821 6.68616 17.143L14.4979 9.33123L16.6694 11.5027L8.85763 19.3145C8.41855 19.7537 7.82299 20.0005 7.20195 20.0006H6V18.7987Z" fill="#3F2C0D" />
                      </svg>
                    </button>

                    <button>
                      <svg width="35" height="35" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="25.36" height="25.36" rx="5" fill="#82DCC6" />
                        <path d="M17.8211 7.38155C18.063 7.13348 18.3849 6.99634 18.7189 6.99906C19.0529 7.00179 19.3728 7.14416 19.6112 7.39614C19.8495 7.64813 19.9877 7.99001 19.9965 8.34965C20.0054 8.70929 19.8842 9.05856 19.6585 9.32377L12.807 18.5539C12.6892 18.6906 12.547 18.8003 12.389 18.8764C12.2309 18.9526 12.0602 18.9936 11.8871 18.9971C11.7139 19.0005 11.542 18.9663 11.3814 18.8965C11.2208 18.8267 11.0749 18.7228 10.9525 18.5909L6.40892 13.6965C6.28239 13.5695 6.1809 13.4164 6.11051 13.2462C6.04012 13.076 6.00227 12.8923 5.99922 12.706C5.99617 12.5198 6.02798 12.3347 6.09276 12.162C6.15753 11.9892 6.25394 11.8323 6.37623 11.7006C6.49852 11.5689 6.6442 11.465 6.80456 11.3952C6.96492 11.3255 7.13669 11.2912 7.30961 11.2945C7.48253 11.2978 7.65307 11.3385 7.81104 11.4144C7.96902 11.4902 8.1112 11.5995 8.2291 11.7358L11.8248 15.6073L17.7885 7.42225C17.7992 7.40801 17.8107 7.39442 17.8228 7.38155H17.8211Z" fill="#073D2F" />
                      </svg>
                    </button>
                  </td>
                </tr>
              <?php endfor ?>
            </tbody>
          </table>
        </div>
        <!-- end table Pembayaran -->
      </div>
      <!-- end atas -->

      <!-- bawah -->
      <div>
        <!-- pagination and info data -->
        <div class="flex flex-col-reverse mt-[30px] items-center">
          <div class="flex flex-row justify-center">
            <?php for ($i = 1; $i <= 6; $i++) : ?>
              <div class="flex justify-center items-center h-10 w-10 mx-1 rounded-sm font-ex-bold bg-white border-solid border-[1px] border-[#DADADA] hover:bg-[#5C6171] hover:text-white transition ease-in-out"><?= $i ?></div>
            <?php endfor ?>
          </div>
          <p class="mb-3">20 from 120 data</p>
        </div>
        <!-- end pagination -->
      </div>
      <!-- end bawah -->

    </div>
    <!-- End main conent -->
  </div>

  <script src="../js/jquery-3.6.1.min.js"></script>
  <script src="../js/sweetalert2.min.js"></script>
  <script>
    console.log($(document).width());

    // load sidebar
    $("#ex-sidebar").load("../assets/components/sidebar.html", function() {
      $('#tab_invoice').addClass("hover-sidebar");

    });

    // tab bar

    $('#tab_Pembelian').on("click", function() {
      $('#tab_Pembelian').addClass("font-ex-semibold");
      $('#tab_Proses').removeClass("font-ex-semibold");
      $('#tab_Pembayaran').removeClass("font-ex-semibold");

      $('#table_Pembelian').addClass("flex");
      $('#table_Pembelian').removeClass("hidden");

      $('#table_Proses').addClass("hidden");
      $('#table_Proses').removeClass("flex");

      $('#table_Pembayaran').addClass("hidden");
      $('#table_Pembayaran').removeClass("flex");

    });
    $('#tab_Proses').on("click", function() {
      $('#tab_Pembelian').removeClass("font-ex-semibold");
      $('#tab_Proses').addClass("font-ex-semibold");
      $('#tab_Pembayaran').removeClass("font-ex-semibold");

      $('#table_Pembelian').addClass("hidden");
      $('#table_Pembelian').removeClass("flex");

      $('#table_Proses').addClass("flex");
      $('#table_Proses').removeClass("hidden");

      $('#table_Pembayaran').addClass("hidden");
      $('#table_Pembayaran').removeClass("flex");

    });
    $('#tab_Pembayaran').on("click", function() {
      $('#tab_Pembelian').removeClass("font-ex-semibold");
      $('#tab_Proses').removeClass("font-ex-semibold");
      $('#tab_Pembayaran').addClass("font-ex-semibold");

      $('#table_Pembelian').addClass("hidden");
      $('#table_Pembelian').removeClass("flex");

      $('#table_Proses').addClass("hidden");
      $('#table_Proses').removeClass("flex");

      $('#table_Pembayaran').addClass("flex");
      $('#table_Pembayaran').removeClass("hidden");

    });



    // hide show sidebar

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


    // tab bar
    function tab(point) {
      if (point == "1") {
        $('#tab_bar_invoice').addClass("pointer1");
        $('#tab_bar_invoice').removeClass('pointer2');
        $('#tab_bar_invoice').removeClass('pointer3');
      } else if (point == "2") {
        $('#tab_bar_invoice').removeClass('pointer1');
        $('#tab_bar_invoice').addClass('pointer2');
        $('#tab_bar_invoice').removeClass('pointer3');
      } else if (point == "3") {
        $('#tab_bar_invoice').removeClass('pointer1');
        $('#tab_bar_invoice').removeClass('pointer2');
        $('#tab_bar_invoice').addClass('pointer3');
      }
    }


    // modal edit pembayaran
    $("#modal_edit_bayar").load("../assets/components/modal_edit_invoice.html", function() {
      $('#close_pembayaran').on('click', function() {
        $('#modal_edit_bayar').addClass('scale-0');
        $('#bgbody').addClass('scale-0');
        $('#bgbody').removeClass('effectmodal');
      })
    });

    function show_pembayaran() {
      $('#bgbody').addClass('effectmodal');
      $('#bgbody').removeClass('scale-0');
      $('#modal_edit_bayar').removeClass('scale-0');
    }

    // modal edit tracking
    $("#modal_edit_tracking").load("../assets/components/modal_edit_tracking_invoice.html", function() {
      $('#close_tracking').on('click', function() {
        $('#modal_edit_tracking').addClass("scale-0");
        $('#bgbody').addClass('scale-0');
        $('#bgbody').removeClass('effectmodal');
      })
    });

    function show_tracking() {
      $('#bgbody').addClass('effectmodal');
      $('#bgbody').removeClass('scale-0');
      $('#modal_edit_tracking').removeClass('scale-0');
    }

    // modal detail invoice
    $("#modal_detail_invoice").load("../assets/components/modal_detail_invoice.html", function() {
      $('#close_detail').on('click', function() {
        console.log("pppppphello");
        $('#modal_detail_invoice').addClass("scale-0");
        $('#bgbody').addClass('scale-0');
        $('#bgbody').removeClass('effectmodal');
      })
    });

    function show_detail() {
      $('#bgbody').addClass('effectmodal');
      $('#bgbody').removeClass('scale-0');
      $('#modal_detail_invoice').removeClass('scale-0');
    }
  </script>

</body>

</html>
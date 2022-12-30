<?php

session_start();
date_default_timezone_set("Asia/Bangkok");
include "../config/koneksi.php";

$datenow = getdate();

$crud = new koneksi();
$idPeg = $_SESSION["idPeg"];

$dataCart = $crud->showData("SELECT keranjang.kode_pesanan, keranjang_frame.harga AS harga_frame, keranjang_lensa.harga AS harga_lensa, keranjang.total FROM keranjang_frame RIGHT JOIN keranjang ON keranjang_frame.kode_pesanan = keranjang.kode_pesanan LEFT JOIN keranjang_lensa ON keranjang_lensa.kode_pesanan = keranjang.kode_pesanan WHERE keranjang.id_pegawai = '" . $idPeg . "'");

function jenis($lensa, $frame)
{

  $status = "";
  $harga = 0;

  if ($lensa !== null && $frame  !== null) {
    $status = "Frame & Lensa";
  } elseif ($lensa == null && $frame  !== null) {
    $status = "Frame";
  } elseif ($lensa !== null && $frame  == null) {
    $status = "Lensa";
  }

  return $status;
}

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
  <title>Keranjang</title>
  <link rel="stylesheet" href="../css/output.css">
  <link rel="stylesheet" href="../css/sweetalert2.min.css">
</head>

<body class="scrollbar-hide bg-[#ECECEC]">

  <section id="pembayaran" class="hidden bg-white">
    <section id="header" class="fixed z-[50] w-full top-0">
      <div class="flex flex-row px-8 py-6 shadow-md bg-white">
        <button onclick="backToKeranjang()">
          <svg class="my-[2px]" width="9" height="19" viewBox="0 0 9 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 1.18543C8.99973 1.50063 8.87945 1.80281 8.66559 2.02555L2.83474 8.10612C2.65826 8.29012 2.51825 8.50857 2.42274 8.749C2.32722 8.98943 2.27806 9.24713 2.27806 9.50738C2.27806 9.76763 2.32722 10.0253 2.42274 10.2658C2.51825 10.5062 2.65826 10.7246 2.83474 10.9086L8.65799 16.9852C8.86566 17.2095 8.98057 17.5098 8.97797 17.8215C8.97537 18.1332 8.85548 18.4314 8.64411 18.6518C8.43274 18.8722 8.1468 18.9972 7.84789 19C7.54898 19.0027 7.26101 18.8828 7.046 18.6663L1.22275 12.5944C0.439753 11.7763 9.53674e-07 10.6676 9.53674e-07 9.51174C9.53674e-07 8.35585 0.439753 7.24719 1.22275 6.42905L7.0536 0.348482C7.21281 0.182346 7.41564 0.0691128 7.63649 0.0230694C7.85735 -0.022974 8.08634 0.000234604 8.29456 0.0897694C8.50278 0.179304 8.68091 0.331152 8.80646 0.526152C8.932 0.721149 8.99935 0.95056 9 1.18543Z" fill="#373F47" />
          </svg>
        </button>
        <h1 class="px-6 font-ex-semibold">Pembayaran</h1>
      </div>
    </section>

    <section class="text-[#373F47] font-ex-medium mt-[70px] mb-24" id="konten">
      <div class="flex flex-col overflow-y-auto scrollbar-hide">
        <div class="bg-white h-[72px] drop-shadow-md mx-6 rounded-lg">
          <div class="flex flex-row justify-between items-center h-full px-4">

            <svg width="30" height="34" viewBox="0 0 30 34" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19.0911 8.5C19.4528 8.5 19.7996 8.64926 20.0553 8.91493C20.3111 9.18061 20.4547 9.54094 20.4547 9.91667C20.4547 10.2924 20.3111 10.6527 20.0553 10.9184C19.7996 11.1841 19.4528 11.3333 19.0911 11.3333H8.1819C7.82024 11.3333 7.47339 11.1841 7.21765 10.9184C6.96192 10.6527 6.81825 10.2924 6.81825 9.91667C6.81825 9.54094 6.96192 9.18061 7.21765 8.91493C7.47339 8.64926 7.82024 8.5 8.1819 8.5H19.0911ZM29.6007 33.5849C29.345 33.8505 28.9982 33.9997 28.6366 33.9997C28.2751 33.9997 27.9283 33.8505 27.6725 33.5849L24.3902 30.175C23.4182 30.8195 22.2897 31.1635 21.1366 31.1667C19.9229 31.1667 18.7365 30.7928 17.7274 30.0923C16.7182 29.3918 15.9317 28.3962 15.4673 27.2313C15.0028 26.0664 14.8813 24.7846 15.1181 23.548C15.3548 22.3113 15.9393 21.1754 16.7975 20.2839C17.6557 19.3923 18.7491 18.7851 19.9394 18.5392C21.1298 18.2932 22.3636 18.4194 23.4849 18.9019C24.6062 19.3844 25.5645 20.2015 26.2388 21.2499C26.9131 22.2983 27.273 23.5308 27.273 24.7917C27.2699 25.9896 26.9388 27.162 26.3184 28.1718L29.6007 31.5817C29.8564 31.8474 30 32.2077 30 32.5833C30 32.959 29.8564 33.3193 29.6007 33.5849ZM21.1366 28.3333C21.8108 28.3333 22.4699 28.1256 23.0306 27.7365C23.5912 27.3473 24.0282 26.7942 24.2862 26.147C24.5442 25.4998 24.6117 24.7877 24.4802 24.1007C24.3486 23.4137 24.024 22.7826 23.5472 22.2873C23.0704 21.792 22.463 21.4547 21.8017 21.3181C21.1404 21.1814 20.4549 21.2515 19.832 21.5196C19.209 21.7877 18.6766 22.2416 18.302 22.824C17.9274 23.4064 17.7274 24.0912 17.7274 24.7917C17.7274 25.731 18.0866 26.6318 18.726 27.296C19.3653 27.9602 20.2324 28.3333 21.1366 28.3333ZM15.0001 31.1667H6.81825C5.73326 31.1667 4.69271 30.7189 3.92551 29.9219C3.15831 29.1248 2.7273 28.0438 2.7273 26.9167V7.08333C2.7273 5.95616 3.15831 4.87516 3.92551 4.07813C4.69271 3.2811 5.73326 2.83333 6.81825 2.83333H23.182C23.5437 2.83333 23.8906 2.98259 24.1463 3.24827C24.402 3.51394 24.5457 3.87428 24.5457 4.25V15.5833C24.5457 15.9591 24.6894 16.3194 24.9451 16.5851C25.2008 16.8507 25.5477 17 25.9093 17C26.271 17 26.6179 16.8507 26.8736 16.5851C27.1293 16.3194 27.273 15.9591 27.273 15.5833V4.25C27.273 3.12283 26.842 2.04183 26.0748 1.2448C25.3076 0.447767 24.267 0 23.182 0L6.81825 0C5.0106 0.00224946 3.27761 0.749249 1.99941 2.07714C0.72121 3.40504 0.00216528 5.20541 0 7.08333V26.9167C0.00216528 28.7946 0.72121 30.595 1.99941 31.9229C3.27761 33.2508 5.0106 33.9977 6.81825 34H15.0001C15.3618 34 15.7087 33.8507 15.9644 33.5851C16.2201 33.3194 16.3638 32.9591 16.3638 32.5833C16.3638 32.2076 16.2201 31.8473 15.9644 31.5816C15.7087 31.3159 15.3618 31.1667 15.0001 31.1667Z" fill="#4F4F4F" />
            </svg>
            <h1>Detail Pesanan</h1>
            <button onclick="cekDetailPesanan()">

              <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g filter="url(#filter0_d_1200_459)">
                  <circle cx="17" cy="17" r="13" transform="rotate(-180 17 17)" fill="#444D68" />
                  <path d="M14.5107 21.5995C14.5109 21.4251 14.5774 21.258 14.6957 21.1347L17.9213 17.771C18.0189 17.6692 18.0964 17.5484 18.1492 17.4154C18.2021 17.2824 18.2293 17.1398 18.2293 16.9959C18.2293 16.8519 18.2021 16.7093 18.1492 16.5763C18.0964 16.4433 18.0189 16.3225 17.9213 16.2207L14.6999 12.8592C14.5851 12.7351 14.5215 12.569 14.5229 12.3966C14.5244 12.2241 14.5907 12.0592 14.7076 11.9373C14.8245 11.8153 14.9827 11.7462 15.1481 11.7447C15.3134 11.7432 15.4727 11.8094 15.5917 11.9292L18.8131 15.2881C19.2462 15.7407 19.4895 16.354 19.4895 16.9935C19.4895 17.6329 19.2462 18.2462 18.8131 18.6988L15.5875 22.0625C15.4994 22.1544 15.3872 22.217 15.265 22.2425C15.1428 22.268 15.0162 22.2551 14.901 22.2056C14.7858 22.1561 14.6873 22.0721 14.6178 21.9642C14.5484 21.8563 14.5111 21.7294 14.5107 21.5995Z" fill="white" />
                </g>
                <defs>
                  <filter id="filter0_d_1200_459" x="0" y="0" width="34" height="34" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                    <feOffset />
                    <feGaussianBlur stdDeviation="2" />
                    <feComposite in2="hardAlpha" operator="out" />
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1200_459" />
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1200_459" result="shape" />
                  </filter>
                </defs>
              </svg>
            </button>


          </div>
        </div>
        <h1 class="font-ex-semibold px-6 pt-8">Detail Custommer</h1>
        <div class="flex flex-col px-6 py-4 bg-white mt-[0.5px] font-ex-medium">
          <h1 class="pt-4">Nama</h1>
          <input class="cursor-pointer px-4 outline-0 mt-3 md:mt-6 h-16 border-[1px] bg-white border-[#D9D9D9] rounded-md overflow-hidden" type="text" placeholder="" name="" id="txt_nama">
          <h1 class="pt-6">No Telepon</h1>
          <input class="cursor-pointer px-4 outline-0 mt-3 md:mt-6 h-16 border-[1px] bg-white border-[#D9D9D9] rounded-md overflow-hidden" type="text" placeholder="" name="" id="txt_nohp">
          <h1 class="pt-6">Pekerjaan / Instansi</h1>
          <div class="px-4 flex flex-row justify-between items-center outline-0 mt-3 md:mt-6 h-16 border-[1px] bg-white border-[#D9D9D9] rounded-md overflow-hidden">
            <input class="cursor-pointer h-full w-full pr-4 outline-0" type="text" placeholder="" name="" id="txt_pekerjaan">
            <h1 class="h-full flex items-center justify-center font-ex-semibold w-12 text-center">/</h1>
            <input class="cursor-pointer h-full w-full pl-4 outline-0" type="text" placeholder="" name="" id="txt_instansi">
          </div>
        </div>
        <h1 class="font-ex-semibold px-6 pt-8">Detail Alamat</h1>
        <div class="flex flex-col px-6 py-4 bg-white mt-[0.5px] font-ex-medium">

          <h1 class="pt-6">Kecamatan / Desa</h1>
          <div class="px-4 flex flex-row justify-between items-center outline-0 mt-3 md:mt-6 h-16 border-[1px] bg-white border-[#D9D9D9] rounded-md overflow-hidden">
            <input class="cursor-pointer h-full w-full pr-4 outline-0" type="text" placeholder="" name="" id="txt_kecamatan">
            <h1 class="h-full flex items-center justify-center font-ex-semibold w-12 text-center">/</h1>
            <input class="cursor-pointer h-full w-full pl-4 outline-0" type="text" placeholder="" name="" id="txt_desa">
          </div>
          <h1 class="pt-6">Alamat</h1>
          <div class="h-[167px] w-full border border-[#C9C9C9] rounded-lg mt-3 overflow-hidden">
            <textarea id="txt_alamat" rows="4" class="block h-full w-full border-0 outline-none px-4 py-2" placeholder=""></textarea>
          </div>


        </div>

        <h1 class="font-ex-semibold px-6 pt-8">Pembayaran</h1>
        <div class="flex flex-col px-6 py-4 bg-white mt-[0.5px] font-ex-medium">
          <h1 class="pt-6">Pilih Pembayaran</h1>
          <select class="px-4 cursor-pointer outline-0 mt-3 md:mt-6 h-16 border-[1px] bg-white border-[#D9D9D9] rounded-md overflow-hidden" name="opsi-pembayaran" id="opsi-pembayaran">
            <option class="text-xs" value="Lunas">Lunas</option>
            <option class="text-xs" value="Cicilan">Cicilan</option>
          </select>
          <div id="field-jatuh-tgl-tempo" class="hidden">
            <h1 class="pt-6">Tanggal Jatuh Tempo</h1>
            <div class="h-16 w-full border border-[#C9C9C9] rounded-lg mt-3 overflow-hidden">
              <input type="date" id="tgljatuhtempo" class="h-full w-full" min="<?= $datenow['year'] . '-' . $datenow['mon'] . '-' . $datenow['mday']; ?>">
            </div>
          </div>
          <h1 class="pt-6">Depan Bayar</h1>
          <input class="cursor-pointer px-4 outline-0 mt-3 md:mt-6 h-16 border-[1px] bg-white border-[#D9D9D9] rounded-md overflow-hidden" type="text" placeholder="" name="" id="txt_bayar">
        </div>
      </div>
    </section>
    <div class="fixed z-[50] font-ex-medium flex flex-col w-full my-auto bg-white py-6 bottom-0">
      <div class="h-[1px] -translate-y-[24px] w-full bg-[#C9C9C9]"></div>
      <div class="flex flex-row justify-between w-full gap-4 h-full px-6 items-center">
        <div class="flex flex-col">
          <h1>Total</h1>
          <h1 id="total_harga_keranjang2" class="font-ex-semibold">Rp. 0</h1>
        </div>
        <button onclick="submitTransaksi()" class="bg-[#444D68] w-1/2 h-12 text-center rounded-xl py-1 text-white font-ex-semibold flex justify-center items-center">
          <p>Lanjut Proses</p>
        </button>
      </div>
    </div>
  </section>

  <section id="keranjang" class="">
    <!-- modal deail -->
    <div id="modal_detail"></div>

    <section id="header" class="fixed z-[50] w-full top-0">
      <div class="flex flex-row px-8 py-6 justify-between shadow-sm bg-white">
        <a href="dashboard.php">
          <svg class="my-[2px]" width="9" height="19" viewBox="0 0 9 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 1.18543C8.99973 1.50063 8.87945 1.80281 8.66559 2.02555L2.83474 8.10612C2.65826 8.29012 2.51825 8.50857 2.42274 8.749C2.32722 8.98943 2.27806 9.24713 2.27806 9.50738C2.27806 9.76763 2.32722 10.0253 2.42274 10.2658C2.51825 10.5062 2.65826 10.7246 2.83474 10.9086L8.65799 16.9852C8.86566 17.2095 8.98057 17.5098 8.97797 17.8215C8.97537 18.1332 8.85548 18.4314 8.64411 18.6518C8.43274 18.8722 8.1468 18.9972 7.84789 19C7.54898 19.0027 7.26101 18.8828 7.046 18.6663L1.22275 12.5944C0.439753 11.7763 9.53674e-07 10.6676 9.53674e-07 9.51174C9.53674e-07 8.35585 0.439753 7.24719 1.22275 6.42905L7.0536 0.348482C7.21281 0.182346 7.41564 0.0691128 7.63649 0.0230694C7.85735 -0.022974 8.08634 0.000234604 8.29456 0.0897694C8.50278 0.179304 8.68091 0.331152 8.80646 0.526152C8.932 0.721149 8.99935 0.95056 9 1.18543Z" fill="#373F47" />
          </svg>
        </a>
        <h1 class="px-6 font-ex-semibold">Keranjang</h1>

        <svg class="my-[2px]" width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15.2 3.16667H12.72C12.5343 2.2732 12.0431 1.4704 11.329 0.893568C10.6149 0.316738 9.72176 0.0011515 8.8 0L7.2 0C6.27824 0.0011515 5.38505 0.316738 4.671 0.893568C3.95694 1.4704 3.46568 2.2732 3.28 3.16667H0.8C0.587827 3.16667 0.384344 3.25007 0.234315 3.39854C0.0842854 3.54701 0 3.74837 0 3.95833C0 4.1683 0.0842854 4.36966 0.234315 4.51813C0.384344 4.66659 0.587827 4.75 0.8 4.75H1.6V15.0417C1.60127 16.0911 2.02311 17.0972 2.77298 17.8392C3.52285 18.5813 4.53952 18.9987 5.6 19H10.4C11.4605 18.9987 12.4772 18.5813 13.227 17.8392C13.9769 17.0972 14.3987 16.0911 14.4 15.0417V4.75H15.2C15.4122 4.75 15.6157 4.66659 15.7657 4.51813C15.9157 4.36966 16 4.1683 16 3.95833C16 3.74837 15.9157 3.54701 15.7657 3.39854C15.6157 3.25007 15.4122 3.16667 15.2 3.16667ZM7.2 1.58333H8.8C9.29622 1.58393 9.7801 1.73642 10.1853 2.01989C10.5905 2.30336 10.8971 2.70393 11.0632 3.16667H4.9368C5.10287 2.70393 5.40952 2.30336 5.81471 2.01989C6.2199 1.73642 6.70378 1.58393 7.2 1.58333ZM12.8 15.0417C12.8 15.6716 12.5471 16.2756 12.0971 16.721C11.647 17.1664 11.0365 17.4167 10.4 17.4167H5.6C4.96348 17.4167 4.35303 17.1664 3.90294 16.721C3.45286 16.2756 3.2 15.6716 3.2 15.0417V4.75H12.8V15.0417Z" fill="#373F47" />
          <path d="M6.39999 14.25C6.61216 14.25 6.81564 14.1666 6.96567 14.0181C7.1157 13.8697 7.19999 13.6683 7.19999 13.4583V8.70833C7.19999 8.49837 7.1157 8.29701 6.96567 8.14854C6.81564 8.00007 6.61216 7.91667 6.39999 7.91667C6.18781 7.91667 5.98433 8.00007 5.8343 8.14854C5.68427 8.29701 5.59999 8.49837 5.59999 8.70833V13.4583C5.59999 13.6683 5.68427 13.8697 5.8343 14.0181C5.98433 14.1666 6.18781 14.25 6.39999 14.25Z" fill="#373F47" />
          <path d="M9.59997 14.25C9.81215 14.25 10.0156 14.1666 10.1657 14.0181C10.3157 13.8697 10.4 13.6683 10.4 13.4583V8.70833C10.4 8.49837 10.3157 8.29701 10.1657 8.14854C10.0156 8.00007 9.81215 7.91667 9.59997 7.91667C9.3878 7.91667 9.18432 8.00007 9.03429 8.14854C8.88426 8.29701 8.79998 8.49837 8.79998 8.70833V13.4583C8.79998 13.6683 8.88426 13.8697 9.03429 14.0181C9.18432 14.1666 9.3878 14.25 9.59997 14.25Z" fill="#373F47" />
        </svg>

      </div>
    </section>

    <section class="text-[#373F47] font-ex-medium mt-20 mb-24" id="konten">
      <div class=" overflow-y-scroll scrollbar-hide">

        <?php foreach ($dataCart as $index) : ?>

          <div class="bg-white my-4 mx-6 rounded-lg shadow-sm">
            <div class="flex flex-row relative">
              <div class="flex items-center px-2">
                <input onclick="choise_transaction('<?= $index['kode_pesanan'] ?>', '<?= $index['total'] ?>')" type="checkbox" id="TR-<?= $index['kode_pesanan'] ?>" class="z-40">
              </div>
              <img class="w-[109px] h-[109px] object-cover p-2 rounded-2xl overflow-hidden" src="../assets/images/heroimg.png" alt="">
              <div class="flex flex-col items-start my-auto text-sm gap-2 pl-2">
                <h1 class="font-ex-semibold"><?= jenis($index["harga_lensa"], $index["harga_frame"]) ?></h1>
                <h1 id="total-<?= $index['kode_pesanan'] ?>"><?= rupiah($index["total"]) ?></h1>
              </div>
              <div class="flex flex-row h-full w-full absolute justify-end gap-3 p-3">

                <div class="cursor-pointer pt-[1px]" onclick="showDetail('<?= $index['kode_pesanan'] ?>')">
                  <svg width="15" height="17" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.54555 4.25C9.72638 4.25 9.8998 4.32463 10.0277 4.45747C10.1555 4.5903 10.2274 4.77047 10.2274 4.95833C10.2274 5.14619 10.1555 5.32636 10.0277 5.4592C9.8998 5.59204 9.72638 5.66667 9.54555 5.66667H4.09095C3.91012 5.66667 3.73669 5.59204 3.60883 5.4592C3.48096 5.32636 3.40912 5.14619 3.40912 4.95833C3.40912 4.77047 3.48096 4.5903 3.60883 4.45747C3.73669 4.32463 3.91012 4.25 4.09095 4.25H9.54555ZM14.8004 16.7925C14.6725 16.9253 14.4991 16.9998 14.3183 16.9998C14.1375 16.9998 13.9641 16.9253 13.8363 16.7925L12.1951 15.0875C11.7091 15.4098 11.1449 15.5817 10.5683 15.5833C9.96145 15.5833 9.36824 15.3964 8.86368 15.0461C8.35911 14.6959 7.96585 14.1981 7.73363 13.6156C7.5014 13.0332 7.44064 12.3923 7.55903 11.774C7.67741 11.1557 7.96963 10.5877 8.39873 10.1419C8.82783 9.69615 9.37453 9.39257 9.96971 9.26958C10.5649 9.14659 11.1818 9.20971 11.7424 9.45097C12.3031 9.69222 12.7823 10.1008 13.1194 10.625C13.4565 11.1491 13.6365 11.7654 13.6365 12.3958C13.635 12.9948 13.4694 13.581 13.1592 14.0859L14.8004 15.7909C14.9282 15.9237 15 16.1038 15 16.2917C15 16.4795 14.9282 16.6596 14.8004 16.7925ZM10.5683 14.1667C10.9054 14.1667 11.235 14.0628 11.5153 13.8682C11.7956 13.6736 12.0141 13.3971 12.1431 13.0735C12.2721 12.7499 12.3059 12.3939 12.2401 12.0504C12.1743 11.7069 12.012 11.3913 11.7736 11.1437C11.5352 10.896 11.2315 10.7274 10.9008 10.659C10.5702 10.5907 10.2274 10.6258 9.91598 10.7598C9.60451 10.8938 9.33829 11.1208 9.15099 11.412C8.96369 11.7032 8.86372 12.0456 8.86372 12.3958C8.86372 12.8655 9.04331 13.3159 9.36298 13.648C9.68264 13.9801 10.1162 14.1667 10.5683 14.1667ZM7.50007 15.5833H3.40912C2.86663 15.5833 2.34636 15.3595 1.96276 14.9609C1.57915 14.5624 1.36365 14.0219 1.36365 13.4583V3.54167C1.36365 2.97808 1.57915 2.43758 1.96276 2.03906C2.34636 1.64055 2.86663 1.41667 3.40912 1.41667H11.591C11.7719 1.41667 11.9453 1.49129 12.0731 1.62413C12.201 1.75697 12.2728 1.93714 12.2728 2.125V7.79167C12.2728 7.97953 12.3447 8.1597 12.4725 8.29253C12.6004 8.42537 12.7738 8.5 12.9547 8.5C13.1355 8.5 13.3089 8.42537 13.4368 8.29253C13.5647 8.1597 13.6365 7.97953 13.6365 7.79167V2.125C13.6365 1.56141 13.421 1.02091 13.0374 0.622398C12.6538 0.223883 12.1335 0 11.591 0L3.40912 0C2.5053 0.00112473 1.63881 0.374625 0.999705 1.03857C0.360605 1.70252 0.00108264 2.6027 0 3.54167V13.4583C0.00108264 14.3973 0.360605 15.2975 0.999705 15.9614C1.63881 16.6254 2.5053 16.9989 3.40912 17H7.50007C7.6809 17 7.85433 16.9254 7.9822 16.7925C8.11006 16.6597 8.1819 16.4795 8.1819 16.2917C8.1819 16.1038 8.11006 15.9236 7.9822 15.7908C7.85433 15.658 7.6809 15.5833 7.50007 15.5833Z" fill="#575E65" />
                  </svg>
                </div>

                <div class="cursor-pointer">
                  <svg width="15" height="18" viewBox="0 0 15 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.25 3H11.925C11.7509 2.15356 11.2904 1.39301 10.6209 0.846539C9.95151 0.300068 9.11415 0.00109089 8.25 0L6.75 0C5.88585 0.00109089 5.04849 0.300068 4.37906 0.846539C3.70964 1.39301 3.24907 2.15356 3.075 3H0.75C0.551088 3 0.360322 3.07902 0.21967 3.21967C0.0790176 3.36032 0 3.55109 0 3.75C0 3.94891 0.0790176 4.13968 0.21967 4.28033C0.360322 4.42098 0.551088 4.5 0.75 4.5H1.5V14.25C1.50119 15.2442 1.89666 16.1973 2.59967 16.9003C3.30267 17.6033 4.2558 17.9988 5.25 18H9.75C10.7442 17.9988 11.6973 17.6033 12.4003 16.9003C13.1033 16.1973 13.4988 15.2442 13.5 14.25V4.5H14.25C14.4489 4.5 14.6397 4.42098 14.7803 4.28033C14.921 4.13968 15 3.94891 15 3.75C15 3.55109 14.921 3.36032 14.7803 3.21967C14.6397 3.07902 14.4489 3 14.25 3ZM6.75 1.5H8.25C8.71521 1.50057 9.16885 1.64503 9.54871 1.91358C9.92857 2.18213 10.2161 2.56162 10.3717 3H4.62825C4.78394 2.56162 5.07143 2.18213 5.45129 1.91358C5.83116 1.64503 6.28479 1.50057 6.75 1.5ZM12 14.25C12 14.8467 11.7629 15.419 11.341 15.841C10.919 16.2629 10.3467 16.5 9.75 16.5H5.25C4.65326 16.5 4.08097 16.2629 3.65901 15.841C3.23705 15.419 3 14.8467 3 14.25V4.5H12V14.25Z" fill="#5F676F" />
                    <path d="M5.99999 13.5C6.1989 13.5 6.38967 13.421 6.53032 13.2803C6.67097 13.1397 6.74999 12.9489 6.74999 12.75V8.25C6.74999 8.05109 6.67097 7.86032 6.53032 7.71967C6.38967 7.57902 6.1989 7.5 5.99999 7.5C5.80108 7.5 5.61031 7.57902 5.46966 7.71967C5.32901 7.86032 5.24999 8.05109 5.24999 8.25V12.75C5.24999 12.9489 5.32901 13.1397 5.46966 13.2803C5.61031 13.421 5.80108 13.5 5.99999 13.5Z" fill="#5F676F" />
                    <path d="M8.99998 13.5C9.19889 13.5 9.38966 13.421 9.53031 13.2803C9.67096 13.1397 9.74998 12.9489 9.74998 12.75V8.25C9.74998 8.05109 9.67096 7.86032 9.53031 7.71967C9.38966 7.57902 9.19889 7.5 8.99998 7.5C8.80106 7.5 8.6103 7.57902 8.46965 7.71967C8.32899 7.86032 8.24998 8.05109 8.24998 8.25V12.75C8.24998 12.9489 8.32899 13.1397 8.46965 13.2803C8.6103 13.421 8.80106 13.5 8.99998 13.5Z" fill="#5F676F" />
                  </svg>
                </div>

              </div>

            </div>
          </div>
        <?php endforeach ?>

      </div>
    </section>
    <div class="fixed z-[50] font-ex-medium flex flex-col w-full my-auto bg-white py-6 items-center bottom-0">
      <div class="h-[1px] -translate-y-[24px] w-full bg-[#C9C9C9]"></div>

      <div class="flex flex-row justify-between gap-4 w-full h-full px-8 items-center">
        <div class="flex flex-col">
          <h1>Total</h1>
          <h1 id="total_harga_keranjang" class="font-ex-semibold">Rp. 0</h1>
        </div>

        <div onclick="next_page()" class="bg-[#444D68] h-12 w-1/2 text-center rounded-[50px] text-white font-ex-semibold flex justify-center items-center">
          <p>Lanjutkan</p>
        </div>


      </div>
    </div>
  </section>



  <script src="../js/jquery-3.6.1.min.js"></script>
  <script src="../js/sweetalert2.min.js"></script>
  <script>
    /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('txt_bayar');
    dengan_rupiah.addEventListener('keyup', function(e) {
      dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
    });


    function getDateNow() {
      var date = new Date();
      var strdate = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
      return strdate;
    }

    $('#tgljatuhtempo').val(getDateNow());

    $('#modal_detail').load('../assets/components/modal_detail_keranjang.html', function() {
      $('#button_x').on('click', function() {
        $('#container').addClass("scale-0");
        $('#bgmodal').removeClass("effectmodal");
        $('#main_content').html("");
        reset();
      })

      $('#btn_ok').on('click', function() {
        $('#container').addClass("scale-0");
        $('#bgmodal').removeClass("effectmodal");
        $('#main_content').html("");
        reset();
      })
    })

    function showDetail(idtransaksi) {
      $('#container').removeClass("scale-0");
      $('#bgmodal').addClass("effectmodal");

      var kontenhtml = "";

      $.ajax({
        url: '../controllers/detailTransaksiController.php?id_transaksi=' + idtransaksi,
        type: 'GET',
        beforeSend: function() {
          $('#main_content').html("<div class='h-[500px] w-full flex justify-center items-center'>Loading...</div>");
        },
        success: function(res) {
          const data = JSON.parse(res);
          const finalData = data[0];
          console.log(finalData);

          // kontenhtml += '<tr>';
          if (finalData.merk !== null) {
            kontenhtml += '<div class="flex flex-row mb-2">'
            kontenhtml += '<p class="w-[50%] font-ex-semibold">Frame</p>'
            kontenhtml += '<p class="w-[5%]">:</p>'
            kontenhtml += '<p>' + finalData.merk + '</p>'
            kontenhtml += '</div>'
          }
          if (finalData.nama_lensa.length !== 0) {
            kontenhtml += '<div class="flex flex-row mb-2">'
            kontenhtml += '<p class="w-[50%] font-ex-semibold">Jenis Lensa</p>'
            kontenhtml += '<p class="w-[5%]">:</p>'
            kontenhtml += '<p>' + finalData.nama_jenis_lensa + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row mb-2">'
            kontenhtml += '<p class="w-[50%] font-ex-semibold">Variant Lensa</p>'
            kontenhtml += '<p class="w-[5%]">:</p>'
            kontenhtml += '<div class="flex flex-col">'
            for (var index = 0; index < finalData.nama_lensa.length; index++) {
              kontenhtml += '<p class="mb-2">' + finalData.nama_lensa[index] + '</p>'
            }
            kontenhtml += '</div>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row mb-2">'
            kontenhtml += '<p class="font-ex-semibold">Resep</p>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row mb-2">'
            kontenhtml += '<p class="w-[50%] font-ex-semibold">Kanan</p>'
            kontenhtml += '<p class="w-[5%]">:</p>'
            kontenhtml += '<div class="flex flex-col">'
            kontenhtml += '<div class="flex flex-row gap-3 mb-2">'
            kontenhtml += '<p class="w-[50%]">SPH</p>'
            kontenhtml += '<p>:</p>'
            kontenhtml += '<p>' + finalData.kn_sph + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row gap-3 mb-2">'
            kontenhtml += '<p class="w-[50%]">CYL</p>'
            kontenhtml += '<p>:</p>'
            kontenhtml += '<p>' + finalData.kn_cyl + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row gap-3 mb-2">'
            kontenhtml += '<p class="w-[50%]">AXIS</p>'
            kontenhtml += '<p>:</p>'
            kontenhtml += '<p>' + finalData.kn_axis + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row gap-3 mb-2">'
            kontenhtml += '<p class="w-[50%]">ADD+</p>'
            kontenhtml += '<p>:</p>'
            kontenhtml += '<p>' + finalData.kn_add + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row gap-3 mb-2">'
            kontenhtml += '<p class="w-[50%]">PD</p>'
            kontenhtml += '<p>:</p>'
            kontenhtml += '<p>' + finalData.kn_pd + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row gap-3 mb-2">'
            kontenhtml += '<p class="w-[50%]">SEG.</p>'
            kontenhtml += '<p>:</p>'
            kontenhtml += '<p>' + finalData.kn_seg + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '</div>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row mb-2">'
            kontenhtml += '<p class="w-[50%] font-ex-semibold">Kiri</p>'
            kontenhtml += '<p class="w-[5%]">:</p>'
            kontenhtml += '<div class="flex flex-col">'
            kontenhtml += '<div class="flex flex-row gap-3 mb-2">'
            kontenhtml += '<p class="w-[50%]">SPH</p>'
            kontenhtml += '<p>:</p>'
            kontenhtml += '<p>' + finalData.kr_sph + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row gap-3 mb-2">'
            kontenhtml += '<p class="w-[50%]">CYL</p>'
            kontenhtml += '<p>:</p>'
            kontenhtml += '<p>' + finalData.kr_cyl + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row gap-3 mb-2">'
            kontenhtml += '<p class="w-[50%]">AXIS</p>'
            kontenhtml += '<p>:</p>'
            kontenhtml += '<p>' + finalData.kr_axis + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row gap-3 mb-2">'
            kontenhtml += '<p class="w-[50%]">ADD+</p>'
            kontenhtml += '<p>:</p>'
            kontenhtml += '<p>' + finalData.kr_add + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row gap-3 mb-2">'
            kontenhtml += '<p class="w-[50%]">PD</p>'
            kontenhtml += '<p>:</p>'
            kontenhtml += '<p>' + finalData.kr_pd + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '<div class="flex flex-row gap-3 mb-2">'
            kontenhtml += '<p class="w-[50%]">SEG.</p>'
            kontenhtml += '<p>:</p>'
            kontenhtml += '<p>' + finalData.kr_seg + '</p>'
            kontenhtml += '</div>'
            kontenhtml += '</div>'
            kontenhtml += '</div>'
          }
          if (finalData.harga_frame !== null) {
            kontenhtml += '<div class="flex flex-row mb-2 mt-2">'
            kontenhtml += '<p class="w-[50%] font-ex-semibold">Harga Frame</p>'
            kontenhtml += '<p class="w-[5%]">:</p>'
            kontenhtml += '<p>' + formatRupiah(finalData.harga_frame, 'Rp. ') + '</p>'
            kontenhtml += '</div>'
          }
          if (finalData.harga_lensa !== null) {
            kontenhtml += '<div class="flex flex-row mb-2">'
            kontenhtml += '<p class="w-[50%] font-ex-semibold">Harga Lensa</p>'
            kontenhtml += '<p class="w-[5%]">:</p>'
            kontenhtml += '<p>' + formatRupiah(finalData.harga_lensa, 'Rp. ') + '</p>'
            kontenhtml += '</div>'
          }
          kontenhtml += '<div class="flex flex-row mb-2">'
          kontenhtml += '<p class="w-[50%] font-ex-semibold">Total</p>'
          kontenhtml += '<p class="w-[5%]">:</p>'
          kontenhtml += '<p>' + formatRupiah(finalData.total, 'Rp. ') + '</p>'
          kontenhtml += '</div>'

          $('#main_content').html(kontenhtml);
        }
      })
    }

    // checkbox
    let kodeTR = [];
    var total = 0;

    function choise_transaction(kode, harga) {

      if ($('#TR-' + kode).is(":checked")) {
        kodeTR.push({
          kode: kode,
        });

        total = total + parseInt(harga);
        $('#total_harga_keranjang').html(formatRupiah('' + total, 'Rp. '));
        $('#total_harga_keranjang2').html(formatRupiah('' + total, 'Rp. '));

        console.log(kodeTR);

      } else {
        for (let index = 0; index < kodeTR.length; index++) {
          const element = kodeTR[index];
          if (element['kode'] == kode) {
            removeItemOnce(kodeTR, element);
          }
        }
        total = total - parseInt(harga);
        $('#total_harga_keranjang').html(formatRupiah('' + total, 'Rp. '));
        $('#total_harga_keranjang2').html(formatRupiah('' + total, 'Rp. '));
        console.log(kodeTR);
      }
    }

    function removeItemOnce(arr, value) {
      var index = arr.indexOf(value);
      if (index > -1) {
        arr.splice(index, 1);
      }
      return arr;
    }

    // next page
    function next_page() {

      if (kodeTR.length !== 0) {
        var p = "";

        for (var i = 0; i < kodeTR.length; i++) {
          p = p + " " + kodeTR[i]["kode"];
        }

        $('#pembayaran').toggleClass('hidden');
        $('#keranjang').toggleClass('hidden');

        // Swal.fire({
        //   icon: 'success',
        //   title: 'Berhasil',
        //   text: p,
        // })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'gagal',
          text: "pilih pesanan yang ingin di checkout",
        })
      }

    }

    // curency
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

    // pembayaran
    function cekDetailPesanan() {
      var p = "";

      for (var i = 0; i < kodeTR.length; i++) {
        p = p + " " + kodeTR[i]["kode"];
      }

      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: p,
      })
    }

    function backToKeranjang() {
      $('#pembayaran').toggleClass('hidden');
      $('#keranjang').toggleClass('hidden');
    }

    $('#opsi-pembayaran').change(function() {
      total_harga_keranjang2
      if ($('#opsi-pembayaran').val() == 'Cicilan') {
        $('#field-jatuh-tgl-tempo').removeClass('hidden');
      } else {
        $('#field-jatuh-tgl-tempo').addClass('hidden');
      }
    });

    function generateTransaksiID() {
      var date = new Date();
      return "TR" + kodeTR.length + "" + date.getDate() + "" + (date.getMonth() + 1) + "" + date.getFullYear() + "" + date.getHours() + "" + date.getMinutes() + "" + date.getSeconds();
    }

    function convertProsesPembayaran() {
      switch ($('#opsi-pembayaran').val()) {
        case 'Lunas':
          return 1;
          break;
        case 'Cicilan':
          return 2;
          break;
        default:
          break;
      }
    }

    function submitTransaksi() {
      var nama = $('#txt_nama').val();
      var nohp = $('#txt_nohp').val();
      var pekerjaan = $('#txt_pekerjaan').val();
      var instansi = $('#txt_instansi').val();
      var kecamatan = $('#txt_kecamatan').val();
      var alamat = $('#txt_alamat').val();
      var bayar = parseInt($("#txt_bayar").val().replace("Rp. ", "").replace(".", "").replace(".", "").replace(" ", ""));
      var tgljatuhtempo = new Date($('#tgljatuhtempo').val());
      var desa = $('#txt_desa').val();

      var kembalian = 0;

      if ($('#opsi-pembayaran').val() == 'Lunas') {
        kembalian = bayar - total;

        if (bayar < total) {
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Jumlah bayar kurang dari total pesanan',
          });
        } else {
          $.ajax({
            url: "../controllers/transaksiController.php",
            type: 'POST',
            data: {
              'type': 'insert_lunas',
              'txt_nama': nama,
              'txt_nohp': nohp,
              'txt_pekerjaan': pekerjaan,
              'txt_instansi': instansi,
              'txt_kecamatan': kecamatan,
              'txt_desa': desa,
              'txt_alamat': alamat,
              'total': bayar,
              'total_harga': total,
              'data': JSON.stringify(kodeTR),
              'proses_pembayaran': convertProsesPembayaran(),
              'kembalian': kembalian,
              'tgljatuhtempo': getDateNow(),
              // 'tgljatuhtempo': tgljatuhtempo.getFullYear() + '-' + (tgljatuhtempo.getMonth() + 1) + '-' + tgljatuhtempo.getDate(),
            },
            success: function(res) {
              // alert(res);
              const data = JSON.parse(res);
              if (data.status == 'success') {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: data.msg,
                }).then(function() {
                  window.location.replace("dashboard.php");
                });
              }
            },
          });
        }
      } else if ($('#opsi-pembayaran').val() == 'Cicilan') {
        kembalian = 0;
        if (bayar >= total) {
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Jumlah bayar tidak sesuai dengan jenis pembayaran',
          });
        } else {
          $.ajax({
            url: "../controllers/transaksiController.php",
            type: 'POST',
            data: {
              'type': 'insert_cicilan',
              'txt_nama': nama,
              'txt_nohp': nohp,
              'txt_pekerjaan': pekerjaan,
              'txt_instansi': instansi,
              'txt_kecamatan': kecamatan,
              'txt_desa': desa,
              'txt_alamat': alamat,
              'total': bayar,
              'total_harga': total,
              'data': JSON.stringify(kodeTR),
              'proses_pembayaran': convertProsesPembayaran(),
              'kembalian': kembalian,
              'tgljatuhtempo': tgljatuhtempo.getFullYear() + '-' + (tgljatuhtempo.getMonth() + 1) + '-' + tgljatuhtempo.getDate(),
            },
            success: function(res) {
              // alert(res);
              const data = JSON.parse(res);
              if (data.status == 'success') {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: data.msg,
                }).then(function() {
                  window.location.replace("dashboard.php");
                });
              }
            },
          });
        }
      }
    }
  </script>

</body>

</html>
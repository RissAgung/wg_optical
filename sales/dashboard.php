<?php
date_default_timezone_set("Asia/Bangkok");
include "../config/koneksi.php";
$crud = new koneksi();

session_start();
if (!isset($_SESSION['statusLogin'])) {
  header('Location: ../views/login.php');
} else if ($_SESSION['level'] != 3) {
  header('Location: ../views/dashboard.php');
}
$id_pegawai = $_SESSION['id_pegawai'];

$dataPegawai = $crud->showData("SELECT * FROM pegawai WHERE id_pegawai = '$id_pegawai'");

$dataKeranjang = $crud->showData("SELECT COUNT(*) as jumlah FROM keranjang WHERE id_pegawai = '$id_pegawai'");

foreach ($dataKeranjang as $index) {
  $jumlahkeranjang = $index["jumlah"];
}

// $dataTr = $crud->showData("")
foreach ($dataPegawai as $index) {
  $foto_pegawai = $index["foto_pegawai"];
  $nama_pegawai = $index["nama"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <link rel="stylesheet" href="../css/swiper-bundle.min.css">
  <link rel="stylesheet" href="../css/sweetalert2.min.css">
  <title>Document</title>
</head>

<body class="text-[#373F47]">

  <!-- header -->
  <div class="fixed top-0 z-50 overflow-hidden">
    <div class="flex flex-row w-screen h-[70px] max-md:text-sm justify-between py-2 px-4 bg-white">
      <!-- left -->
      <div class="flex flex-row items-center">
        <div class="w-[45px] h-[45px] overflow-hidden rounded-full mr-2">
          <img class="object-cover w-[45px] h-[45px]" src="../images/pegawai/foto_pegawai/<?= $foto_pegawai ?>" alt="">
        </div>
        <h3 class="font-ex-semibold">Welcome, <?= $nama_pegawai ?></h3>
      </div>

      <!-- right -->
      <div class="flex flex-row items-center mr-2 relative">
        <div class="w-[45px] h-[45px] rounded-full border-2 border-[#A9B6C3] flex justify-center items-center">
          <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18.9089 13.4983L16.7494 5.69208C16.2882 4.02222 15.2834 2.55505 13.8948 1.52406C12.5062 0.493072 10.8137 -0.0424819 9.08659 0.00263403C7.35948 0.04775 5.69705 0.670944 4.36387 1.77303C3.03069 2.87512 2.10339 4.39276 1.72954 6.08443L0.0591915 13.6232C-0.0216324 13.9885 -0.019661 14.3672 0.0649603 14.7316C0.149582 15.096 0.314693 15.4366 0.548114 15.7284C0.781535 16.0203 1.07731 16.2558 1.41361 16.4177C1.74992 16.5796 2.11817 16.6637 2.4912 16.6638H5.48719C5.67783 17.6053 6.18717 18.4518 6.92891 19.0598C7.67065 19.6678 8.59917 20 9.55716 20C10.5151 20 11.4437 19.6678 12.1854 19.0598C12.9271 18.4518 13.4365 17.6053 13.6271 16.6638H16.5093C16.8932 16.6636 17.2717 16.5745 17.6156 16.4034C17.9594 16.2323 18.2592 15.9839 18.4916 15.6775C18.7239 15.3711 18.8826 15.015 18.9551 14.637C19.0276 14.259 19.0121 13.8693 18.9098 13.4983H18.9089ZM9.55716 18.3298C9.04363 18.3277 8.5433 18.1664 8.12461 17.8682C7.70593 17.57 7.38935 17.1493 7.21817 16.6638H11.8961C11.725 17.1493 11.4084 17.57 10.9897 17.8682C10.571 18.1664 10.0707 18.3277 9.55716 18.3298ZM17.1697 14.6687C17.0922 14.7717 16.9917 14.8551 16.8763 14.9123C16.761 14.9694 16.6338 14.9987 16.5052 14.9977H2.4912C2.36683 14.9977 2.24405 14.9697 2.13192 14.9157C2.0198 14.8617 1.92119 14.7832 1.84338 14.6859C1.76556 14.5886 1.71053 14.475 1.68235 14.3535C1.65416 14.232 1.65354 14.1057 1.68053 13.9839L3.35088 6.44512C3.64521 5.11747 4.37361 3.92658 5.42029 3.06178C6.46698 2.19698 7.77188 1.70789 9.12755 1.67228C10.4832 1.63666 11.8119 2.05655 12.9023 2.8652C13.9927 3.67386 14.7822 4.82486 15.1455 6.13524L17.305 13.9415C17.3403 14.0649 17.3464 14.1949 17.3229 14.3211C17.2994 14.4473 17.247 14.5663 17.1697 14.6687Z" fill="#373F47" />
          </svg>
        </div>
        <?php if ($jumlahkeranjang != 0) : ?>
          <div class="px-2 scale-[0.8] rounded-full items-center justify-center flex bg-red-600 absolute translate-x-2 right-0 -top-0">
            <p class="text-white text-center text-md"><?= $jumlahkeranjang ?></p>
          </div>
        <?php endif; ?>
        <a href="keranjang.php" class="">
          <div class="w-[45px] h-[45px] rounded-full border-2 border-[#A9B6C3] flex justify-center items-center ml-2">
            <svg width="20" height="20" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M16.113 4.10833V4.10837L16.1163 4.1083C16.8465 4.09235 17.5532 4.36687 18.0813 4.87161C18.4096 5.19861 18.645 5.60711 18.7633 6.05522C18.8818 6.50379 18.8788 6.97586 18.7545 7.42286L18.7544 7.42329L17.7685 11.0103C17.5246 11.8978 16.9964 12.6807 16.265 13.2388C15.5335 13.7969 14.6392 14.0995 13.7194 14.1H5.71047C5.71046 14.1 5.71045 14.1 5.71045 14.1C5.10202 14.0999 4.51481 13.8762 4.06033 13.4715C3.60585 13.0667 3.31574 12.509 3.24515 11.9043L3.24495 11.9027L2.05836 2.59572C2.04825 2.49539 2.00171 2.4022 1.92748 2.33386C1.85257 2.26488 1.75477 2.2261 1.65295 2.22501V2.225H1.65134H1.18687C0.911903 2.225 0.648179 2.11571 0.453721 1.92115C0.259261 1.72659 0.15 1.46269 0.15 1.1875C0.15 0.912312 0.259261 0.648412 0.453721 0.453849C0.648179 0.259288 0.911903 0.15 1.18687 0.15L1.65129 0.15C1.6513 0.15 1.65132 0.15 1.65134 0.15C2.25937 0.150207 2.84621 0.373613 3.30061 0.777888C3.75502 1.18217 4.04539 1.73924 4.11666 2.34349L4.11665 2.34349L4.11683 2.34489L4.32493 3.9773L4.34163 4.10833H4.47372H16.113ZM15.7717 10.4608L15.7718 10.4606L16.2317 6.33333V6.18333H16.2312H4.77677H4.60642L4.62798 6.35231L5.30417 11.6539C5.31384 11.7543 5.36012 11.8477 5.43426 11.9161C5.50919 11.9853 5.60721 12.0242 5.70921 12.025H5.71045L13.7195 12.025L13.7198 12.025C14.1856 12.024 14.6382 11.8705 15.0087 11.5881C15.3792 11.3057 15.6471 10.9098 15.7717 10.4608ZM6.97126 17.4167C6.97126 18.2084 6.32983 18.85 5.53876 18.85C4.74768 18.85 4.10626 18.2084 4.10626 17.4167C4.10626 16.625 4.74768 15.9833 5.53876 15.9833C6.32983 15.9833 6.97126 16.625 6.97126 17.4167ZM14.8837 17.4167C14.8837 18.2084 14.2423 18.85 13.4512 18.85C12.6602 18.85 12.0187 18.2084 12.0187 17.4167C12.0187 16.625 12.6602 15.9833 13.4512 15.9833C14.2423 15.9833 14.8837 16.625 14.8837 17.4167Z" fill="#373F47" stroke="#FEFEFE" stroke-width="0.3" />
            </svg>
          </div>
        </a>
      </div>
    </div>
  </div>

  <!-- main -->
  <div class="h-screen my-[70px]">

    <!-- scroll -->
    <div class="w-full h-[35%]">

      <div class="swiper w-full h-full">
        <div class="swiper-wrapper card-wrapper">

          <div class="flex flex-col justify-center swiper-slide h-full w-full p-5 overflow-hidden relative">
            <img class="rounded-2xl w-full h-full object-cover" src="../assets/images/bg_biru.svg" alt="">

            <div class="absolute flex flex-col justify-center text-white max-[389px]:p-3 p-5 h-full max-[389px]:gap-1 gap-3 w-full">
              <p class="text-sm font-ex-semibold">Pendapatan</p>
              <p class="text-xs w-[75%]">Pendapaan yang didapat pada 1 bulan ini</p>
              <p class="text-xl font-ex-semibold">Rp. 700.000</p>
            </div>
          </div>

          <div class="flex flex-col justify-center swiper-slide h-full w-full p-5 overflow-hidden relative">
            <img class="rounded-2xl w-full h-full object-cover" src="../assets/images/bg_hitam.svg" alt="">

            <div class="absolute flex flex-col justify-center text-white max-[389px]:p-3 p-5 pr-3 h-full max-[389px]:gap-1 gap-3 w-full">
              <div class="flex flex-col justify-center gap-3 h-full py-5">
                <p class="text-sm font-ex-semibold">Target Sales</p>
                <div class="flex flex-row gap-3">
                  <div class="flex flex-col w-[40%]">
                    <p class="text-xs">Pesanan dalam pengiriman</p>
                    <p class="mt-2 text-xl font-ex-semibold">30</p>
                  </div>

                  <div class="h-full w-[4px] rounded-full bg-white">

                  </div>
                  <div class="flex flex-col w-[40%]">
                    <p class="text-xs">Pesanan selesai</p>
                    <p class="text-xl font-ex-semibold">30</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Transaksi -->
    <div class="flex flex-col items-center w-full h-[65%] p-4">
      <h1 class="ml-2 font-ex-semibold md:text-2xl lg:mb-5">Transaksi</h1>

      <div class=" flex max-lg:flex-col justify-around max-lg:items-center w-full max-[391px]:h-full max-md:h-[70%] h-[80%]">
        <a href="transaksi/transaksi_frame.php" class="flex flex-col justify-center items-center max-md:w-full max-lg:w-[70%] h-[25%]">
          <img class="w-full h-full object-cover rounded-xl" src="../assets/images/button_transaksi.svg" alt="">
          <h1 class="absolute text-xl font-ex-bold text-white">Frame</h1>
        </a>
        <a href="transaksi/transaksi_set.php" class="flex flex-col justify-center items-center max-md:w-full max-lg:w-[70%] h-[25%]">
          <img class="w-full h-full object-cover rounded-xl" src="../assets/images/button_transaksi.svg" alt="">
          <h1 class="absolute text-xl font-ex-bold text-white">Full Set</h1>
        </a>
        <a href="transaksi/transaksi_lensa.php" class="flex flex-col justify-center items-center max-md:w-full max-lg:w-[70%] h-[25%]">
          <img class="w-full h-full object-cover rounded-xl" src="../assets/images/button_transaksi.svg" alt="">
          <h1 class="absolute text-xl font-ex-bold text-white">Lensa</h1>
        </a>
      </div>

    </div>

  </div>

  <!-- nav botom -->
  <div id="navbar" class="fixed bottom-0 z-50">

  </div>

  <script src="../js/jquery-3.6.1.min.js"></script>
  <script src="../js/swiper-bundle.min.js"></script>
  <script src="../js/jquery.iddle.min.js"></script>
  <script src="../js/sweetalert2.min.js"></script>
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

    $('#navbar').load("../assets/components/navbar_sales.html");

    var swiperhero = new Swiper(".swiper", {
      slidesPerView: 1,
      loop: true,
      fade: 'true',
      // autoplay: {
      //   delay: 10000,
      // },

      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },

      navigation: {
        nextEl: ".btn-next",
        prevEl: ".btn-prev",
      },

      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        520: {
          slidesPerView: 2,
        },
        756: {
          slidesPerView: 2,
        },
        1000: {
          slidesPerView: 2,
        },
      },
    });
  </script>
</body>

</html>
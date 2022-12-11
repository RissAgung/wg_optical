<?php

session_start();
if (!isset($_SESSION['statusLogin'])) {
  header('Location: ../views/login.php');
} else if ($_SESSION['level'] != 3) {
  header('Location: ../views/dashboard.php');
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
  <title>Document</title>
</head>

<body class="text-[#373F47]">

  <!-- header -->
  <div class="fixed top-0 z-50">
    <div class="flex flex-row w-screen h-[70px] max-md:text-sm justify-between py-2 px-4 bg-white">
      <!-- left -->
      <div class="flex flex-row items-center">
        <div class="w-[45px] h-[45px] overflow-hidden rounded-full mr-2">
          <img class="object-cover w-[45px] h-[45px]" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTN9RiCn_q7Sb-CrhRj-aimuCB-Qvd5Yc3Ecg&usqp=CAU" alt="">
        </div>
        <h3 class="font-ex-semibold">Welcome, Rizal</h3>
      </div>

      <!-- right -->
      <div class="flex flex-row items-center">
        <div class="w-[45px] h-[45px] rounded-full border-2 border-[#A9B6C3] flex justify-center items-center">
          <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18.9089 13.4983L16.7494 5.69208C16.2882 4.02222 15.2834 2.55505 13.8948 1.52406C12.5062 0.493072 10.8137 -0.0424819 9.08659 0.00263403C7.35948 0.04775 5.69705 0.670944 4.36387 1.77303C3.03069 2.87512 2.10339 4.39276 1.72954 6.08443L0.0591915 13.6232C-0.0216324 13.9885 -0.019661 14.3672 0.0649603 14.7316C0.149582 15.096 0.314693 15.4366 0.548114 15.7284C0.781535 16.0203 1.07731 16.2558 1.41361 16.4177C1.74992 16.5796 2.11817 16.6637 2.4912 16.6638H5.48719C5.67783 17.6053 6.18717 18.4518 6.92891 19.0598C7.67065 19.6678 8.59917 20 9.55716 20C10.5151 20 11.4437 19.6678 12.1854 19.0598C12.9271 18.4518 13.4365 17.6053 13.6271 16.6638H16.5093C16.8932 16.6636 17.2717 16.5745 17.6156 16.4034C17.9594 16.2323 18.2592 15.9839 18.4916 15.6775C18.7239 15.3711 18.8826 15.015 18.9551 14.637C19.0276 14.259 19.0121 13.8693 18.9098 13.4983H18.9089ZM9.55716 18.3298C9.04363 18.3277 8.5433 18.1664 8.12461 17.8682C7.70593 17.57 7.38935 17.1493 7.21817 16.6638H11.8961C11.725 17.1493 11.4084 17.57 10.9897 17.8682C10.571 18.1664 10.0707 18.3277 9.55716 18.3298ZM17.1697 14.6687C17.0922 14.7717 16.9917 14.8551 16.8763 14.9123C16.761 14.9694 16.6338 14.9987 16.5052 14.9977H2.4912C2.36683 14.9977 2.24405 14.9697 2.13192 14.9157C2.0198 14.8617 1.92119 14.7832 1.84338 14.6859C1.76556 14.5886 1.71053 14.475 1.68235 14.3535C1.65416 14.232 1.65354 14.1057 1.68053 13.9839L3.35088 6.44512C3.64521 5.11747 4.37361 3.92658 5.42029 3.06178C6.46698 2.19698 7.77188 1.70789 9.12755 1.67228C10.4832 1.63666 11.8119 2.05655 12.9023 2.8652C13.9927 3.67386 14.7822 4.82486 15.1455 6.13524L17.305 13.9415C17.3403 14.0649 17.3464 14.1949 17.3229 14.3211C17.2994 14.4473 17.247 14.5663 17.1697 14.6687Z" fill="#373F47" />
          </svg>
        </div>
        <div class="w-[45px] h-[45px] rounded-full border-2 border-[#A9B6C3] flex justify-center items-center ml-2">
          <svg width="20" height="20" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16.113 4.10833V4.10837L16.1163 4.1083C16.8465 4.09235 17.5532 4.36687 18.0813 4.87161C18.4096 5.19861 18.645 5.60711 18.7633 6.05522C18.8818 6.50379 18.8788 6.97586 18.7545 7.42286L18.7544 7.42329L17.7685 11.0103C17.5246 11.8978 16.9964 12.6807 16.265 13.2388C15.5335 13.7969 14.6392 14.0995 13.7194 14.1H5.71047C5.71046 14.1 5.71045 14.1 5.71045 14.1C5.10202 14.0999 4.51481 13.8762 4.06033 13.4715C3.60585 13.0667 3.31574 12.509 3.24515 11.9043L3.24495 11.9027L2.05836 2.59572C2.04825 2.49539 2.00171 2.4022 1.92748 2.33386C1.85257 2.26488 1.75477 2.2261 1.65295 2.22501V2.225H1.65134H1.18687C0.911903 2.225 0.648179 2.11571 0.453721 1.92115C0.259261 1.72659 0.15 1.46269 0.15 1.1875C0.15 0.912312 0.259261 0.648412 0.453721 0.453849C0.648179 0.259288 0.911903 0.15 1.18687 0.15L1.65129 0.15C1.6513 0.15 1.65132 0.15 1.65134 0.15C2.25937 0.150207 2.84621 0.373613 3.30061 0.777888C3.75502 1.18217 4.04539 1.73924 4.11666 2.34349L4.11665 2.34349L4.11683 2.34489L4.32493 3.9773L4.34163 4.10833H4.47372H16.113ZM15.7717 10.4608L15.7718 10.4606L16.2317 6.33333V6.18333H16.2312H4.77677H4.60642L4.62798 6.35231L5.30417 11.6539C5.31384 11.7543 5.36012 11.8477 5.43426 11.9161C5.50919 11.9853 5.60721 12.0242 5.70921 12.025H5.71045L13.7195 12.025L13.7198 12.025C14.1856 12.024 14.6382 11.8705 15.0087 11.5881C15.3792 11.3057 15.6471 10.9098 15.7717 10.4608ZM6.97126 17.4167C6.97126 18.2084 6.32983 18.85 5.53876 18.85C4.74768 18.85 4.10626 18.2084 4.10626 17.4167C4.10626 16.625 4.74768 15.9833 5.53876 15.9833C6.32983 15.9833 6.97126 16.625 6.97126 17.4167ZM14.8837 17.4167C14.8837 18.2084 14.2423 18.85 13.4512 18.85C12.6602 18.85 12.0187 18.2084 12.0187 17.4167C12.0187 16.625 12.6602 15.9833 13.4512 15.9833C14.2423 15.9833 14.8837 16.625 14.8837 17.4167Z" fill="#373F47" stroke="#FEFEFE" stroke-width="0.3" />
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- main -->
  <div class="h-screen my-[70px]">

    <!-- scroll -->
    <div class="w-full h-[35%]">

      <div class="swiper w-full h-full">
        <div class="swiper-wrapper card-wrapper">

          <div class="flex flex-col swiper-slide h-full w-full p-4 overflow-hidden bg-red-600">

            <div class="flex flex-col h-full w-full text-white p-5 justify-around">
              <p class="font-ex-semibold text-[20px]">Pendapatan</p>
              <p class="w-[60%]">Pendapaan yang didapat pada periode 1 pada bulan ini</p>
              <p class="font-ex-bold text-[27px]">Rp. 700.000</p>
            </div>

            <!-- <img class="rounded-2xl w-full h-full object-cover" src="../assets/images/bg_pendapatan.svg" alt=""> -->
          </div>

          <div class="swiper-slide h-full w-full p-4 overflow-auto">
            <img class=" rounded-2xl w-full h-full object-cover" src="../assets/images/bg_target.svg" alt="">
          </div>

        </div>
      </div>
    </div>

    <!-- Transaksi -->
    <div class="flex flex-col items-center w-full h-[65%] p-4">
      <h1 class="ml-2 font-ex-semibold md:text-2xl lg:mb-5">Transaksi</h1>

      <div class=" flex max-lg:flex-col justify-around max-lg:items-center w-full max-[391px]:h-full max-md:h-[70%] h-[80%]">
        <div class="max-md:w-full max-lg:w-[70%] h-[25%]">
          <img class="w-full h-full object-cover rounded-xl" src="../assets/images/button_transaksi.svg" alt="">
        </div>
        <div class="max-md:w-full max-lg:w-[70%] h-[25%]">
          <img class="w-full h-full object-cover rounded-xl" src="../assets/images/button_transaksi.svg" alt="">
        </div>
        <div class="max-md:w-full max-lg:w-[70%] h-[25%]">
          <img class="w-full h-full object-cover rounded-xl" src="../assets/images/button_transaksi.svg" alt="">
        </div>
      </div>

    </div>

  </div>

  <!-- nav botom -->
  <div class="fixed bottom-0 z-50">
    <div class="flex flex-row w-screen border-t-2 h-[70px] text-sm justify-around items-center p-2 bg-white">

      <!-- home-->
      <div>
        <svg width="25" height="25" viewBox="0 0 29 29" class="fill-[#B8C5D1] hover:fill-[#373F47] transition ease-in-out" xmlns="http://www.w3.org/2000/svg">
          <path d="M14.5 18.1182C12.498 18.1182 10.875 19.7422 10.875 21.7455V29H18.125V21.7455C18.125 19.7422 16.502 18.1182 14.5 18.1182Z" />
          <path d="M20.5417 21.7455V29H25.375C27.377 29 29 27.376 29 25.3727V14.3447C29.0003 13.7165 28.7563 13.1129 28.3197 12.6616L18.0513 1.55372C16.2395 -0.407829 13.1816 -0.528265 11.2212 1.28468C11.1281 1.37083 11.0384 1.46055 10.9524 1.55372L0.702061 12.658C0.252221 13.1112 -0.000169836 13.7241 8.57442e-08 14.3628V25.3727C8.57442e-08 27.376 1.62298 29 3.625 29H8.45831V21.7455C8.48091 18.4485 11.1412 15.7562 14.3531 15.6787C17.6724 15.5985 20.5164 18.3367 20.5417 21.7455Z" />
        </svg>
      </div>

      <!-- pesanan -->
      <div>
        <svg width="26" height="26" viewBox="0 0 29 29" class="fill-[#B8C5D1] hover:fill-[#373F47] transition ease-in-out" xmlns="http://www.w3.org/2000/svg">
          <path d="M29 14.4994C29 12.5315 28.1365 10.675 26.672 9.50833C26.8413 7.5453 26.1399 5.62221 24.7491 4.22922C23.3584 2.83864 21.4416 2.13428 19.5768 2.34728C17.1411 -0.746117 11.8793 -0.804209 9.50049 2.30492C5.59067 1.84019 1.83081 5.52418 2.34599 9.40666C-0.745104 11.8441 -0.804362 17.1099 2.30366 19.4917C2.13435 21.4547 2.83577 23.3778 4.22652 24.7708C5.61727 26.1614 7.53651 26.8657 9.3989 26.6527C11.8345 29.7461 17.0964 29.8042 19.4752 26.6951C21.4343 26.8633 23.3572 26.1638 24.7491 24.7708C26.1387 23.379 26.8401 21.4547 26.6297 19.5945C28.1365 18.3262 29 16.4697 29 14.5018V14.4994ZM9.65044 10.8686C9.6577 9.28564 12.0619 9.28564 12.0691 10.8686C12.0619 12.4517 9.6577 12.4517 9.65044 10.8686ZM13.0753 18.8018C12.7028 19.3622 11.947 19.505 11.398 19.1371C10.8417 18.7667 10.6917 18.0152 11.063 17.4585L15.9004 10.197C16.2704 9.64145 17.0202 9.48896 17.5777 9.86172C18.134 10.2321 18.284 10.9836 17.9127 11.5403L13.0753 18.8018ZM18.1159 19.3404C16.534 19.3331 16.534 16.9272 18.1159 16.9199C19.6977 16.9272 19.6977 19.3331 18.1159 19.3404Z" />
        </svg>
      </div>

      <!-- history -->
      <div>
        <svg width="26" height="26" viewBox="0 0 29 29" class="fill-[#B8C5D1] hover:fill-[#373F47] transition ease-in-out" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 29C22.5081 29 29 22.5081 29 14.5C29 6.49187 22.5081 0 14.5 0C6.49187 0 0 6.49187 0 14.5C0 22.5081 6.49187 29 14.5 29ZM12.5357 8.5596C12.8786 8.2013 13.3438 8 13.8289 8C14.3139 8 14.7791 8.2013 15.1221 8.5596C15.4651 8.91791 15.6577 9.40389 15.6577 9.91061V14.8515L17.4866 16.7621C17.8198 17.1224 18.0041 17.605 17.9999 18.106C17.9958 18.6069 17.8034 19.0862 17.4643 19.4404C17.1252 19.7946 16.6665 19.9956 16.187 19.9999C15.7075 20.0043 15.2455 19.8117 14.9006 19.4637L12.7145 17.1799C12.2571 16.7022 12.0001 16.0544 12 15.3788V9.91061C12 9.40389 12.1927 8.91791 12.5357 8.5596Z" />
        </svg>
      </div>

      <!-- user -->
      <div>
        <svg width="22" height="26" viewBox="0 0 22 29" class="fill-[#B8C5D1] hover:fill-[#373F47] transition ease-in-out" xmlns="http://www.w3.org/2000/svg">
          <path d="M10.7456 14.3276C6.78917 14.3276 3.58183 11.1202 3.58183 7.16379C3.58183 3.20734 6.78917 0 10.7456 0C14.7021 0 17.9094 3.20734 17.9094 7.16379C17.9094 11.1202 14.7021 14.3276 10.7456 14.3276Z" />
          <path d="M10.7456 16.7155C16.6776 16.7221 21.4847 21.5292 21.4913 27.4612C21.4913 28.1206 20.9568 28.6552 20.2974 28.6552H1.19395C0.534544 28.6552 0 28.1206 0 27.4612C0.00654793 21.5292 4.81368 16.7221 10.7456 16.7155Z" />
        </svg>
      </div>
    </div>
  </div>

  <script src="../js/jquery-3.6.1.min.js"></script>
  <script src="../js/swiper-bundle.min.js"></script>
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
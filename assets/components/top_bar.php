<?php

include "../../config/koneksi.php";

$crud = new koneksi();

$dataNotif = $crud->showData("SELECT pegawai.nama, pegawai.foto_pegawai FROM transaksi LEFT JOIN pegawai ON pegawai.id_pegawai = transaksi.id_pegawai WHERE transaksi.status_confirm = '1'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/output.css">
  <title>Document</title>
</head>

<body>

  <div class="w-full h-16 bg-white flex items-center md:justify-between md:px-5 justify-between px-6 overflow-hidden">
    <div class="flex flex-row uppercase font-ex-bold text-sm items-center">

      <!-- hamburger -->
      <div class="ex-burger cursor-pointer mr-2 lg:hidden absolute" id="burger">
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

      <h1 id="title-header">Riwayat</h1>
    </div>

    <div class="flex flex-row items-center">
      <div class="mr-4">
        <div onclick="showNotif()" class="cursor-pointer relative">
          <svg width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M23.8313 21.0763L23.5594 20.8364C22.788 20.1491 22.1129 19.361 21.5521 18.4933C20.9397 17.2957 20.5727 15.9879 20.4725 14.6467V10.6961C20.4778 8.58936 19.7136 6.55319 18.3235 4.97017C16.9334 3.38714 15.013 2.36623 12.9233 2.09923V1.06761C12.9233 0.784463 12.8108 0.512912 12.6106 0.312696C12.4104 0.11248 12.1388 0 11.8557 0C11.5725 0 11.301 0.11248 11.1008 0.312696C10.9005 0.512912 10.7881 0.784463 10.7881 1.06761V2.11523C8.71703 2.40147 6.81989 3.42855 5.44804 5.00626C4.07618 6.58396 3.32257 8.60538 3.32679 10.6961V14.6467C3.22663 15.9879 2.85958 17.2957 2.24718 18.4933C1.69609 19.3588 1.03178 20.1468 0.271901 20.8364L0 21.0763V23.3315H23.8313V21.0763Z" fill="#444D68" />
            <path d="M9.81348 24.1712C9.8836 24.6781 10.1348 25.1425 10.5206 25.4787C10.9065 25.8148 11.401 26 11.9127 26C12.4245 26 12.9189 25.8148 13.3048 25.4787C13.6906 25.1425 13.9418 24.6781 14.0119 24.1712H9.81348Z" fill="#444D68" />
          </svg>
          <?php if (count($dataNotif) != 0) : ?>
            <div class="w-[22px] h-[22px] text-white text-sm font-ex-semibold rounded-full flex justify-center items-center bg-red-600 absolute bottom-3 left-2">
              <?= count($dataNotif) ?>
            </div>
          <?php endif ?>
        </div>

        <!-- notfication -->
        <div id="notif" class="z-[50] w-[254px] h-[379px] hidden transition ease-in-out flex-col absolute bg-white rounded-md shadow-md border-[1px] mt-3 max-[356px]:mr-10 mr-12 p-[13px] right-0">
          <div onclick="showNotif()" class="cursor-pointer flex flex-row justify-end mb-[21px]">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6.66264 4.98114L9.66037 1.98311C9.85499 1.7621 9.95809 1.47535 9.94868 1.18113C9.93928 0.886908 9.81809 0.607307 9.60975 0.399156C9.4014 0.191006 9.12154 0.0699284 8.82705 0.0605348C8.53256 0.0511412 8.24554 0.154136 8.02433 0.348585L5.02351 3.34353L2.01728 0.33932C1.9096 0.231742 1.78177 0.146407 1.64108 0.0881864C1.5004 0.0299658 1.34961 1.13352e-09 1.19733 0C1.04505 -1.13352e-09 0.894263 0.0299658 0.753576 0.0881864C0.612888 0.146407 0.485056 0.231742 0.377379 0.33932C0.269702 0.446897 0.184287 0.574611 0.126013 0.715168C0.0677381 0.855725 0.0377445 1.00637 0.0377445 1.15851C0.0377445 1.31065 0.0677381 1.4613 0.126013 1.60185C0.184287 1.74241 0.269702 1.87012 0.377379 1.9777L3.38438 4.98114L0.386653 7.97841C0.269087 8.08341 0.1742 8.21126 0.107795 8.35416C0.0413903 8.49705 0.00486514 8.65198 0.000453729 8.80946C-0.00395768 8.96694 0.0238375 9.12367 0.082139 9.27005C0.14044 9.41643 0.228022 9.54939 0.339526 9.66079C0.45103 9.77219 0.584111 9.85969 0.730627 9.91794C0.877144 9.97618 1.03401 10.004 1.19164 9.99955C1.34927 9.99514 1.50434 9.95865 1.64737 9.8923C1.7904 9.82596 1.91837 9.73116 2.02346 9.6137L5.02351 6.61876L8.02046 9.6137C8.23793 9.83097 8.53287 9.95302 8.84041 9.95302C9.14796 9.95302 9.4429 9.83097 9.66037 9.6137C9.87783 9.39644 10 9.10177 10 8.79451C10 8.48726 9.87783 8.19259 9.66037 7.97532L6.66264 4.98114Z" fill="#ADAFB6" />
            </svg>
          </div>

          <div id="content_notif" class="h-[90%]">
            <div class="flex flex-col justify-between w-full h-full font-ex-color">
              <div id="content" class="flex flex-col h-[80%] overflow-hidden">
                <?php foreach ($dataNotif as $index) : ?>
                  <a href="../views/invoice.php">
                    <div class="flex flex-row mb-[24px] ml-[7px]">
                      <div class="w-[43px] h-[43px] rounded-full overflow-hidden">
                        <img class="w-[43px] h-[43px] object-cover" src="../images/pegawai/foto_pegawai/<?= $index['foto_pegawai'] ?>" alt="gambar_user">
                      </div>
                      <div class="flex flex-col justify-center ml-[9px]">
                        <h2 class="font-ex-semibold text-[12px]">Konfirmasi Pesanan</h2>
                        <p class="font-ex-semibold text-[11px] text-[#777980]"><?= $index["nama"] ?></p>
                      </div>
                    </div>
                  </a>
                <?php endforeach ?>
              </div>

              <div onclick="viewAll()" id="vl" class="cursor-pointer flex flex-col h-[10%] items-center justify-center font-ex-semibold text-[12px]">
                View all</div>
            </div>
          </div>
        </div>
      </div>
      <img class="w-10 h-10 rounded-full" src="" id="avatar_profile" alt="Rounded avatar">
    </div>
  </div>


  <script src="../js/jquery-3.6.1.min.js"></script>
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
      idle: 120000
    });

    function showNotif() {
      $('#notif').toggleClass('hidden');
      reset();
    }

    function viewAll() {
      $('#content').removeClass("h-[80%]");
      $('#content').removeClass("overflow-hidden");
      $('#content').addClass("overflow-auto");
      $('#content').addClass("h-[93%]");
      $('#vl').addClass("hidden");
    }

    function reset() {
      $('#content').addClass("h-[80%]");
      $('#content').addClass("overflow-hidden");
      $('#content').removeClass("overflow-auto");
      $('#content').removeClass("h-[93%]");
      $('#content').scrollTop(0);
      $('#vl').removeClass("hidden");
    }
  </script>

</body>

</html>
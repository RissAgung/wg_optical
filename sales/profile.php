<?php

session_start();
if (!isset($_SESSION['statusLogin'])) {
  header('Location: ../views/login.php');
} else if ($_SESSION['level'] != 3) {
  header('Location: ../views/dashboard.php');
}

include "../config/koneksi.php";
$crud = new koneksi();

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
  <link rel="stylesheet" href="../css/output.css">
  <link rel="stylesheet" href="../css/sweetalert2.min.css">
  <title>Document</title>
</head>

<body class="h-screen text-[#373F47]">

  <div id="modalAddHeader"></div>

  <!-- top -->
  <div class="flex flex-col items-center w-full bg-white shadow-md h- p-6 fixed top-0 z-50">
    <h1 class="text-sm font-ex-bold pl-2">Profile</h1>
  </div>

  <!-- main content -->

  <!-- Proses -->
  <div id="page_proses" class="flex flex-col items-center w-full h-full pb-[76px] pt-[90px] gap-2 overflow-y-auto bg-white">
    <div class="flex flex-col justify-between">
      <div class="w-40 h-40 rounded-full bg-black overflow-hidden">
        <img src="../images/pegawai/foto_pegawai/" alt="foto pegawai" class="w-40 h-40 object-cover">
      </div>
    </div>
  </div>

  <!-- footer -->
  <div id="navbar" class="fixed bottom-0 z-50">
  </div>

</body>

<script src="../js/jquery-3.6.1.min.js"></script>
<script src="../js/sweetalert2.min.js"></script>
<script>
  // navbar
  $('#navbar').load("../assets/components/navbar_sales.html");

  $('#modalAddHeader').load("../assets/components/up_bukti_pengiriman.html", function() {
    $('#btnOutHeader').on('click', function() {
      $('#modalImgHeader').addClass('scale-0');
      $('#bgmodalinput').removeClass("effectmodal");
    });

    $('#btn_out').on('click', function() {
      $('#modalImgHeader').addClass('scale-0');
      $('#bgmodalinput').removeClass("effectmodal");
    });
  });
</script>

</html>
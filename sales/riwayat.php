<?php

session_start();
if (!isset($_SESSION['statusLogin'])) {
  header('Location: ../views/login.php');
} else if ($_SESSION['level'] != 3) {
  header('Location: ../views/dashboard.php');
}

include "../config/koneksi.php";
$crud = new koneksi();

$dataProses = $crud->showData("SELECT transaksi.status_pengiriman, transaksi.status_confirm, transaksi.tanggal, transaksi.kode_pesanan, pegawai.nama AS nama_sales, customer.nama AS nama_cus, transaksi.bukti_pengiriman, customer.alamat_jalan, transaksi.total_harga, transaksi.total_bayar, transaksi.status_pengiriman, cicilan.depan_pembayaran, cicilan.kode_cicilan FROM pegawai JOIN transaksi ON pegawai.id_pegawai = transaksi.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN cicilan ON transaksi.kode_pesanan = cicilan.kode_pesanan");

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
    <h1 class="text-sm font-ex-bold pl-2">Riwayat</h1>
  </div>

  <!-- main content -->

  <!-- Proses -->
  <div id="page_proses" class="flex flex-col items-center w-full h-full pb-[76px] pt-[90px] gap-2 overflow-y-auto bg-[#ECECEC]">
    <!-- AND NOT status_pengiriman = 'kirim' AND NOT status_pengiriman = 'terima' -->

    <?php foreach ($dataProses as $index) : ?>
      <?php if ($index['total_bayar'] >= $index['total_harga'] && $index['status_pengiriman'] == 'terima') : ?>
        <div class="flex flex-col w-[95%] bg-white rounded-lg p-4 shadow-sm">
          <div class="flex flex-row justify-between items-center w-full h-full">

            <div class="flex flex-row items-center gap-2">
              <svg width="40" height="41" viewBox="0 0 40 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="40" height="40.4457" rx="20" fill="#5E5E5E" />
                <path d="M19.9958 17.796C21.0782 17.796 22.1162 17.3614 22.8815 16.5878C23.6468 15.8142 24.0768 14.765 24.0768 13.671C24.0768 12.5769 23.6468 11.5277 22.8815 10.7541C22.1162 9.98056 21.0782 9.54596 19.9958 9.54596C18.9135 9.54596 17.8755 9.98056 17.1101 10.7541C16.3448 11.5277 15.9148 12.5769 15.9148 13.671C15.9148 14.765 16.3448 15.8142 17.1101 16.5878C17.8755 17.3614 18.9135 17.796 19.9958 17.796ZM11.1061 26.7238C10.9798 27.065 10.9659 27.4383 11.0664 27.7881C11.1669 28.1379 11.3764 28.4456 11.6638 28.6653C14.0462 30.5368 16.9786 31.5506 19.9958 31.5459C23.1382 31.5459 26.033 30.4679 28.336 28.6584C28.9209 28.2006 29.1576 27.4168 28.891 26.7197C28.2003 24.902 26.9805 23.3387 25.3927 22.2361C23.8048 21.1336 21.9236 20.5436 19.9971 20.544C18.0707 20.5445 16.1897 21.1353 14.6024 22.2386C13.0151 23.3419 11.796 24.9058 11.1061 26.7238Z" fill="white" />
              </svg>

              <div class="flex flex-col text-xs h-full justify-center">
                <p class="font-ex-semibold"><?= $index["kode_pesanan"] ?></p>
                <p class="font-ex-medium"><?= $index["tanggal"] ?></p>
              </div>
            </div>

            <div class="flex justify-center items-center text-xs p-2 bg-[#2CBF29] text-white rounded-md font-ex-medium">
              Selesai
            </div>

          </div>

          <div class="py-4">
            <hr class="w-full">
          </div>

          <div class="flex flex-col gap-2 pl-1">
            <p class="text-sm font-ex-semibold"><?= $index["nama_cus"] ?></p>
            <p class="text-xs"><?= $index["alamat_jalan"] ?></p>
          </div>

          <div class="py-4">
            <hr class="w-full">
          </div>

          <div class="flex flex-col pl-1">
            <p class="text-xs">Total</p>
            <p class="text-sm font-ex-semibold"><?= rupiah($index["total_harga"]) ?></p>
          </div>

        </div>
      <?php endif ?>
    <?php endforeach ?>

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
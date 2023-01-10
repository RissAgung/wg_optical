<?php
date_default_timezone_set("Asia/Bangkok");
session_start();
if (!isset($_SESSION['statusLogin'])) {
  header('Location: ../views/login.php');
} else if ($_SESSION['level'] != 3) {
  header('Location: ../views/dashboard.php');
}

include "../config/koneksi.php";
$crud = new koneksi();

$dataProses = $crud->showData("SELECT transaksi.status_pengiriman, transaksi.status_confirm, transaksi.tanggal, transaksi.kode_pesanan, pegawai.nama AS nama_sales, customer.nama AS nama_cus, transaksi.bukti_pengiriman, customer.alamat_jalan, transaksi.total_harga, transaksi.total_bayar, transaksi.status_pengiriman, cicilan.depan_pembayaran, cicilan.kode_cicilan FROM pegawai JOIN transaksi ON pegawai.id_pegawai = transaksi.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN cicilan ON transaksi.kode_pesanan = cicilan.kode_pesanan WHERE transaksi.id_pegawai = '".$_SESSION['id_pegawai']."'");

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
  <link rel="icon" type="image/x-icon" href="../assets/images/wgLogo.png">
  <title>Invoice | WG Optical</title>
</head>

<body class="h-screen text-[#373F47]">

  <div id="modalAddHeader"></div>

  <!-- top -->
  <div class="flex flex-col justify-between w-full bg-white shadow-md h- p-3 fixed top-0 z-50">
    <h1 class="text-sm font-ex-semibold pl-2">Pesanan Saya</h1>
    <div class="w-full flex flex-row text-xs justify-between mt-5">
      <div id="tab1" class="cursor-pointer flex justify-center items-center font-ex-semibold text-white w-[30%] h-[30px] bg-[#444D68] rounded-[12px] transition ease-in-out">Diproses</div>
      <div id="tab2" class="cursor-pointer flex justify-center items-center font-ex-semibold w-[30%] h-[30px] rounded-[12px] transition ease-in-out">Dikirim</div>
      <div id="tab3" class="cursor-pointer flex justify-center items-center font-ex-semibold w-[30%] h-[30px] rounded-[12px] transition ease-in-out">Konfirmasi</div>
    </div>
  </div>

  <!-- main content -->

  <!-- Proses -->
  <div id="page_proses" class="flex flex-col items-center w-full h-full pb-[76px] pt-[110px] gap-2 overflow-y-auto bg-[#ECECEC]">
    <!-- AND NOT status_pengiriman = 'kirim' AND NOT status_pengiriman = 'terima' -->

    <?php foreach ($dataProses as $index) : ?>
      <?php if ($index["status_pengiriman"] != "kirim" && $index["status_pengiriman"] != "terima") : ?>
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

            <?php if ($index["status_confirm"] == 2) : ?>
              <div class="flex justify-center items-center text-xs p-2 bg-[#2CBF29] text-white rounded-md font-ex-medium">
                Diproses
              </div>
            <?php else : ?>
              <div class="flex justify-center items-center text-xs p-2 bg-[#FA3B33] text-white rounded-md font-ex-medium">
                Menunggu
              </div>
            <?php endif ?>

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

  <!-- dikirim -->
  <div id="page_kirim" class="hidden flex flex-col items-center w-full h-full pb-[76px] pt-[110px] gap-2 overflow-y-auto bg-[#ECECEC]">
    <?php foreach ($dataProses as $index) : ?>
      <?php if ($index["status_pengiriman"] == "kirim" && $index["status_confirm"] == 2 && $index["bukti_pengiriman"] == null) : ?>
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

          <div class="flex flex-row items-center justify-between pl-1">
            <div class="flex flex-col">
              <p class="text-xs">Total</p>
              <p class="text-sm font-ex-semibold"><?= rupiah($index["total_harga"]) ?></p>
            </div>
            <div onclick="showPengiriman('<?= $index['kode_pesanan'] ?>')" class="cursor-pointer flex justify-center items-center text-xs w-[120px] h-[30px] bg-[#163d64] text-white rounded-md font-ex-medium">
              Bukti Pengiriman
            </div>
          </div>

        </div>
      <?php endif ?>
    <?php endforeach ?>
  </div>

  <!-- konfirmasi -->
  <div id="page_konfirmasi" class="hidden flex flex-col items-center w-full h-full pb-[76px] pt-[110px] gap-2 overflow-y-auto bg-[#ECECEC]">
    <?php foreach ($dataProses as $index) : ?>
      <?php if (($index["status_pengiriman"] == 'terima' && $index["total_bayar"] < $index["total_harga"]) || ($index["status_pengiriman"] == 'kirim' && $index["bukti_pengiriman"] != null)) : ?>
        <div class="flex flex-col w-[95%] bg-white rounded-lg p-4 shadow-sm">
          <div class="flex flex-row justify-between items-center w-full h-full">

            <div class="flex flex-row items-center gap-2">
              <svg width="40" height="41" viewBox="0 0 40 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="40" height="40.4457" rx="20" fill="#5E5E5E" />
                <path d="M19.9958 17.796C21.0782 17.796 22.1162 17.3614 22.8815 16.5878C23.6468 15.8142 24.0768 14.765 24.0768 13.671C24.0768 12.5769 23.6468 11.5277 22.8815 10.7541C22.1162 9.98056 21.0782 9.54596 19.9958 9.54596C18.9135 9.54596 17.8755 9.98056 17.1101 10.7541C16.3448 11.5277 15.9148 12.5769 15.9148 13.671C15.9148 14.765 16.3448 15.8142 17.1101 16.5878C17.8755 17.3614 18.9135 17.796 19.9958 17.796ZM11.1061 26.7238C10.9798 27.065 10.9659 27.4383 11.0664 27.7881C11.1669 28.1379 11.3764 28.4456 11.6638 28.6653C14.0462 30.5368 16.9786 31.5506 19.9958 31.5459C23.1382 31.5459 26.033 30.4679 28.336 28.6584C28.9209 28.2006 29.1576 27.4168 28.891 26.7197C28.2003 24.902 26.9805 23.3387 25.3927 22.2361C23.8048 21.1336 21.9236 20.5436 19.9971 20.544C18.0707 20.5445 16.1897 21.1353 14.6024 22.2386C13.0151 23.3419 11.796 24.9058 11.1061 26.7238Z" fill="white" />
              </svg>

              <div class="flex flex-col text-xs h-full justify-center">
                <p class="font-ex-semibold"><?= $index['kode_pesanan'] ?></p>
                <p class="font-ex-medium"><?= $index['tanggal'] ?></p>
              </div>
            </div>

            <div class="flex justify-center items-center text-xs w-[94px] h-[30px] border-[#373F47] border-[1px] rounded-md font-ex-medium">
              <?php if ($index["status_pengiriman"] == 'kirim') : ?>
                Menunggu
              <?php elseif ($index["total_bayar"] < $index["total_harga"]) : ?>
                Belum lunas
              <?php endif ?>
            </div>
          </div>

          <div class="py-4">
            <hr class="w-full">
          </div>

          <div class="flex flex-col gap-2 pl-1">
            <p class="text-sm font-ex-semibold"><?= $index['nama_cus'] ?></p>
            <p class="text-xs"><?= $index['alamat_jalan'] ?></p>
          </div>

          <div class="py-4">
            <hr class="w-full">
          </div>

          <div class="flex flex-col pl-1">
            <p class="text-xs">Total</p>
            <p class="text-sm font-ex-semibold"><?= rupiah($index['total_harga']) ?></p>
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

    imgInp.onchange = evt => {
      const [file] = imgInp.files
      console.log(file);
      if (file) {
        console.log("masuk");
        imgpreview_peg.src = URL.createObjectURL(file);
        $('#imgpreview_peg').removeClass("hidden");
        $('#imgdefault_peg').addClass("hidden");
      }
    }
  });

  function resetImg() {
    $('#imgInp').val(null);
    imgpreview_peg.src = "#";
    $('#imgpreview_peg').addClass("hidden");
    $('#imgdefault_peg').removeClass("hidden");
  }

  function showPengiriman(id) {

    resetImg();
    $('#modalImgHeader').removeClass('scale-0');
    $('#bgmodalinput').addClass("effectmodal");

    $('#btn_upload').on('click', function(e) {

      e.preventDefault();

      let formData = new FormData();
      let imgProduk = $('#imgInp')[0].files;

      if (!imgProduk.length > 0) {
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: "Anda Belum mengupload gambar",
        })
      } else {
        formData.append('image_produk', imgProduk[0]);
        formData.append('type', "up_bukti");

        var img_name_produk = formData.get('image_produk')['name'];
        var generateUniqProduk = "<?php echo uniqid('bukti-pengiriman-', true) . '.' . '"+getFileExtension(img_name_produk).toLowerCase()+"' ?>";

        formData.append('img_file_produk', generateUniqProduk);
        formData.append("query", "UPDATE transaksi SET bukti_pengiriman = '" + generateUniqProduk + "' WHERE kode_pesanan = '" + id + "'");

        let loading = "";

        $.ajax({
          type: "post",
          url: "../controllers/invoiceSalesController.php",
          data: formData,
          contentType: false,
          processData: false,
          beforeSend: function() {
            loading = Swal.fire({
              title: 'Loading',
              html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
              allowOutsideClick: false,
              showConfirmButton: false,
            });
          },
          success: function(res) {
            // loading.close();
            const data = JSON.parse(res);

            if (data.status == "error") {
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
                window.location.replace("invoice.php");
              });
            }

          }
        });
      }

    })

  }

  function getFileExtension(fstring) {
    return fstring.slice((Math.max(0, fstring.lastIndexOf(".")) || Infinity) + 1);
  }

  // tab_pointer
  $('#tab1').on('click', function() {
    $('#tab1').addClass('bg-[#444D68]');
    $('#tab2').removeClass('bg-[#444D68]');
    $('#tab3').removeClass('bg-[#444D68]');

    $('#tab1').addClass('text-white');
    $('#tab2').removeClass('text-white');
    $('#tab3').removeClass('text-white');

    $('#page_proses').removeClass('hidden');
    $('#page_kirim').addClass('hidden');
    $('#page_konfirmasi').addClass('hidden');

    // $('#pointer').addClass('tab_invoice_mobile1');
    // $('#pointer').removeClass('tab_invoice_mobile2');
    // $('#pointer').removeClass('tab_invoice_mobile3');
  });

  $('#tab2').on('click', function() {
    $('#tab1').removeClass('bg-[#444D68]');
    $('#tab2').addClass('bg-[#444D68]');
    $('#tab3').removeClass('bg-[#444D68]');

    $('#tab1').removeClass('text-white');
    $('#tab2').addClass('text-white');
    $('#tab3').removeClass('text-white');

    $('#page_proses').addClass('hidden');
    $('#page_kirim').removeClass('hidden');
    $('#page_konfirmasi').addClass('hidden');

    // $('#pointer').removeClass('tab_invoice_mobile1');
    // $('#pointer').addClass('tab_invoice_mobile2');
    // $('#pointer').removeClass('tab_invoice_mobile3');
  });

  $('#tab3').on('click', function() {
    $('#tab1').removeClass('bg-[#444D68]');
    $('#tab2').removeClass('bg-[#444D68]');
    $('#tab3').addClass('bg-[#444D68]');

    $('#tab1').removeClass('text-white');
    $('#tab2').removeClass('text-white');
    $('#tab3').addClass('text-white');

    $('#page_proses').addClass('hidden');
    $('#page_kirim').addClass('hidden');
    $('#page_konfirmasi').removeClass('hidden');

    // $('#pointer').removeClass('tab_invoice_mobile1');
    // $('#pointer').removeClass('tab_invoice_mobile2');
    // $('#pointer').addClass('tab_invoice_mobile3');
  });
</script>

</html>
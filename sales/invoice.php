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

$dataProses = $crud->showData("SELECT transaksi.status_pengiriman, transaksi.status_confirm, transaksi.tanggal, transaksi.kode_pesanan, pegawai.nama AS nama_sales, customer.nama AS nama_cus, transaksi.bukti_pengiriman, customer.alamat_jalan, transaksi.total_harga, transaksi.total_bayar, transaksi.status_pengiriman, cicilan.depan_pembayaran, cicilan.kode_cicilan FROM pegawai JOIN transaksi ON pegawai.id_pegawai = transaksi.id_pegawai JOIN customer ON transaksi.id_customer = customer.id_customer LEFT JOIN cicilan ON transaksi.kode_pesanan = cicilan.kode_pesanan WHERE transaksi.id_pegawai = '" . $_SESSION['id_pegawai'] . "'");

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
  <div id="bgbody" class="w-full h-screen bg-black fixed z-[52] bg-opacity-50 hidden"></div>

  <!-- modal detail invoice -->
  <div class="fixed z-[53] scale-0 transition ease-in-out" id="modal_detail_invoice">

  </div>
  <!-- end modal detail invoice -->

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
        <div onclick="show_detail('<?= $index['kode_pesanan'] ?>')" class="flex flex-col w-[95%] bg-white rounded-lg p-4 shadow-sm">
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
      <?php if ($index["status_pengiriman"] == "kirim" && $index["status_confirm"] == 2 && $index["bukti_pengiriman"] == 0) : ?>
        <div class="flex flex-col w-[95%] bg-white rounded-lg p-4 shadow-sm">
          <div onclick="show_detail('<?= $index['kode_pesanan'] ?>')" class="flex flex-row justify-between items-center w-full h-full">

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

          <div onclick="show_detail('<?= $index['kode_pesanan'] ?>')" class="flex flex-col gap-2 pl-1">
            <p class="text-sm font-ex-semibold"><?= $index["nama_cus"] ?></p>
            <p class="text-xs"><?= $index["alamat_jalan"] ?></p>
          </div>

          <div onclick="show_detail('<?= $index['kode_pesanan'] ?>')" class="py-4">
            <hr class="w-full">
          </div>

          <div class="flex flex-row items-center justify-between pl-1">
            <div onclick="show_detail('<?= $index['kode_pesanan'] ?>')" class="flex flex-col">
              <p class="text-xs">Total</p>
              <p class="text-sm font-ex-semibold"><?= rupiah($index["total_harga"]) ?></p>
            </div>

            <!-- kode lama -->
            <!-- <div onclick="showPengiriman('<?= $index['kode_pesanan'] ?>')" class="cursor-pointer flex justify-center items-center text-xs w-[120px] h-[30px] bg-[#163d64] text-white rounded-md font-ex-medium">
              Bukti Pengiriman
            </div> -->

            <div onclick="confirmPengiriman('<?= $index['kode_pesanan'] ?>')" class="cursor-pointer flex justify-center items-center text-xs px-4 h-[30px] bg-[#163d64] text-white rounded-md font-ex-medium">
              Konfirmasi Pengiriman
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
        <div onclick="show_detail('<?= $index['kode_pesanan'] ?>')" class="flex flex-col w-[95%] bg-white rounded-lg p-4 shadow-sm">
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



  // kode lama
  // $('#modalAddHeader').load("../assets/components/up_bukti_pengiriman.html", function() {
  //   $('#btnOutHeader').on('click', function() {
  //     $('#modalImgHeader').addClass('scale-0');
  //     $('#bgmodalinput').removeClass("effectmodal");
  //   });

  //   $('#btn_out').on('click', function() {
  //     $('#modalImgHeader').addClass('scale-0');
  //     $('#bgmodalinput').removeClass("effectmodal");
  //   });

  //   imgInp.onchange = evt => {
  //     const [file] = imgInp.files
  //     console.log(file);
  //     if (file) {
  //       console.log("masuk");
  //       imgpreview_peg.src = URL.createObjectURL(file);
  //       $('#imgpreview_peg').removeClass("hidden");
  //       $('#imgdefault_peg').addClass("hidden");
  //     }
  //   }
  // });

  // modal detail invoice
  $("#modal_detail_invoice").load("../assets/components/modal_detail_invoice.html", function() {
    $('#ok_btn').on('click', function() {
      console.log("btn_ok");
      $('#modal_detail_invoice').addClass("scale-0");
      $('#bgbody').addClass('scale-0');
      $('#bgbody').removeClass('effectmodal');
    })
    $('#close_detail').on('click', function() {
      console.log("btn_x");
      $('#modal_detail_invoice').addClass("scale-0");
      $('#bgbody').addClass('scale-0');
      $('#bgbody').removeClass('effectmodal');
    })
    console.log("hahai ready");
  });

  // kode lama

  // function resetImg() {
  //   $('#imgInp').val(null);
  //   imgpreview_peg.src = "#";
  //   $('#imgpreview_peg').addClass("hidden");
  //   $('#imgdefault_peg').removeClass("hidden");
  // }

  // function showPengiriman(id) {

  //   resetImg();
  //   $('#modalImgHeader').removeClass('scale-0');
  //   $('#bgmodalinput').addClass("effectmodal");

  //   $('#btn_upload').on('click', function(e) {

  //     e.preventDefault();

  //     let formData = new FormData();
  //     let imgProduk = $('#imgInp')[0].files;

  //     if (!imgProduk.length > 0) {
  //       Swal.fire({
  //         icon: 'error',
  //         title: 'Gagal',
  //         text: "Anda Belum mengupload gambar",
  //       })
  //     } else {
  //       formData.append('image_produk', imgProduk[0]);
  //       formData.append('type', "up_bukti");

  //       var img_name_produk = formData.get('image_produk')['name'];
  //       var generateUniqProduk = "<?php echo uniqid('bukti-pengiriman-', true) . '.' . '"+getFileExtension(img_name_produk).toLowerCase()+"' ?>";

  //       formData.append('img_file_produk', generateUniqProduk);
  //       formData.append("query", "UPDATE transaksi SET bukti_pengiriman = '" + generateUniqProduk + "' WHERE kode_pesanan = '" + id + "'");

  //       let loading = "";

  //       $.ajax({
  //         type: "post",
  //         url: "../controllers/invoiceSalesController.php",
  //         data: formData,
  //         contentType: false,
  //         processData: false,
  //         beforeSend: function() {
  //           loading = Swal.fire({
  //             title: 'Loading',
  //             html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
  //             allowOutsideClick: false,
  //             showConfirmButton: false,
  //           });
  //         },
  //         success: function(res) {
  //           // loading.close();
  //           // alert(res);
  //           const data = JSON.parse(res);

  //           if (data.status == "error") {
  //             Swal.fire({
  //               icon: 'error',
  //               title: 'Gagal',
  //               text: data.msg,
  //             })
  //           } else {
  //             Swal.fire({
  //               icon: 'success',
  //               title: 'Berhasil',
  //               text: data.msg,
  //             }).then(function() {
  //               window.location.replace("invoice.php");
  //             });
  //           }

  //         }
  //       });
  //     }

  //   })

  // }

  function confirmPengiriman(id) {
    Swal.fire({
      icon: 'question',
      title: 'Apakah anda yakin?',
      text: 'Konfirmasi pengiriman barang',
      showDenyButton: true,
      confirmButtonText: 'Ya',
      denyButtonText: `Batal`,
    }).then((result) => {

      // alert("awkokaokwaok")
      let formData = new FormData();
      formData.append('type', "up_bukti");
      formData.append("query", "UPDATE transaksi SET bukti_pengiriman = 1 WHERE kode_pesanan = '" + id + "'");
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
          // alert(res);
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
        console.log(finalData.status_pengiriman);

        let status_pengiriman = finalData.status_confirm != '1' ? "Di " + finalData.status_pengiriman : "Menunggu Konfirmasi";
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
</script>

</html>
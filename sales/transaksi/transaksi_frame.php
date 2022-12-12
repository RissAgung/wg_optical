<?php

session_start();
include "../../config/koneksi.php";

$con = new koneksi();

$idPegawai = $_SESSION["idPeg"];
$dataLens = $con->showData("SELECT * FROM detail_bawa JOIN produk ON detail_bawa.Kode_Frame = produk.kode_frame WHERE detail_bawa.Id_pegawai = '$idPegawai'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaksi</title>
  <link rel="stylesheet" href="../../css/output.css">
  <link rel="stylesheet" href="../../css/sweetalert2.min.css">
</head>

<body class="bg-[#ECECEC] scrollbar-hide">
  <section id="header" class="fixed z-[9999] w-full top-0">
    <div class="flex flex-row px-8 py-6 shadow-lg bg-white">
      <a href="../dashboard.php">
        <svg class="my-[2px]" width="9" height="19" viewBox="0 0 9 19" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M9 1.18543C8.99973 1.50063 8.87945 1.80281 8.66559 2.02555L2.83474 8.10612C2.65826 8.29012 2.51825 8.50857 2.42274 8.749C2.32722 8.98943 2.27806 9.24713 2.27806 9.50738C2.27806 9.76763 2.32722 10.0253 2.42274 10.2658C2.51825 10.5062 2.65826 10.7246 2.83474 10.9086L8.65799 16.9852C8.86566 17.2095 8.98057 17.5098 8.97797 17.8215C8.97537 18.1332 8.85548 18.4314 8.64411 18.6518C8.43274 18.8722 8.1468 18.9972 7.84789 19C7.54898 19.0027 7.26101 18.8828 7.046 18.6663L1.22275 12.5944C0.439753 11.7763 9.53674e-07 10.6676 9.53674e-07 9.51174C9.53674e-07 8.35585 0.439753 7.24719 1.22275 6.42905L7.0536 0.348482C7.21281 0.182346 7.41564 0.0691128 7.63649 0.0230694C7.85735 -0.022974 8.08634 0.000234604 8.29456 0.0897694C8.50278 0.179304 8.68091 0.331152 8.80646 0.526152C8.932 0.721149 8.99935 0.95056 9 1.18543Z" fill="#373F47" />
        </svg>
      </a>
      <h1 class="px-6 font-ex-semibold">Detail Pesanan</h1>
    </div>
  </section>
  <section class="text-[#373F47] font-ex-medium mt-[73px] mb-24" id="konten">
    <div class="flex flex-col overflow-y-auto scrollbar-hide">
      <div class="flex flex-col px-6 py-4 bg-white mt-[0.5px]">
        <h1>Kode Frame</h1>
        <select id="frame" class=" cursor-pointer outline-0 mt-3 md:mt-6 h-16 border-[1px] bg-white border-[#D9D9D9] rounded-md overflow-hidden" name="cars" id="cars">
          <?php foreach ($dataLens as $index) : ?>
            <option class="text-xs" value="<?= $index["harga_jual"] ?>-<?= $index["Id_Bawa"] ?>"><?= $index["Id_Bawa"] ?></option>
          <?php endforeach ?>
        </select>
      </div>

      <div class="flex flex-col px-6 py-4 bg-white mt-[0.5px]">
        <h1>Harga Frame</h1>
        <input id="inputHarga" class="px-4 outline-0 mt-3 md:mt-6 h-16 border-[1px] bg-white border-[#D9D9D9] rounded-md overflow-hidden" type="text" placeholder="Masukkan Harga" name="" id="">
      </div>

    </div>
  </section>
  <div class="fixed z-[9999] font-ex-medium flex flex-col w-full my-auto bg-white py-6 bottom-0">
    <div class="h-[1px] -translate-y-[24px] w-full bg-[#C9C9C9]"></div>

    <div class="flex flex-row justify-center w-full gap-4 h-full px-6 items-center">
      <div class="bg-white border-[1px] h-12 border-[#444D68] w-1/2 text-center rounded-md text-[#444D68] font-ex-semibold flex justify-center items-center">
        <p>Batal</p>
      </div>
      <div onclick="tambah()" class="bg-[#444D68] w-1/2 h-12 text-center rounded-md py-1 text-white font-ex-semibold flex justify-center items-center">
        <p>Tambah</p>
      </div>

    </div>
  </div>

  <script src="../../js/jquery-3.6.1.min.js"></script>
  <script src="../../js/sweetalert2.min.js"></script>
  <script>
    var harga;

    function tambah() {
      var harga_input = parseInt($("#inputHarga").val().replace("Rp. ", "").replace(".", "").replace(".", "").replace(" ", ""));

      var value = $('#frame').val();
      var Vindex = value.indexOf("-");

      var harga = value.substr(0, Vindex);
      var kode = value.substr(Vindex + 1, 10);

      if (harga_input >= harga) {
        console.log("Ok Cuk!");

        var idTR = '<?= strtoupper(str_replace(".", "", uniqid('TR', true))) ?>';

        $.ajax({
          url: "../../controllers/keranjangController.php",
          type: "post",
          data: {
            type: "insert_frame",
            query_keranjang: "INSERT INTO keranjang VALUES ('" + idTR + "',NOW(),'<?= $idPegawai ?>','" + harga_input + "')",
            keranjang_frame: "INSERT INTO keranjang_frame VALUES ('" + idTR + "','" + kode + "','" + harga_input + "')",
          },
          success: function(res) {
            const data = JSON.parse(res);
            if (data.status == 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: data.msg,
              }).then(function() {
                window.location.replace("../dashboard.php");
              });
            }
          }
        })

      } else {
        Swal.fire({
          icon: 'warning',
          title: 'Informasi',
          text: 'Minimal harga bayar ' + formatRupiah(harga, 'Rp. '),
        })
      }
    }

    /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('inputHarga');
    dengan_rupiah.addEventListener('keyup', function(e) {
      dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi */
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
</body>

</html>
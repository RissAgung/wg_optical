<?php
date_default_timezone_set("Asia/Bangkok");
session_start();
include "../../config/koneksi.php";

if (!isset($_SESSION['statusLogin'])) {
  header('Location: ../views/login.php');
} else if ($_SESSION['level'] != 3) {
  header('Location: ../views/dashboard.php');
}

$con = new koneksi();

$idPegawai = $_SESSION["id_pegawai"];
$dataLens = $con->showData("SELECT detail_bawa.Id_Bawa, produk.harga_jual FROM detail_bawa JOIN produk ON detail_bawa.Kode_Frame = produk.Kode_Frame WHERE detail_bawa.Id_pegawai = '$idPegawai' AND detail_bawa.status_frame = 'ready'");
$lens = $con->showData("SELECT * FROM lensa");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../../assets/images/wgLogo.png">
  <title>Transaksi | WG Optical</title>
  <link rel="stylesheet" href="../../css/output.css">
  <link rel="stylesheet" href="../../css/sweetalert2.min.css">
  <link rel="stylesheet" href="../../css/select2.css">
</head>

<body class="bg-[#ECECEC] scrollbar-hide">
  <section id="header" class="fixed z-50 w-full top-0">
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
        <h1 class="mb-4">Kode Frame</h1>
        <select id="frame" class="js-example-basic-single cursor-pointer outline-0 mt-3 md:mt-6 h-16 border-[1px] bg-white border-[#D9D9D9] rounded-md overflow-hidden" name="cars" id="cars">
          <?php foreach ($dataLens as $index) : ?>
            <option class="text-xs" value="<?= $index["harga_jual"] ?>-<?= $index["Id_Bawa"] ?>"><?= $index["Id_Bawa"] ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="flex flex-col px-6 pt-2 pb-8 bg-white">
        <h1 class="">Jenis Lensa</h1>
        <select id="jenis_lensa" class="cursor-pointer outline-0 mt-3 md:mt-6 h-16 border-[1px] bg-white border-[#D9D9D9] rounded-md overflow-hidden">
          <option class="text-xs" value="1">Progresive</option>
          <option class="text-xs" value="2">Single Vision</option>
        </select>
      </div>
      <div class="flex flex-col px-6 pt-2 pb-8 bg-white">
        <h1>Varian Lensa</h1>
        <div class="w-full items-center max-h-[230px] border-[1px] border-[#D9D9D9] rounded-md flex flex-row gap-4 flex-wrap justify-start mt-3 scrollbar overflow-x-hidden p-3">
          <?php foreach ($lens as $index) : ?>
            <div class="flex flex-row p-4 w-32 gap-4">
              <input onclick="choice_variant('<?= $index['kode_lensa'] ?>')" class="flex items-center" type="checkbox" id="lens-<?= $index['kode_lensa'] ?>">
              <label for="lens-<?= $index['kode_lensa'] ?>"><?= $index['nama_lensa'] ?></label>
            </div>
          <?php endforeach ?>
        </div>
      </div>

      <div class="flex flex-col px-6 py-4 bg-white mt-[10px]">
        <h1>Detail Lensa</h1>
        <div class="border-2 rounded-lg mt-2">
          <div class="p-6 overflow-hidden">
            <h1>Kiri</h1>
            <div class="flex flex-row justify-between text-sm pt-4">
              <div class="flex w-1/3 gap-2">
                <h1>SPH:</h1>
                <div class="shadow-md px-4 overflow-hidden w-full">
                  <input onkeypress="return isNumberKey(event)" class="border-0 outline-0" type="text" name="" id="kr-sph">
                </div>
              </div>
              <div class="flex w-1/3 gap-2">
                <h1>CYL:</h1>
                <div class="shadow-md px-4 overflow-hidden w-full">
                  <input onkeypress="return isNumberKey(event)" class="border-0 outline-0" type="text" name="" id="kr-cyl">
                </div>
              </div>
              <div class="flex w-1/3 gap-2">
                <h1>AXIS:</h1>
                <div class="shadow-md px-4 overflow-hidden w-full">
                  <input onkeypress="return isNumberKey(event)" class="border-0 outline-0" type="text" name="" id="kr-axis">
                </div>
              </div>
            </div>
            <div class="flex flex-row justify-between text-sm pt-4">
              <div class="flex w-1/3 gap-2">
                <h1>ADD+:</h1>
                <div class="shadow-md px-4 overflow-hidden w-full">
                  <input onkeypress="return isNumberKey(event)" class="border-0 outline-0" type="text" name="" id="kr-add">
                </div>
              </div>
              <div class="flex w-1/3 gap-2">
                <h1>PD:</h1>
                <div class="shadow-md px-4 overflow-hidden w-full">
                  <input onkeypress="return isNumberKey(event)" class="border-0 outline-0" type="text" name="" id="kr-pd">
                </div>
              </div>
              <div class="flex w-1/3 gap-2">
                <h1>SEG.:</h1>
                <div class="shadow-md px-4 overflow-hidden w-full">
                  <input onkeypress="return isNumberKey(event)" class="border-0 outline-0" type="text" name="" id="kr-seg">
                </div>
              </div>
            </div>
            <div class="h-4"></div>
            <h1>Kanan</h1>
            <div class="flex flex-row justify-between text-sm py-4">
              <div class="flex w-1/3 gap-2">
                <h1>SPH:</h1>
                <div class="shadow-md px-4 overflow-hidden w-full">
                  <input onkeypress="return isNumberKey(event)" class="border-0 outline-0" type="text" name="" id="kn-sph">
                </div>
              </div>
              <div class="flex w-1/3 gap-2">
                <h1>CYL:</h1>
                <div class="shadow-md px-4 overflow-hidden w-full">
                  <input onkeypress="return isNumberKey(event)" class="border-0 outline-0" type="text" name="" id="kn-cyl">
                </div>
              </div>
              <div class="flex w-1/3 gap-2">
                <h1>AXIS:</h1>
                <div class="shadow-md px-4 overflow-hidden w-full">
                  <input onkeypress="return isNumberKey(event)" class="border-0 outline-0" type="text" name="" id="kn-axis">
                </div>
              </div>
            </div>
            <div class="flex flex-row justify-between text-sm pt-0">
              <div class="flex w-1/3 gap-2">
                <h1>ADD+:</h1>
                <div class="shadow-md px-4 overflow-hidden w-full">
                  <input onkeypress="return isNumberKey(event)" class="border-0 outline-0" type="text" name="" id="kn-add">
                </div>
              </div>
              <div class="flex w-1/3 gap-2">
                <h1>PD:</h1>
                <div class="shadow-md px-4 overflow-hidden w-full">
                  <input onkeypress="return isNumberKey(event)" class="border-0 outline-0" type="text" name="" id="kn-pd">
                </div>
              </div>
              <div class="flex w-1/3 gap-2">
                <h1>SEG.:</h1>
                <div class="shadow-md px-4 overflow-hidden w-full">
                  <input onkeypress="return isNumberKey(event)" class="border-0 outline-0" type="text" name="" id="kn-seg">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="flex flex-col px-6 py-4 bg-white mt-[0.5px]">
        <h1>Harga Frame</h1>
        <input id="inputHargaFrame" class="px-4 outline-0 mt-3 md:mt-6 h-16 border-[1px] bg-white border-[#D9D9D9] rounded-md overflow-hidden" type="text" placeholder="Masukkan Harga" name="" id="">
      </div>
      <div class="flex flex-col px-6 pt-2 pb-8 bg-white">
        <h1>Harga Lensa</h1>
        <input id="inputHargaLensa" class="px-4 outline-0 mt-3 md:mt-6 h-16 border-[1px] bg-white border-[#D9D9D9] rounded-md overflow-hidden" type="text" placeholder="Masukkan Harga" name="" id="">
      </div>
    </div>
  </section>
  <div class="fixed z-50 font-ex-medium flex flex-col w-full my-auto bg-white py-6 bottom-0">
    <div class="h-[1px] -translate-y-[24px] w-full bg-[#C9C9C9]"></div>

    <div class="flex flex-row justify-center w-full gap-4 h-full px-6 items-center">
      <a href="../dashboard.php" class="bg-white border-[1px] h-12 border-[#444D68] w-1/2 text-center rounded-md text-[#444D68] font-ex-semibold flex justify-center items-center">
        <p>Batal</p>
      </a>
      <div onclick="tambah()" class="bg-[#444D68] w-1/2 h-12 text-center rounded-md py-1 text-white font-ex-semibold flex justify-center items-center">
        <p>Tambah</p>
      </div>

    </div>
  </div>

  <script src="../../js/jquery-3.6.1.min.js"></script>
  <script src="../../js/select2.js"></script>
  <script src="../../js/sweetalert2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.js-example-basic-single').select2({
        placeholder: "Pilih Kode Frame",
      });
    });
    let variant = [];

    function choice_variant(kode) {
      if ($('#lens-' + kode).is(":checked")) {
        variant.push({
          kode: kode,
        });
        console.log(variant);
      } else {
        for (let index = 0; index < variant.length; index++) {
          const element = variant[index];
          if (element['kode'] == kode) {
            removeItemOnce(variant, element);
          }
        }
        console.log(variant);
      }
    }

    function removeItemOnce(arr, value) {
      var index = arr.indexOf(value);
      if (index > -1) {
        arr.splice(index, 1);
      }
      return arr;
    }



    function tambah() {

      var value = $('#frame').val();
      var Vindex = value.indexOf("-");

      var jenis_lensa = $('#jenis_lensa').val()
      var harga = value.substr(0, Vindex);
      var kode = value.substr(Vindex + 1, 10);

      // resep

      // kiri
      var kr_sph = $('#kr-sph').val();
      var kr_cyl = $('#kr-cyl').val();
      var kr_axis = $('#kr-axis').val();
      var kr_add = $('#kr-add').val();
      var kr_pp = $('#kr-pd').val();
      var kr_seg = $('#kr-seg').val();

      // kanan
      var kn_sph = $('#kn-sph').val();
      var kn_cyl = $('#kn-cyl').val();
      var kn_axis = $('#kn-axis').val();
      var kn_add = $('#kn-add').val();
      var kn_pp = $('#kn-pd').val();
      var kn_seg = $('#kn-seg').val();

      var kode_detail_lens = '<?= strtoupper(str_replace(".", "", uniqid('KDLK', true))) ?>';
      var kode_varian_lensa = '<?= strtoupper(str_replace(".", "", uniqid('KVLK', true))) ?>';


      var hargaFrame = parseInt($("#inputHargaFrame").val().replace("Rp. ", "").replace(".", "").replace(".", "").replace(" ", ""));
      var hargaLensa = parseInt($('#inputHargaLensa').val().replace("Rp. ", "").replace(".", "").replace(".", "").replace(" ", ""));
      var totalHarga = hargaFrame + hargaLensa;

      if (variant.length == 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Informasi',
          text: 'Pilih varian lensa terlebih dahulu',
        })
      } else if (kr_sph == "" || kr_cyl == "" || kr_axis == "" || kr_add == "" || kr_pp == "" || kr_seg == "" || kn_sph == "" || kn_cyl == "" || kn_axis == "" || kn_add == "" || kn_pp == "" || kn_seg == "") {
        Swal.fire({
          icon: 'warning',
          title: 'Informasi',
          text: 'Lengkapi resep terlebih dahulu',
        })
      } else if (hargaFrame < harga) {
        Swal.fire({
          icon: 'warning',
          title: 'Informasi',
          text: 'Minimal harga bayar ' + formatRupiah(harga, 'Rp. '),
        })

      } else if ($('#inputHargaLensa').val() == "") {
        Swal.fire({
          icon: 'warning',
          title: 'Informasi',
          text: 'Masukkan harga lensa terlebih dahulu',
        })
      } else {
        var idTR = '<?= strtoupper(str_replace(".", "", uniqid('TR', true))) ?>';

        $.ajax({
          url: "../../controllers/keranjangController.php",
          type: "post",
          data: {
            type: "insert",
            query_keranjang: "INSERT INTO keranjang VALUES ('" + idTR + "',NOW(),'<?= $idPegawai ?>','" + totalHarga + "')",
            keranjang_frame: "INSERT INTO keranjang_frame VALUES ('" + idTR + "','" + kode + "','" + hargaFrame + "')",
            update_status: "UPDATE detail_bawa SET status_frame='unready' WHERE Id_Bawa = '"+kode+"'",
            query_Keranjang_Lensa: "INSERT INTO `keranjang_lensa`(`kode_varian_lensa_keranjang`, `kode_pesanan`, `id_jenis_lensa`, `harga`) VALUES ('" + kode_varian_lensa + "','" + idTR + "','" + jenis_lensa + "','" + hargaLensa + "')",
            query_keranjang_resep: "INSERT INTO `keranjang_resep`(`kode_varian_lensa_keranjang`, `KN_SPH`, `KN_CYL`, `KN_AXIS`, `KR_SPH`, `KR_CYL`, `KR_AXIS`, `KN_ADD+`, `KN_PD`, `KN_SEG`, `KR_ADD+`, `KR_PD`, `KR_SEG`) VALUES ('" + kode_varian_lensa + "','" + kn_sph + "','" + kn_cyl + "','" + kn_axis + "','" + kr_sph + "','" + kr_cyl + "','" + kr_axis + "','" + kn_add + "','" + kn_pp + "','" + kn_seg + "','" + kr_add + "','" + kr_pp + "','" + kr_seg + "')",
          },
        }).then(function() {
          var variant_sent = new FormData();

          for (let index = 0; index < variant.length; index++) {
            variant_sent.append('data-' + index, JSON.stringify({
              'kode': variant[index]['kode'],
              'kodeVariant': kode_varian_lensa,
            }));
          }

          $.ajax({
            url: "../../controllers/keranjangController.php",
            type: "post",
            data: variant_sent,
            contentType: false,
            processData: false,
            beforeSend: function() {
              Swal.fire({
                title: 'Loading',
                html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
                allowOutsideClick: false,
                showConfirmButton: false,

              });
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
        });


      }

    }


    // only decimal
    function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;

      return true;
    }

    /* Dengan Rupiah */
    var dengan_rupiah_Frame = document.getElementById('inputHargaFrame');
    var dengan_rupiah_Lensa = document.getElementById('inputHargaLensa');
    dengan_rupiah_Frame.addEventListener('keyup', function(e) {
      dengan_rupiah_Frame.value = formatRupiah(this.value, 'Rp. ');
    });
    dengan_rupiah_Lensa.addEventListener('keyup', function(e) {
      dengan_rupiah_Lensa.value = formatRupiah(this.value, 'Rp. ');
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
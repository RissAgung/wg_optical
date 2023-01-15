<?php

  session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <link rel="icon" type="image/x-icon" href="../assets/images/wgLogo.png">
  <title>Nota Pesanan | WG Optical</title>
</head>

<body class="bg-slate-500">
  <!-- container -->
  <div class="absolute my-auto w-full p-8 flex justify-center items-center">
    <div id="content" class="flex flex-col max-w-[500px] max-[399px]:p-2 p-5 bg-white shadow-md rounded-lg">
      Please Wait.....
    </div>
  </div>

  <script src="../js/jquery-3.6.1.min.js"></script>
  <script>
    $(document).ready(function() {
      var kontenHtml = "";

      var statusGet = <?= $statusGet = (isset($_GET["status"]) == null ? "undefined" : $_GET["status"]) ?>;

      if (statusGet != undefined) {
        $.ajax({
          url: '../controllers/detailInvoiceController.php?detail=' + statusGet,
          type: 'GET',
          success: function(res) {
            const data = JSON.parse(res);
            const finalData = data[0];
            const dataPembayaran = finalData.data_pembayaran[0];

            // sendWa
            const wa_nama = finalData.nama_cus.replace(/ /g, "%20");
            const wa_noHp = finalData.nomor_hp.replace(/ /g, "%20").substring(1);
            const wa_jl = finalData.alamat_jalan.replace(/ /g, "%20");
            const wa_kec = finalData.kecamatan.replace(/ /g, "%20");
            const wa_tr = finalData.kode_pesanan.replace(/ /g, "%20");
            const wa_total = formatRupiah(""+dataPembayaran.total_harga, "Rp. ").replace(/ /g, "%20");
            const wa_bayar = formatRupiah(""+dataPembayaran.total_bayar, "Rp. ").replace(/ /g, "%20");
            const wa_kembalian = formatRupiah(""+dataPembayaran.kembalian, "Rp. ").replace(/ /g, "%20");
            const wa_status = dataPembayaran.total_bayar >= dataPembayaran.total_harga ? "LUNAS" : "BELUM";

            const waMe = 'http://wa.me/62' + wa_noHp + '?text=*NOTA%20ELEKTRONIK*%0A%0Ahttp://localhost/Workshop_web/src/views/digitalbill.php?status=' + encodeURI("%27"+wa_tr+"%27") + '%0A%0APelanggan%20Yth.%0A' + wa_nama + ',%0Ano:62' + wa_noHp + '%0A' + wa_jl + '%20' + wa_kec + '%0A%0A*Ket*%20:%0A==========%0ADetail%20:%0AKode%20Transaksi%20:%20' + wa_tr + '%0ATotal%20Tagihan%20:%20' + wa_total + '%0ANominal%20Bayar%20:%20' + wa_bayar + '%0AKembalian%20:%20' + wa_kembalian + '%0A%0AStatus%20:%20' + wa_status + '%0A%0A*TERIMAKASIH*';

            console.log(waMe);

            kontenHtml += '<div class="flex flex-row items-center justify-between py-2 px-3">'
            kontenHtml += '<div class="w-10 h-10 bg-black rounded-md overflow-hidden">'
            kontenHtml += '<img src="../assets/images/wgLogo.png" alt="logo wg" class="w-10 h-10 object-cover">'
            kontenHtml += '</div>'
            kontenHtml += '<h1 class="font-ex-semibold text-xl text-[#D77418]">Invoice</h1>'
            kontenHtml += '</div>'

            kontenHtml += '<div class="flex flex-col items-end text-xs p-3">'
            kontenHtml += '<p>No Pesanan ' + finalData.kode_pesanan + '</p>'
            kontenHtml += '<p>' + finalData.tanggal + '</p>'
            kontenHtml += '</div>'

            kontenHtml += '<div class="flex flex-row justify-center font-ex-semibold px-3">'
            kontenHtml += '<h1>WG Optical</h1>'
            kontenHtml += '</div>'

            kontenHtml += '<div class="flex flex-col text-xs px-3 py-9 gap-1">'
            kontenHtml += '<p>Hallo, ' + finalData.nama_cus + '.</p>'
            kontenHtml += '<p>Terimakasih telah membeli produk kami</p>'
            kontenHtml += '</div>'

            kontenHtml += '<div class="flex flex-row px-3 pb-7 pt-3">'

            kontenHtml += '<div class="flex flex-col w-[50%] text-start text-xs">'
            kontenHtml += '<h2 class="uppercase font-ex-semibold text-gray-600 mb-5">informasi transaksi</h2>'
            kontenHtml += '<div class="flex flex-col gap-1">'
            kontenHtml += '<p>' + finalData.nama_cus + '</p>'
            kontenHtml += '<p>' + finalData.kecamatan + '</p>'
            kontenHtml += '<p>' + finalData.pekerjaan + '</p>'
            kontenHtml += '<p>No: ' + finalData.nomor_hp + '</p>'
            kontenHtml += '</div>'

            kontenHtml += '</div>'

            kontenHtml += '<div class="flex flex-col w-[50%] text-end text-xs">'
            kontenHtml += '<h2 class="uppercase font-ex-semibold text-gray-600 mb-5">metode pembayaran</h2>'
            kontenHtml += '<div class="flex flex-col">'

            const statusTR = dataPembayaran.depan_pembayaran == null ? "Lunas" : "Cicilan";
            let status_pengiriman = finalData.status_confirm != '1' ? "Di " + finalData.status_pengiriman : "Menunggu Konfirmasi";

            kontenHtml += '<p>Status Pembayaran: </p>'
            kontenHtml += '<strong class="text-red-500">' + statusTR + '</strong>'
            kontenHtml += '</div>'
            kontenHtml += '</div>'

            kontenHtml += '</div>'


            kontenHtml += '<div class="flex flex-row justify-between text-xs px-3 font-ex-semibold">'
            kontenHtml += '<div class="flex flex-col w-[50%] text-start">Detail Pesanan</div>'
            kontenHtml += '<div class="flex flex-col w-[23%] text-center">Sub Harga</div>'
            kontenHtml += '<div class="flex flex-col w-[23%] text-end">Total Harga</div>'
            kontenHtml += '</div>'

            kontenHtml += '<div class="px-3 py-2">'
            kontenHtml += '<hr>'
            kontenHtml += '</div>'

            kontenHtml += '<div class="flex flex-col w-full justify-between text-xs px-3">'

            const indexPesanan = finalData.data_pesanan;
            const indexPembayaran = finalData.data_pembayaran;

            for (var index = 0; index < indexPesanan.length; index++) {

              const finalPesanan = indexPesanan[index];

              function totalHarga() {

                if (finalPesanan.harga_frame != null && finalPesanan.harga_lensa == null) {
                  return parseInt(finalPesanan.harga_frame);
                } else if (finalPesanan.harga_frame == null && finalPesanan.harga_lensa != null) {
                  return parseInt(finalPesanan.harga_lensa);
                } else if (finalPesanan.harga_frame != null && finalPesanan.harga_lensa != null) {
                  return parseInt(finalPesanan.harga_frame) + parseInt(finalPesanan.harga_lensa);
                }
              }
              console.log("hahaiwdadasd " + finalPesanan.harga_lensa)

              kontenHtml += '<div class="flex flex-col gap-1 py-3">'

              const jenisPesanan = finalPesanan.harga_frame != null && finalPesanan.harga_lensa != null ? "Full Set" : (finalPesanan.harga_frame == null && finalPesanan.harga_lensa != null ? "Lensa" : (finalPesanan.harga_frame != null && finalPesanan.harga_lensa == null ? "frame" : "Tidak Ada Pesanan"));
              kontenHtml += '<p class="text-start mb-2"><strong class="text-red-500">' + jenisPesanan + '</strong></p>'

              kontenHtml += '<div class="flex flex-row justify-between w-full">'

              kontenHtml += '<div class="flex flex-col w-full">'

              if (finalPesanan.frame != null) {
                kontenHtml += '<div class="flex flex-row justify-between items-center py-2">'
                kontenHtml += '<p class="break-words w-[40%]">Frame : ' + finalPesanan.frame + '</p>'
                kontenHtml += '<p class="text-center break-words w-[50%] h-full">' + formatRupiah("" + finalPesanan.harga_frame, "Rp. ") + '</p>'
                kontenHtml += '</div>'
              }

              if (finalPesanan.lensa[0][0] != null) {
                // console.log("kontol"+index)

                let hasilLensa = "";

                for (let indexLensa = 0; indexLensa < finalPesanan.lensa.length; indexLensa++) {
                  hasilLensa += finalPesanan.lensa[indexLensa][0] + ", ";
                }

                kontenHtml += '<div class="flex flex-row justify-between items-center py-2">'
                kontenHtml += '<div class="w-[50%]">'
                kontenHtml += '<p class="break-words">Lensa : ' + hasilLensa.substring(0, hasilLensa.length - 2) + '</p>'
                kontenHtml += '</div>'

                kontenHtml += '<div class="h-full text-center w-[50%]">'
                kontenHtml += formatRupiah("" + finalPesanan.harga_lensa, "Rp. ")
                kontenHtml += '</div>'
                kontenHtml += '</div>'
              }

              kontenHtml += '</div>'

              kontenHtml += '<p class="text-end break-words w-[20%] py-2">'
              kontenHtml += formatRupiah("" + totalHarga(), "Rp. ")
              kontenHtml += '</p>'
              kontenHtml += '</div>'

              if (finalPesanan.lensa[0][0] != null) {
                kontenHtml += '<div class="flex flex-row w-full items-center justify-center">'
                kontenHtml += '<div class="flex flex-col mt-2 w-full">'
                kontenHtml += '<p class="mb-2">Kanan</p>'

                kontenHtml += '<div class="flex flex-row">'
                kontenHtml += '<p class="w-[40%]">SPH</p>'
                kontenHtml += '<p class="w-[10%]">:</p>'
                kontenHtml += '<p class="w-[40%]">' + finalPesanan.kn_sph + '</p>'
                kontenHtml += '</div>'

                kontenHtml += '<div class="flex flex-row">'
                kontenHtml += '<p class="w-[40%]">CYL</p>'
                kontenHtml += '<p class="w-[10%]">:</p>'
                kontenHtml += '<p class="w-[40%]">' + finalPesanan.kn_cyl + '</p>'
                kontenHtml += '</div>'

                kontenHtml += '<div class="flex flex-row">'
                kontenHtml += '<p class="w-[40%]">AXIS</p>'
                kontenHtml += '<p class="w-[10%]">:</p>'
                kontenHtml += '<p class="w-[40%]">' + finalPesanan.kn_axis + '</p>'
                kontenHtml += '</div>'

                kontenHtml += '<div class="flex flex-row">'
                kontenHtml += '<p class="w-[40%]">ADD+</p>'
                kontenHtml += '<p class="w-[10%]">:</p>'
                kontenHtml += '<p class="w-[40%]">' + finalPesanan.kn_add + '</p>'
                kontenHtml += '</div>'

                kontenHtml += '<div class="flex flex-row">'
                kontenHtml += '<p class="w-[40%]">PD</p>'
                kontenHtml += '<p class="w-[10%]">:</p>'
                kontenHtml += '<p class="w-[40%]">' + finalPesanan.kn_pd + '</p>'
                kontenHtml += '</div>'

                kontenHtml += '<div class="flex flex-row">'
                kontenHtml += '<p class="w-[40%]">SEG</p>'
                kontenHtml += '<p class="w-[10%]">:</p>'
                kontenHtml += '<p class="w-[40%]">' + finalPesanan.kn_seg + '</p>'
                kontenHtml += '</div>'
                kontenHtml += '</div>'

                kontenHtml += '<div class="flex flex-col mt-2 w-full">'
                kontenHtml += '<p class="mb-2">Kiri</p>'

                kontenHtml += '<div class="flex flex-row">'
                kontenHtml += '<p class="w-[40%]">SPH</p>'
                kontenHtml += '<p class="w-[10%]">:</p>'
                kontenHtml += '<p class="w-[40%]">' + finalPesanan.kr_sph + '</p>'
                kontenHtml += '</div>'

                kontenHtml += '<div class="flex flex-row">'
                kontenHtml += '<p class="w-[40%]">CYL</p>'
                kontenHtml += '<p class="w-[10%]">:</p>'
                kontenHtml += '<p class="w-[40%]">' + finalPesanan.kr_cyl + '</p>'
                kontenHtml += '</div>'

                kontenHtml += '<div class="flex flex-row">'
                kontenHtml += '<p class="w-[40%]">AXIS</p>'
                kontenHtml += '<p class="w-[10%]">:</p>'
                kontenHtml += '<p class="w-[40%]">' + finalPesanan.kr_axis + '</p>'
                kontenHtml += '</div>'

                kontenHtml += '<div class="flex flex-row">'
                kontenHtml += '<p class="w-[40%]">ADD+</p>'
                kontenHtml += '<p class="w-[10%]">:</p>'
                kontenHtml += '<p class="w-[40%]">' + finalPesanan.kr_add + '</p>'
                kontenHtml += '</div>'

                kontenHtml += '<div class="flex flex-row">'
                kontenHtml += '<p class="w-[40%]">PD</p>'
                kontenHtml += '<p class="w-[10%]">:</p>'
                kontenHtml += '<p class="w-[40%]">' + finalPesanan.kr_pd + '</p>'
                kontenHtml += '</div>'

                kontenHtml += '<div class="flex flex-row">'
                kontenHtml += '<p class="w-[40%]">SEG</p>'
                kontenHtml += '<p class="w-[10%]">:</p>'
                kontenHtml += '<p class="w-[40%]">' + finalPesanan.kr_seg + '</p>'
                kontenHtml += '</div>'
                kontenHtml += '</div>'
                kontenHtml += '</div>'
              }
              kontenHtml += '</div>'
            }

            kontenHtml += '</div>'

            kontenHtml += '<div class="px-3 py-2">'
            kontenHtml += '<hr>'
            kontenHtml += '</div>'

            kontenHtml += '<div class="flex flex-col items-center w-full p-3 text-xs">'
            kontenHtml += '<div class="max-[321px]:w-[90%] w-[70%] flex flex-col items-center gap-1">'
            kontenHtml += '<strong class="mb-3">Info Pembayaran</strong>'
            kontenHtml += '<div class="flex flex-row w-full justify-end gap">'
            kontenHtml += '<h1 class="w-[50%] text-start">Total Harga</h1>'
            kontenHtml += '<h1 class="w-[10%]"></h1>'
            kontenHtml += '<h1 class="w-[40%] items-end">' + formatRupiah("" + dataPembayaran.total_harga, "Rp. ") + '</h1>'
            kontenHtml += '</div>'

            if (dataPembayaran.depan_pembayaran == null) {
              kontenHtml += '<div class="flex flex-row w-full justify-end gap">'
              kontenHtml += '<h1 class="w-[50%] text-start">Total Bayar</h1>'
              kontenHtml += '<h1 class="w-[10%]"></h1>'
              kontenHtml += '<h1 class="w-[40%] items-end">' + formatRupiah("" + dataPembayaran.total_bayar, "Rp. ") + '</h1>'
              kontenHtml += '</div>'
            } else {
              kontenHtml += '<div class="flex flex-row w-full justify-end gap">'
              kontenHtml += '<h1 class="w-[50%] text-start">Uang Muka</h1>'
              kontenHtml += '<h1 class="w-[10%]"></h1>'
              kontenHtml += '<h1 class="w-[40%] items-end">' + formatRupiah("" + dataPembayaran.depan_pembayaran, "Rp. ") + '</h1>'
              kontenHtml += '</div>'

              if (finalData.data_cicilan[0]["total_bayar"] != null) {
                for (let indexCicilan = 0; indexCicilan < finalData.data_cicilan.length; indexCicilan++) {
                  kontenHtml += '<div class="flex flex-row w-full justify-end gap">'
                  kontenHtml += '<h1 class="w-[50%] text-start">Pembayaran ' + (indexCicilan + 1) + '</h1>'
                  kontenHtml += '<h1 class="w-[10%]"></h1>'
                  let jumlahcicilan = finalData.data_cicilan[indexCicilan]["total_bayar"];
                  kontenHtml += '<h1 class="w-[40%] items-end">' + formatRupiah("" + jumlahcicilan, "Rp. ") + '</h1>'
                  kontenHtml += '</div>'
                }
              }
            }

            kontenHtml += '<div class="flex flex-row w-full mt-3 justify-end gap">'
            kontenHtml += '<h1 class="w-[50%] text-start">Lunas / Belum</h1>'
            let lunasOrNot = dataPembayaran.total_bayar >= dataPembayaran.total_harga ? "Lunas" : "Belum";
            kontenHtml += '<h1 class="w-[10%]"></h1>'
            kontenHtml += '<h1 class="w-[40%] items-end">' + lunasOrNot + '</h1>'
            kontenHtml += '</div>'

            kontenHtml += '<div class="flex flex-row w-full font-ex-semibold justify-end gap">'
            kontenHtml += '<h1 class="w-[50%] text-start">Kembali</h1>'
            kontenHtml += '<h1 class="w-[10%]"></h1>'
            kontenHtml += '<h1 class="w-[40%] items-end">' + formatRupiah("" + dataPembayaran.kembalian, "Rp. ") + '</h1>'
            kontenHtml += '</div>'

            kontenHtml += '</div>'
            kontenHtml += '</div>'

            kontenHtml += '<div class=" text-center w-full p-3 text-xs">'
            kontenHtml += 'Terimakasih'
            kontenHtml += '</div>'

            var account_check = <?= $statusGet = (isset($_SESSION["id_pegawai"]) == null ? "undefined" : $_SESSION["id_pegawai"]) ?>;

            console.log(account_check);
            if (account_check != undefined) {
              kontenHtml += '<a href="' + waMe + '" class="cursor-pointer flex flex-row items-center justify-center gap-3 bg-[#3C9781] hover:bg-[#2C6A5B] transition ease-in-out text-center w-[70%] mx-auto rounded-full p-3 text-xs">'
              kontenHtml += '<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="25px" height="25px" fill="#FFFFFF">   <path d="M25,2C12.318,2,2,12.318,2,25c0,3.96,1.023,7.854,2.963,11.29L2.037,46.73c-0.096,0.343-0.003,0.711,0.245,0.966 C2.473,47.893,2.733,48,3,48c0.08,0,0.161-0.01,0.24-0.029l10.896-2.699C17.463,47.058,21.21,48,25,48c12.682,0,23-10.318,23-23 S37.682,2,25,2z M36.57,33.116c-0.492,1.362-2.852,2.605-3.986,2.772c-1.018,0.149-2.306,0.213-3.72-0.231 c-0.857-0.27-1.957-0.628-3.366-1.229c-5.923-2.526-9.791-8.415-10.087-8.804C15.116,25.235,13,22.463,13,19.594 s1.525-4.28,2.067-4.864c0.542-0.584,1.181-0.73,1.575-0.73s0.787,0.005,1.132,0.021c0.363,0.018,0.85-0.137,1.329,1.001 c0.492,1.168,1.673,4.037,1.819,4.33c0.148,0.292,0.246,0.633,0.05,1.022c-0.196,0.389-0.294,0.632-0.59,0.973 s-0.62,0.76-0.886,1.022c-0.296,0.291-0.603,0.606-0.259,1.19c0.344,0.584,1.529,2.493,3.285,4.039 c2.255,1.986,4.158,2.602,4.748,2.894c0.59,0.292,0.935,0.243,1.279-0.146c0.344-0.39,1.476-1.703,1.869-2.286 s0.787-0.487,1.329-0.292c0.542,0.194,3.445,1.604,4.035,1.896c0.59,0.292,0.984,0.438,1.132,0.681 C37.062,30.587,37.062,31.755,36.57,33.116z"/></svg>'
              kontenHtml += '<p class="font-ex-semibold text-white">Kirim Nota</p>'
              kontenHtml += '</a>'
            }

            $('#content').html(kontenHtml);
          }
        });
      } else {
        $('#content').html("Pesanan tidak valid");
      }
    })

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
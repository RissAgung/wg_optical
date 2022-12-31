<?php
require "../config/koneksi.php";
$crud = new koneksi();

// pagination
$jumlahDataPerHalaman = 6;
$jumlahData = (isset($_GET["search"])) ? count($crud->showData("SELECT * FROM perlengkapan WHERE kode_perlengkapan LIKE'%" . $_GET["search"] . "%' LIMIT 0, $jumlahDataPerHalaman")) : count($crud->showData("SELECT * FROM perlengkapan"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$data = (isset($_GET["search"])) ? $crud->showData("SELECT * FROM perlengkapan WHERE kode_perlengkapan  LIKE'%" . $_GET["search"] . "%' LIMIT $awalData, $jumlahDataPerHalaman") : $crud->showData("SELECT * FROM perlengkapan LIMIT $awalData, $jumlahDataPerHalaman");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <link rel="stylesheet" href="../css/sweetalert2.min.css">
  <title>Barang Perlengkapan</title>
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">
  <!-- logout modal -->

  <!-- modal -->
  <div id="modal">

  </div>
  <!-- end modal -->

  <!-- modal delete -->
  <div id="modal-delete" class=""></div>
  <!-- modal delete -->

  <!-- Background hitam saat sidebar show -->
  <div id="bgbody" class="w-full h-screen bg-black fixed z-50 bg-opacity-50 hidden"></div>
  <!-- End Background hitam saat sidebar show -->

  <!-- sidebar -->
  <div id="ex-sidebar" class="ex-sidebar ex-hide-sidebar fixed z-50 max-lg:transition max-lg:duration-[1s]"></div>
  <!-- end sidebar -->

  <div class="lg:ml-72">

    <!-- top bar -->
    <div id="top_bar">
    </div>

    <div class="mt-3 flex items-center justify-between flex-col md:flex-row md:justify-around  lg:justify-between lg:px-16 md:py-[3px]">

      <!-- Tab Bar -->
      <!-- <div class="w-44 box-border p-1.5 shadow-sm rounded-md flex justify-between flex-row text-sm font-ex-semibold bg-white">
        <div class="transition bg-[#343948] h-8 w-[80px] absolute rounded-md translate-x-0 ease-in-out" id="bgtab">
        </div>
        <div class="flex justify-center py-1.5 w-20 rounded-md tab-focus cursor-pointer" id="tab_table">Table</div>
        <div class="flex justify-center py-1.5 w-20 rounded-md cursor-pointer" id="tab_catalog">Catalog</div>
      </div> -->

      <!-- Search and Button Add -->
      <div class="flex flex-col md:flex-row items-center mt-3 md:mt-0">

        <!-- Search -->
        <div class="flex flex-row shadow-sm rounded-md items-center bg-white box-border px-2 md:mr-6">
          <svg width="19" height="19" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-3">
            <path d="M19.2502 19.25L15.138 15.1305M17.4168 9.62501C17.4168 11.6915 16.5959 13.6733 15.1347 15.1346C13.6735 16.5958 11.6916 17.4167 9.62516 17.4167C7.55868 17.4167 5.57684 16.5958 4.11562 15.1346C2.6544 13.6733 1.8335 11.6915 1.8335 9.62501C1.8335 7.55853 2.6544 5.57669 4.11562 4.11547C5.57684 2.65425 7.55868 1.83334 9.62516 1.83334C11.6916 1.83334 13.6735 2.65425 15.1347 4.11547C16.5959 5.57669 17.4168 7.55853 17.4168 9.62501V9.62501Z" stroke="#797E8D" stroke-width="2" stroke-linecap="round" />
          </svg>
          <?php $input = (isset($_GET["search"])) ? $_GET["search"] : null ?>
          <input id="search" value="<?= $input ?>" type="text" placeholder="Type here" class="h-11 bg-transparent ml-2 outline-none" />
        </div>

      </div>
      <!-- End Search -->

      <!-- Button Add -->
      <div class="  md:my-auto h-10 w-24 font-ex-semibold text-white mt-3 md:mt-0" id="click-modal">
        <button class="bg-[#3DBD9E] h-full w-full rounded-md">Tambah</button>
      </div>
      <!-- End Button Add -->
      <!-- End Search and Button Add -->
    </div>
    <!-- konten table -->
    <div class="" id="table">
      <!--table-->
      <div class="overflow-x-auto  text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 ex-table">
        <table class="w-full">
          <thead class="border-b-2 border-gray-100">
            <tr>
              <th class="p-3 text-sm tracking-wide text-center">No</th>
              <th class="p-3 text-sm tracking-wide text-center">Kode Barang Perlengkapan</th>
              <th class="p-3 text-sm tracking-wide text-center">Nama Barang Perlengkapan</th>
              <th class="p-3 text-sm tracking-wide text-center">Stock</th>
              <!-- <th class="p-3 text-sm tracking-wide text-center">unknow</th> -->
              <th class="p-3 text-sm tracking-wide text-center">aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $nomer = ($jumlahDataPerHalaman * $halamanAktif) - ($jumlahDataPerHalaman - 1) ?>
            <?php $i = 1 ?>
            <?php foreach ($data as $index) : ?>
              <tr>
                <td class="p-3 text-sm tracking-wide text-center"><?= $nomer ?></td>
                <td class="p-3 text-sm tracking-wide text-center"><?= $index["kode_perlengkapan"] ?></td>
                <td class="p-3 text-sm tracking-wide text-center"><?= $index["nama_perlengkapan"] ?></td>
                <td class="p-3 text-sm tracking-wide text-center"><?= $index["stock"] ?></td>
                <!-- <td></td> -->
                <td class="p-3 text-sm tracking-wide text-center"">
                  <button id="edit-button-<?= $i; ?>">
                    <svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="37" height="37" rx="5" fill="#EDC683" />
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M27.4782 8.38256C27.7335 8.48841 27.9655 8.64355 28.1609 8.83911C28.3564 9.03447 28.5116 9.26646 28.6174 9.52181C28.7233 9.77717 28.7777 10.0509 28.7777 10.3273C28.7777 10.6037 28.7233 10.8774 28.6174 11.1328C28.5116 11.3881 28.3564 11.6201 28.1609 11.8155L25.3473 14.6282L22.3717 11.6526L25.1845 8.83911C25.3798 8.64355 25.6118 8.48841 25.8672 8.38256C26.1225 8.27671 26.3962 8.22223 26.6727 8.22223C26.9491 8.22223 27.2228 8.27671 27.4782 8.38256ZM9.59277 25.7604C9.59295 24.9094 9.93117 24.0933 10.533 23.4916L21.2376 12.787L24.2132 15.7626L13.5086 26.4672C12.9069 27.069 12.0908 27.4072 11.2398 27.4074H9.59277V25.7604Z" fill="#3F2C0D" />
                    </svg>
                  </button>
                  <button id="delete-button-<?= $i ?>">
                    <svg width="38" height="37" viewBox="0 0 38 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect x="0.444336" width="37" height="37" rx="5" fill="#F35E58" />
                      <path d="M23.3982 10.5062V8.67903C23.3982 8.19444 23.2105 7.72969 22.8764 7.38703C22.5423 7.04437 22.0892 6.85187 21.6167 6.85187H16.2723C15.7998 6.85187 15.3467 7.04437 15.0126 7.38703C14.6785 7.72969 14.4908 8.19444 14.4908 8.67903V10.5062H10.0371V12.3333H11.8186V26.0371C11.8186 26.7639 12.1001 27.4611 12.6013 27.975C13.1024 28.489 13.7821 28.7778 14.4908 28.7778H23.3982C24.1069 28.7778 24.7866 28.489 25.2878 27.975C25.7889 27.4611 26.0704 26.7639 26.0704 26.0371V12.3333H27.8519V10.5062H23.3982ZM18.0538 22.3827H16.2723V16.9012H18.0538V22.3827ZM21.6167 22.3827H19.8353V16.9012H21.6167V22.3827ZM21.6167 10.5062H16.2723V8.67903H21.6167V10.5062Z" fill="#501614" />
                    </svg>
                  </button>
                </td>
              </tr>
              <?php $nomer++ ?>
              <?php $i++ ?>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <!-- Pagination And Info Data -->
      <div class="flex flex-col-reverse md:flex-row lg:flex-row lg:justify-between md:justify-around lg:px-16 lg:mt-5 items-center mt-3 text-sm">
        <div class="flex flex-row mb-3 font-ex-semibold">
          <?php if ($halamanAktif > 4 && $jumlahHalaman > 4) : ?>
            <a class="no-underline" href="?halaman=<?= $halamanAktif - 1 ?>">
              <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white transition ease-in-out hover:bg-[#e7e7e7] drop-shadow-md">
                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8 0.748694C7.99976 0.947765 7.89284 1.13862 7.70275 1.2793L2.51977 5.11966C2.36289 5.23587 2.23845 5.37384 2.15354 5.52569C2.06864 5.67754 2.02494 5.84029 2.02494 6.00466C2.02494 6.16903 2.06864 6.33178 2.15354 6.48363C2.23845 6.63549 2.36289 6.77346 2.51977 6.88967L7.69599 10.7275C7.88058 10.8691 7.98272 11.0588 7.98042 11.2557C7.97811 11.4525 7.87153 11.6409 7.68365 11.7801C7.49576 11.9193 7.2416 11.9983 6.9759 12C6.71021 12.0017 6.45423 11.926 6.26311 11.7892L1.08689 7.95437C0.390892 7.43766 4.76837e-07 6.73745 4.76837e-07 6.00741C4.76837e-07 5.27738 0.390892 4.57717 1.08689 4.06045L6.26986 0.220095C6.41138 0.115167 6.59168 0.0436506 6.78799 0.0145702C6.98431 -0.0145102 7.18786 0.000148773 7.37294 0.0566969C7.55803 0.113245 7.71636 0.209149 7.82796 0.332306C7.93956 0.455462 7.99942 0.600353 8 0.748694Z" fill="#343948" />
                </svg>
              </div>
            </a>
          <?php endif ?>

          <?php if ($jumlahHalaman > 1) : ?>
            <?php if ($halamanAktif > 4) : ?>
              <?php for ($i = $halamanAktif - 3; $i <= $halamanAktif; $i++) : ?>
                <?php if ($i == $halamanAktif) : ?>
                  <a class="no-underline text-white" href="?halaman=<?= $i ?>">
                    <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-[#5C6171] drop-shadow-md"><?= $i ?></div>
                  </a>
                <?php else : ?>
                  <a class="no-underline" href="?halaman=<?= $i ?>">
                    <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white transition ease-in-out hover:bg-[#e7e7e7] drop-shadow-md"><?= $i ?></div>
                  </a>
                <?php endif ?>
              <?php endfor ?>
            <?php else : ?>
              <?php if ($jumlahHalaman > 4) : ?>
                <?php for ($i = 1; $i <= 4; $i++) : ?>
                  <?php if ($i == $halamanAktif) : ?>
                    <a class="no-underline text-white" href="?halaman=<?= $i ?>">
                      <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-[#5C6171] drop-shadow-md"><?= $i ?></div>
                    </a>
                  <?php else : ?>
                    <a class="no-underline" href="?halaman=<?= $i ?>">
                      <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white transition ease-in-out hover:bg-[#e7e7e7] drop-shadow-md"><?= $i ?></div>
                    </a>
                  <?php endif ?>
                <?php endfor ?>
              <?php else : ?>
                <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                  <?php if ($i == $halamanAktif) : ?>
                    <a class="no-underline text-white" href="?halaman=<?= $i ?>">
                      <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-[#5C6171] drop-shadow-md"><?= $i ?></div>
                    </a>
                  <?php else : ?>
                    <a class="no-underline" href="?halaman=<?= $i ?>">
                      <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white transition ease-in-out hover:bg-[#e7e7e7] drop-shadow-md"><?= $i ?></div>
                    </a>
                  <?php endif ?>
                <?php endfor ?>
              <?php endif ?>

            <?php endif ?>
          <?php endif ?>

          <?php if ($halamanAktif < $jumlahHalaman && $jumlahHalaman > 4) : ?>
            <a class="no-underline" href="?halaman=<?= $halamanAktif + 1 ?>">
              <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white transition ease-in-out hover:bg-[#e7e7e7] drop-shadow-md">
                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 11.2513C0.00023652 11.0522 0.107156 10.8614 0.297251 10.7207L5.48023 6.88034C5.63711 6.76413 5.76155 6.62616 5.84646 6.47431C5.93136 6.32246 5.97506 6.15971 5.97506 5.99534C5.97506 5.83097 5.93136 5.66822 5.84646 5.51637C5.76155 5.36451 5.63711 5.22654 5.48023 5.11033L0.304007 1.27248C0.119416 1.13087 0.0172752 0.941199 0.019584 0.744328C0.0218929 0.547457 0.128467 0.359134 0.316351 0.21992C0.504235 0.0807055 0.758398 0.00173914 1.0241 2.83842e-05C1.28979 -0.00168237 1.54577 0.0739993 1.73689 0.210773L6.91311 4.04563C7.60911 4.56234 8 5.26255 8 5.99259C8 6.72262 7.60911 7.42283 6.91311 7.93955L1.73014 11.7799C1.58862 11.8848 1.40832 11.9563 1.21201 11.9854C1.01569 12.0145 0.812142 11.9999 0.627057 11.9433C0.441971 11.8868 0.283639 11.7909 0.17204 11.6677C0.0604405 11.5445 0.000575787 11.3996 0 11.2513Z" fill="#343948" />
                </svg>
              </div>
            </a>
          <?php endif ?>

        </div>
        <div class="mb-3"><?= count($data) ?> from <?= $jumlahData ?> data</div>
      </div>
      <!-- End Pagination And Info Data -->
    </div>
  </div>
  <script src="../js/jquery-3.6.1.min.js"></script>
  <script src="../js/sweetalert2.min.js"></script>
  <script>
    var kode_perlengkapan;
    var nama_perlengkapan;

    function getData() {
      kode_perlengkapan = $("#kode_perlengkapan").val();
      nama_perlengkapan = $("#nama_perlengkapan").val();
    }
    // top_bar
    $('#top_bar').load("../assets/components/top_bar.php", function() {
      $("#burger").on("click", function() {
        $('#bgbody').toggleClass("hidden");

        $('#ex-sidebar').toggleClass("ex-hide-sidebar");
        $('#burger').toggleClass("show");
      });

      $("#bgbody").on("click", function() {
        $('#ex-sidebar').toggleClass("ex-hide-sidebar");
        $('#burger').toggleClass("show");

        $('#bgbody').toggleClass("hidden");

      });

    });

    // load sidebar
    $("#ex-sidebar").load("../assets/components/sidebar.html", function() {
      $('#master_data').addClass("hover-sidebar");

    });

    // reset 
    var input = '<?= $input ?>';
    if (input !== "") {
      $('#btn_reset').removeClass('hidden');
      $('#btn_reset').addClass('flex');
      $('#btn_reset').on('click', function() {
        window.location.replace("master_barang_perlengkapan.php");
      })
    }

    function getFileExtension(fstring) {
      return fstring.slice((Math.max(0, fstring.lastIndexOf(".")) || Infinity) + 1);
    }

    //load modalinput 
    $('#modal').load("../assets/components/modal_barang_perlengkapan.html", function() {
      //tambah
      $('#click-modal').on('click', function() {
        console.log("modal tambah ")
        
        chenge("tambah");

        $('#bgmodalinput').addClass("effectmodal");
        $('#modalkonten').toggleClass("scale-0");

        //chenge("tambah");
        reset();

        $('#title').html('Tambah Data');
        $('#btn_tambah').html('Tambah');
        $("#btn_tambah").on("click", function(e) {
          console.log("tambah di click");

          e.preventDefault();
          getData();

          let formData = new FormData();
          //let query;

          if (kode_perlengkapan == "") {
            swal.fire({
              icon: 'error',
              title: 'gagal',
              text: "kode barang tidak boleh kosong ",
            })
          } else if (nama_perlengkapan == "") {
            swal.fire({
              icon: 'error',
              title: 'gagal',
              text: "nama barang tidak boleh kosong",
            })

          } else {
            formData.append('type', 'insert')
            formData.append('query', "INSERT INTO perlengkapan  VALUES('"+kode_perlengkapan+"','"+nama_perlengkapan+"',0)");
            console.log(kode_perlengkapan + '' + $('#nama_perlengkapan').val());
            //alert(kode_perlengkapan, nama_perlengkapan);
            $.ajax({
              url: "../controllers/barang_perlengkapan_Controller.php",
              data: formData,
              type: 'POST',
              contentType: false,
              processData: false,
              success: function(res) {
                //alert(res)
               const data = JSON.parse(res);

                if (data.status == 'error') {
                  Swal.fire({
                    icon: 'error',
                    title: 'gagal',
                    text: data.msg,
                  })
                } else {
                  Swal.fire({
                    icon: 'success',
                    title: 'berhasil',
                    text: data.msg,
                  }).then(function() {
                    window.location.replace("master_barang_perlengkapan.php? halaman<?= $halamanAktif ?>")
                  });
                }
              }
            });
          }
        });
      });


      //edit 
      <?php for ($i = 1; $i <= count($data); $i++) : ?>
        $('#edit-button-<?= $i ?>').on('click', function() {
          chenge("edit");
          console.log("button edit")
          reset();

          $('#title').html('Edit Data');
          $('#btn_tambah').html('Edit');

          $('#bgmodalinput').addClass("effectmodal");
          $('#modalkonten').toggleClass("scale-0");

          console.log("edit click");

          //load data
          $("#kode_perlengkapan").val('<?= $data[$i - 1]["kode_perlengkapan"] ?>');
          $("#kode_perlengkapan").attr('readonly', true);
          $("#nama_perlengkapan").val('<?= $data[$i - 1]["nama_perlengkapan"] ?>');

          $("#btn_edit").on("click", function() {
            console.log("edit");

            getData();

            let formData = new FormData();

            if (kode_perlengkapan == "") {
              Swal.fire({
                icon: 'error',
                title: 'gagal',
                text: "kode barang  tidak boleh kosong "
              })

            } else if (nama_perlengkapan == "") {
              swal.fire({
                icon: 'error',
                title: 'gagal',
                text: "nama barang tidak boleh kosong"
              })

            } else {
              formData.append('type', 'update');
              formData.append('query', "UPDATE perlengkapan SET kode_perlengkapan = '"+kode_perlengkapan+"', nama_perlengkapan= '"+nama_perlengkapan+"' WHERE kode_perlengkapan= '"+kode_perlengkapan+"' ");
              $.ajax({
                type: "post",
                url: "../controllers/barang_perlengkapan_Controller.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                  const data = JSON.parse(res);

                  if (data.status == 'error') {
                    Swal.fire({
                      icon: 'error',
                      title: 'gagal',
                      text: data.msg,
                    })
                  } else {
                    Swal.fire({
                      icon: 'sukses',
                      title: 'berhasil',
                      text: data.msg,
                    }).then(function() {
                      window.location.replace("master_barang_perlengkapan.php?halaman=<?= $halamanAktif ?>");
                    });
                  }
                }
              });
            }
          });
        });
      <?php endfor ?>



      $("#btn_out").on("click", function() {
        $('#bgmodalinput').removeClass("effectmodal");
        $('#modalkonten').toggleClass("scale-0");
        console.log('out');
      });

      $("#btn_batal").on("click", function() {
        $('#bgmodalinput').removeClass("effectmodal");
        $('#modalkonten').toggleClass("scale-0");
        console.log('batal')
      });

    });

    // tab focus
    // $('#tab_catalog').on("click", function() {
    //   $('#bgtab').removeClass("translate-x-0");
    //   $('#bgtab').addClass("translate-x-[83px]");
    //   $('#tab_catalog').addClass("tab-focus");
    //   $('#tab_table').removeClass("tab-focus");
    //   $('#table').addClass("hidden");
    //   $('#catalog').removeClass("hidden");
    // });

    // $('#tab_table').on("click", function() {
    //   $('#bgtab').removeClass("translate-x-[83px]");
    //   $('#bgtab').addClass("translate-x-0");
    //   $('#tab_catalog').removeClass("tab-focus");
    //   $('#tab_table').addClass("tab-focus");
    //   $('#table').removeClass("hidden");
    //   $('#catalog').addClass("hidden");
    // });

    $('#click-modal').on('click', function() {
      console.log("modal muncul");
      $('#modal').removeClass("scale-0");
      $('#bgmodal').addClass("effectmodal");
    });

    //delete modal 
    $("#modal-delete").load("../assets/components/modal_hapus.html", function() {
      console.log("modal hapus")
      //delete
      <?php for ($i = 1; $i <= count($data); $i++) : ?>
        $('#delete-button-<?= $i ?>').on('click', function() {
          console.log("button hapus")
          var id = '<?= $data[$i - 1]["kode_perlengkapan"] ?>';
          //var nama = '<?= $data[$i - 1]["nama_perlengkapan"] ?>';

          $('#title_delete').html('hapus data product ini ?');

          $('#modalkontenhapus').toggleClass("scale-100");
          $('#bgmodalhapus').addClass("effectmodal");

          $('#submithapus').on('click', function() {
            console.log("button submit")
            $.ajax({
              type: "post",
              url: "../controllers/barang_perlengkapan_Controller.php",
              data: {
                type: "delete",
                query: "DELETE FROM perlengkapan WHERE kode_perlengkapan = '" + id + "'",
                // name = nama,
              },
              cache: false,
              success: function(res) {
                const data = JSON.parse(res);

                if (data.status == 'sukses') {
                  swal.fire({
                    icon: 'success',
                    title: 'berhasil',
                    text: data.msg,
                  }).then(function() {
                    window.location.replace("master_barang_perlengkapan.php");
                  });
                } else {

                }
              }
            });
          });
          $('#closemodalhapus').on('click', function() {
            console.log("cancel_menghapus")
            $('#modalkontenhapus').removeClass("scale-100");
            $('#bgmodalhapus').removeClass("effectmodal");
          });

          $('#cancelmodalhapus').on('click', function() {
            console.log("batal_menghapus")
            $('#modalkontenhapus').removeClass("scale-100");
            $('#bgmodalhapus').removeClass("effectmodal");
          });
        });
      <?php endfor ?>
    });

    //searc
    $('#search').keypress(function(e) {
      if (e.which == 13) {
        window.location.replace("master_barang_perlengkapan.php?search=" + $('#search').val());
      }
    });

  </script>
</body>

</html>
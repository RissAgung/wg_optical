<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require "../config/koneksi.php";

$crud = new koneksi();
$profileDB = $crud->showData("SELECT foto_pegawai FROM pegawai WHERE id_pegawai = '" . $_SESSION['id_pegawai'] . "'");
$imgProfile = "";
foreach ($profileDB as $index) {
  $imgProfile = $index["foto_pegawai"];
}

// pagination
$jumlahDataPerHalaman = 6;
$jumlahData = (isset($_GET["search"])) ? count($crud->showData("SELECT * FROM tambahan WHERE kode_barang LIKE'%" . $_GET["search"] . "%' LIMIT 0, $jumlahDataPerHalaman")) : count($crud->showData("SELECT * FROM tambahan"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$data = (isset($_GET["search"])) ? $crud->showData("SELECT * FROM tambahan WHERE kode_barang LIKE'%" . $_GET["search"] . "%' LIMIT $awalData, $jumlahDataPerHalaman") : $crud->showData("SELECT * FROM tambahan LIMIT $awalData, $jumlahDataPerHalaman");


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <link rel="stylesheet" href="../css/sweetalert2.min.css">
  <title>Master_Product_Tambahan</title>
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">

  <div id="loading" class="fixed w-full h-full top-0 left-0 flex flex-col justify-center items-center bg-slate-50 z-[99]">
    <div class="loadingspinner"></div>
  </div>

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

    <div class="w-full rounded-md py-0 px-4 md:px-8">

      <!-- Tab Bar -->
      <!-- <div class="w-44 box-border p-1.5 shadow-sm rounded-md flex justify-between flex-row text-sm font-ex-semibold bg-white">
        <div class="transition bg-[#343948] h-8 w-[80px] absolute rounded-md translate-x-0 ease-in-out" id="bgtab">
        </div>
        <div class="flex justify-center py-1.5 w-20 rounded-md tab-focus cursor-pointer" id="tab_table">Table</div>
        <div class="flex justify-center py-1.5 w-20 rounded-md cursor-pointer" id="tab_catalog">Catalog</div>
      </div> -->

      <!-- Search and Button Add -->

        <div class="flex items-center content-center flex-wrap justify-between max-[450px]:justify-center mt-4 gap-2">
          <!-- Search -->
          <div class="flex flex-row shadow-sm rounded-md items-center justify-around bg-white w-72 box-border">
            <div class="flex flex-row items-center">
              <svg width="19" height="19" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-3">
                <path d="M19.2502 19.25L15.138 15.1305M17.4168 9.62501C17.4168 11.6915 16.5959 13.6733 15.1347 15.1346C13.6735 16.5958 11.6916 17.4167 9.62516 17.4167C7.55868 17.4167 5.57684 16.5958 4.11562 15.1346C2.6544 13.6733 1.8335 11.6915 1.8335 9.62501C1.8335 7.55853 2.6544 5.57669 4.11562 4.11547C5.57684 2.65425 7.55868 1.83334 9.62516 1.83334C11.6916 1.83334 13.6735 2.65425 15.1347 4.11547C16.5959 5.57669 17.4168 7.55853 17.4168 9.62501V9.62501Z" stroke="#797E8D" stroke-width="2" stroke-linecap="round" />
              </svg>
              <?php $input = (isset($_GET["search"])) ? $_GET["search"] : null ?>
              <input id="search" value="<?= $input ?>" type="text" placeholder="Type here" class="h-11 bg-transparent ml-2 outline-none" />
            </div>
            <div onclick="search_reset()" class="cursor-pointer justify-center items-center pr-2">
              <?php if (isset($_GET["search"])) : ?>
                <svg class="cursor-pointer fill-[#535A6D]" width="10" height="10" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7.3289 5.47926L10.6264 2.18142C10.8405 1.93831 10.9539 1.62288 10.9436 1.29924C10.9332 0.975599 10.7999 0.668037 10.5707 0.439072C10.3415 0.210106 10.0337 0.0769213 9.70976 0.0665883C9.38581 0.0562553 9.07009 0.16955 8.82676 0.383443L5.52586 3.67789L2.21901 0.373252C2.10056 0.254916 1.95995 0.161048 1.80519 0.097005C1.65044 0.0329623 1.48457 1.24687e-09 1.31706 0C1.14956 -1.24687e-09 0.983689 0.0329623 0.828933 0.097005C0.674177 0.161048 0.533562 0.254916 0.415117 0.373252C0.296672 0.491587 0.202716 0.632072 0.138614 0.786685C0.0745119 0.941298 0.041519 1.10701 0.041519 1.27436C0.041519 1.44171 0.0745119 1.60743 0.138614 1.76204C0.202716 1.91665 0.296672 2.05714 0.415117 2.17547L3.72282 5.47926L0.425318 8.77625C0.295996 8.89175 0.19162 9.03239 0.118574 9.18957C0.0455293 9.34676 0.00535166 9.51718 0.000499102 9.69041C-0.00435345 9.86364 0.0262212 10.036 0.0903528 10.1971C0.154484 10.3581 0.250824 10.5043 0.373478 10.6269C0.496133 10.7494 0.642522 10.8457 0.80369 10.9097C0.964858 10.9738 1.13742 11.0043 1.31081 10.9995C1.4842 10.9947 1.65478 10.9545 1.81211 10.8815C1.96944 10.8086 2.11021 10.7043 2.22581 10.5751L5.52586 7.28063L8.82251 10.5751C9.06172 10.8141 9.38616 10.9483 9.72446 10.9483C10.0628 10.9483 10.3872 10.8141 10.6264 10.5751C10.8656 10.3361 11 10.0119 11 9.67396C11 9.33598 10.8656 9.01184 10.6264 8.77286L7.3289 5.47926Z" fill="#535A6D" />
                </svg>
              <?php endif ?>
            </div>
          </div>
          <!-- Button Add -->
          <div class="flex flex-col md:flex-row items-center">
            <div class="h-10 w-24 font-ex-semibold text-white" id="click-modal">
              <button class="bg-[#3DBD9E] h-full w-full rounded-md">Tambah</button>
            </div>
          </div>
          <!-- End Button Add -->
          <!-- End Search and Button Add -->
        </div>


        <!-- konten table -->
        <div class="" id="table">
          <!--table-->
          <div class="overflow-x-auto  text-sm bg-white rounded-md mt-4 py-6 px-6 ex-table">
            <table class="w-full">
              <thead class="border-b-2 border-gray-100">
                <tr>
                  <th class="p-3 text-sm tracking-wide text-center">No</th>
                  <th class="p-3 text-sm tracking-wide text-center">Kode Barang</th>
                  <th class="p-3 text-sm tracking-wide text-center">Nama Barang</th>
                  <th class="p-3 text-sm tracking-wide text-center">Stock</th>
                  <!-- <th class="p-3 text-sm tracking-wide text-center">unknow</th> -->
                  <th class="p-3 text-sm tracking-wide text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $nomer = ($jumlahDataPerHalaman * $halamanAktif) - ($jumlahDataPerHalaman - 1) ?>
                <?php $i = 1 ?>
                <?php foreach ($data as $index) : ?>
                  <tr>
                    <td class="p-3 text-sm tracking-wide text-center"><?= $nomer ?></td>
                    <td class="p-3 text-sm tracking-wide text-center"><?= $index["kode_barang"] ?></td>
                    <td class="p-3 text-sm tracking-wide text-center"><?= $index["nama_barang"] ?></td>
                    <td class="p-3 text-sm tracking-wide text-center"><?= $index["stock"] ?></td>
                    <!-- <td></td> -->
                    <td class="p-3 text-sm tracking-wide text-center">
                      <button id="edit-button-<?= $i; ?>">
                        <svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <rect width="37" height="37" rx="5" fill="#EDC683" />
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M27.4782 8.38256C27.7335 8.48841 27.9655 8.64355 28.1609 8.83911C28.3564 9.03447 28.5116 9.26646 28.6174 9.52181C28.7233 9.77717 28.7777 10.0509 28.7777 10.3273C28.7777 10.6037 28.7233 10.8774 28.6174 11.1328C28.5116 11.3881 28.3564 11.6201 28.1609 11.8155L25.3473 14.6282L22.3717 11.6526L25.1845 8.83911C25.3798 8.64355 25.6118 8.48841 25.8672 8.38256C26.1225 8.27671 26.3962 8.22223 26.6727 8.22223C26.9491 8.22223 27.2228 8.27671 27.4782 8.38256ZM9.59277 25.7604C9.59295 24.9094 9.93117 24.0933 10.533 23.4916L21.2376 12.787L24.2132 15.7626L13.5086 26.4672C12.9069 27.069 12.0908 27.4072 11.2398 27.4074H9.59277V25.7604Z" fill="#3F2C0D" />
                        </svg>
                      </button>
                      <button onclick="delete_data('<?= $index['kode_barang'] ?>')">
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
          <div class="py-2 px-0">
            <div class="flex flex-col md:flex-row justify-between  items-center mt-3 text-sm">
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
      </div>
    <!-- End Search -->


  </div>

  <script src="../js/jquery-3.6.1.min.js"></script>
  <script src="../js/sweetalert2.min.js"></script>
  <script src="../js/jquery.iddle.min.js"></script>
  <script>
    // top_bar
    $('#top_bar').load("../assets/components/top_bar.php", function() {
      $("#avatar_profile").attr("src", "../images/pegawai/foto_pegawai/<?= $imgProfile ?>");
      $('#title-header').html('Master Data Tambahan');
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
    $("#ex-sidebar").load("../assets/components/sidebar.php", function() {
      $('#master_data').addClass("hover-sidebar");
      $('#loading').hide();
    });

    // reset 
    var input = '<?= $input ?>';
    if (input !== "") {
      $('#btn_reset').removeClass('hidden');
      $('#btn_reset').addClass('flex');
      $('#btn_reset').on('click', function() {
        window.location.replace("master_product_tambahan.php");
      })
    }

    function getFileExtension(fstring) {
      return fstring.slice((Math.max(0, fstring.lastIndexOf(".")) || Infinity) + 1);
    }


    // load modal input
    $("#modal").load("../assets/components/modal_tambah_master_product_tambahan.html", function() {
      //tambah
      $('#click-modal').on('click', function() {
        chenge("tambah");
        reset();

        $('#bgmodalinput').addClass("effectmodal");
        $('#modalkonten').toggleClass("scale-0");

        //chenge("tambah");


        $('#title').html('Tambah Data');
        $('#btn_tambah').html('Tambah');
        $("#btn_tambah").on("click", function(e) {
          console.log("tambah click");

          e.preventDefault();
          getData();

          let formData = new FormData();
          //let query;

          if (kodebarang == "") {
            swal.fire({
              icon: 'error',
              title: 'gagal',
              text: "kode barang tidak boleh kosong ",
            })
          } else if (namabarang == "") {
            swal.fire({
              icon: 'error',
              title: 'gagal',
              text: "nama barang tidak boleh kosong",
            })

          } else {
            formData.append('type', 'insert')
            formData.append('query', "INSERT INTO tambahan VALUES('" + kodebarang + "','" + namabarang + "',0)");

            $.ajax({
              url: "../controllers/product_tambahan_Controller.php",
              data: formData,
              type: 'POST',
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
                //alert(res)
                const data = JSON.parse(res);

                if (data.status == 'error') {
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
                    window.location.replace("master_product_tambahan.php? halaman<?= $halamanAktif ?>")
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
          reset();

          $('#title').html('Edit Data');
          $('#btn_tambah').html('Edit');

          $('#bgmodalinput').addClass("effectmodal");
          $('#modalkonten').toggleClass("scale-0");

          console.log("edit click");
          //load data
          $("#kode_barang").val('<?= $data[$i - 1]["kode_barang"] ?>');
          $("#kode_barang").attr('readonly', true);
          $("#nama_barang").val('<?= $data[$i - 1]["nama_barang"] ?>');

          $("#btn_edit").on("click", function() {
            console.log("edit");

            getData();

            let formData = new FormData();

            if (kodebarang == "") {
              Swal.fire({
                icon: 'error',
                title: 'gagal',
                text: "kode barang  tidak boleh kosong "
              })

            } else if (namabarang == "") {
              swal.fire({
                icon: 'error',
                title: 'gagal',
                text: "nama barang tidak boleh kosong"
              })

            } else {
              formData.append('type', 'update');
              formData.append('query', "UPDATE tambahan SET kode_barang = '" + kodebarang + "', nama_barang= '" + namabarang + "' WHERE kode_barang= '" + kodebarang + "' ");
              $.ajax({
                type: "post",
                url: "../controllers/product_tambahan_Controller.php",
                data: formData,
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

                  if (data.status == 'error') {
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
                      window.location.replace("master_product_tambahan.php?halaman=<?= $halamanAktif ?>");
                    });
                  }
                }
              });
            }
          });
        });
      <?php endfor ?>


      var kodebarang;
      var namabarang;

      function getData() {
        kodebarang = $("#kode_barang").val();
        namabarang = $("#nama_barang").val();
      }
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
    $('#tab_catalog').on("click", function() {
      $('#bgtab').removeClass("translate-x-0");
      $('#bgtab').addClass("translate-x-[83px]");
      $('#tab_catalog').addClass("tab-focus");
      $('#tab_table').removeClass("tab-focus");
      $('#table').addClass("hidden");
      $('#catalog').removeClass("hidden");
    });

    $('#tab_table').on("click", function() {
      $('#bgtab').removeClass("translate-x-[83px]");
      $('#bgtab').addClass("translate-x-0");
      $('#tab_catalog').removeClass("tab-focus");
      $('#tab_table').addClass("tab-focus");
      $('#table').removeClass("hidden");
      $('#catalog').addClass("hidden");
    });

    $('#click-modal').on('click', function() {
      console.log("modal muncul");
      $('#modal').removeClass("scale-0");
      $('#bgmodal').addClass("effectmodal");
    });


    function delete_data(id) {
      Swal.fire({
        icon: 'question',
        title: 'Apakah anda yakin?',
        showDenyButton: true,
        confirmButtonText: 'Ya',
        denyButtonText: `Batal`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          $.ajax({
            type: "post",
            url: "../controllers/product_tambahan_Controller.php",
            data: {
              type: "delete",
              query: "DELETE FROM tambahan WHERE kode_barang = '" + id + "'",
              // name = nama,
            },
            cache: false,
            beforeSend: function() {
              Swal.fire({
                title: 'Loading',
                html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
                allowOutsideClick: false,
                showConfirmButton: false,
              });
            },
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

              if (data.status == 'sukses') {
                swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: data.msg,
                }).then(function() {
                  window.location.replace("master_product_tambahan.php");
                });
              } else {

              }
            }
          });

        } else if (result.isDenied) {

        }
      })
    }
    //searc
    $('#search').keypress(function(e) {
      if (e.which == 13) {
        window.location.replace("master_product_tambahan.php?search=" + $('#search').val());
      }
    });

    function search_reset() {
      window.location.replace("master_product_tambahan.php?");
    }
  </script>

</body>

</html>
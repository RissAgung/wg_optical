<?php
require "../config/koneksi.php";

$crud = new koneksi();

// pagination
$jumlahDataPerHalaman = 6;
$jumlahData = (isset($_GET["search"])) ? count($crud->showData("SELECT * FROM produk WHERE kode_frame LIKE'%" . $_GET["search"] . "%' LIMIT 0, $jumlahDataPerHalaman")) : count($crud->showData("SELECT * FROM produk"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$data = (isset($_GET["search"])) ? $crud->showData("SELECT * FROM produk WHERE kode_frame LIKE'%" . $_GET["search"] . "%' LIMIT $awalData, $jumlahDataPerHalaman") : $crud->showData("SELECT * FROM produk LIMIT $awalData, $jumlahDataPerHalaman");

// $data = $crud->showData("SELECT * FROM produk LIMIT $awalData, $jumlahDataPerHalaman");

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
  <title>Master Data | WG Optical</title>
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">


  <!-- Logout modal -->
  <div id="bgmodal" class="w-full h-screen fixed hidden bg-black z-[51] opacity-0 transition duration-300"></div>
  <div id="modalLogout" class="w-[90%] md:w-[60%] lg:w-[30%] bg-white fixed z-[51] left-[50%] top-[50%] -translate-y-[50%] -translate-x-[50%] shadow-xl rounded-lg scale-0  transition ease-in-out">
    <div class="flex flex-row justify-between px-8 pt-[20px]">
      <h1 class="font-bold text-xl md:text-2xl">Keluar</h1>
      <h1>X</h1>
    </div>
    <div class="px-8 pt-[20px]">

      <p class="text-sm md:text-lg text-slate-600">Apakah anda yakin ingin keluar?</p>
    </div>

    <div class="flex flex-row justify-end px-8 gap-2 pt-8 pb-8">

      <div class="bg-[#3DBD9E] w-[70px] md:w-[80px] text-center rounded-md py-1 text-white text-sm sm:text-lg">
        <p>Cancel</p>
      </div>
      <div class="bg-[#F35E58] w-[70px] md:w-[80px] text-center rounded-md py-1 text-white text-sm sm:text-lg">
        <p>Oke</p>
      </div>

    </div>
  </div>
  <!-- end modal logout -->

  <!-- modal -->
  <div id="modal">

  </div>
  <!-- end modal -->

  <!-- modal delete -->
  <div id="modal-delete" class=""></div>
  <!-- modal delete -->

  <!-- Background hitam saat sidebar show -->
  <div id="bgbody" class="w-full h-screen bg-black fixed z-[51] bg-opacity-50 hidden"></div>
  <!-- End Background hitam saat sidebar show -->

  <!-- sidebar -->
  <div id="ex-sidebar" class="ex-sidebar ex-hide-sidebar fixed z-50 max-lg:transition max-lg:duration-[1s]"></div>
  <!-- end sidebar -->



  <div class="lg:ml-72">
    <!-- top bar -->
    <div id="top_bar">

    </div>

    <div class="mt-3 flex items-center flex-col md:flex-row md:justify-around lg:justify-between lg:px-16 md:py-[3px]">

      <!-- Tab Bar -->
      <div class="w-44 box-border p-1.5 shadow-sm rounded-md flex justify-between flex-row text-sm font-ex-semibold bg-white">
        <div class="transition bg-[#343948] h-8 w-[80px] absolute rounded-md translate-x-0 ease-in-out" id="bgtab">
        </div>
        <div class="flex justify-center py-1.5 w-20 rounded-md tab-focus cursor-pointer" id="tab_table">Table</div>
        <div class="flex justify-center py-1.5 w-20 rounded-md cursor-pointer" id="tab_catalog">Catalog</div>
      </div>

      <!-- Search and Button Add -->
      <div class="flex flex-col md:flex-row items-center mt-3 md:mt-0">

        <!-- Search -->
        <div class="flex flex-row shadow-sm rounded-md items-center justify-around bg-white w-72 box-border px-2 md:mr-6">
          <div class=" flex flex-row items-center">
            <svg width="19" height="19" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-3">
              <path d="M19.2502 19.25L15.138 15.1305M17.4168 9.62501C17.4168 11.6915 16.5959 13.6733 15.1347 15.1346C13.6735 16.5958 11.6916 17.4167 9.62516 17.4167C7.55868 17.4167 5.57684 16.5958 4.11562 15.1346C2.6544 13.6733 1.8335 11.6915 1.8335 9.62501C1.8335 7.55853 2.6544 5.57669 4.11562 4.11547C5.57684 2.65425 7.55868 1.83334 9.62516 1.83334C11.6916 1.83334 13.6735 2.65425 15.1347 4.11547C16.5959 5.57669 17.4168 7.55853 17.4168 9.62501V9.62501Z" stroke="#797E8D" stroke-width="2" stroke-linecap="round" />
            </svg>
            <?php $input = (isset($_GET["search"])) ? $_GET["search"] : null ?>
            <input id="search" value="<?= $input ?>" type="text" placeholder="Type here" class="h-11 bg-transparent ml-2 outline-none" />
          </div>
          <div id="btn_reset" class="cursor-pointer hidden justify-center items-center">
            <svg class="cursor-pointer fill-[#535A6D]" width="10" height="10" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7.3289 5.47926L10.6264 2.18142C10.8405 1.93831 10.9539 1.62288 10.9436 1.29924C10.9332 0.975599 10.7999 0.668037 10.5707 0.439072C10.3415 0.210106 10.0337 0.0769213 9.70976 0.0665883C9.38581 0.0562553 9.07009 0.16955 8.82676 0.383443L5.52586 3.67789L2.21901 0.373252C2.10056 0.254916 1.95995 0.161048 1.80519 0.097005C1.65044 0.0329623 1.48457 1.24687e-09 1.31706 0C1.14956 -1.24687e-09 0.983689 0.0329623 0.828933 0.097005C0.674177 0.161048 0.533562 0.254916 0.415117 0.373252C0.296672 0.491587 0.202716 0.632072 0.138614 0.786685C0.0745119 0.941298 0.041519 1.10701 0.041519 1.27436C0.041519 1.44171 0.0745119 1.60743 0.138614 1.76204C0.202716 1.91665 0.296672 2.05714 0.415117 2.17547L3.72282 5.47926L0.425318 8.77625C0.295996 8.89175 0.19162 9.03239 0.118574 9.18957C0.0455293 9.34676 0.00535166 9.51718 0.000499102 9.69041C-0.00435345 9.86364 0.0262212 10.036 0.0903528 10.1971C0.154484 10.3581 0.250824 10.5043 0.373478 10.6269C0.496133 10.7494 0.642522 10.8457 0.80369 10.9097C0.964858 10.9738 1.13742 11.0043 1.31081 10.9995C1.4842 10.9947 1.65478 10.9545 1.81211 10.8815C1.96944 10.8086 2.11021 10.7043 2.22581 10.5751L5.52586 7.28063L8.82251 10.5751C9.06172 10.8141 9.38616 10.9483 9.72446 10.9483C10.0628 10.9483 10.3872 10.8141 10.6264 10.5751C10.8656 10.3361 11 10.0119 11 9.67396C11 9.33598 10.8656 9.01184 10.6264 8.77286L7.3289 5.47926Z" fill="#535A6D" />
            </svg>
          </div>

        </div>
        <!-- End Search -->

        <!-- Button Add -->
        <div class="md:my-auto h-10 w-24 font-ex-semibold text-white mt-3 md:mt-0" id="click-modal">
          <button class="bg-[#3DBD9E] h-full w-full rounded-md">Tambah</button>
        </div>
        <!-- End Button Add -->

      </div>
      <!-- End Search and Button Add -->

    </div>

    <!-- konten table -->
    <div class="" id="table">
      <!-- Table -->
      <div class="overflow-x-auto  text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 ex-table">
        <table class="w-full">
          <thead class="border-b-2 border-gray-100">
            <tr>
              <th class="p-3 text-sm tracking-wide text-center">No</th>
              <th class="p-3 text-sm tracking-wide text-center">Kode Frame</th>
              <th class="p-3 text-sm tracking-wide text-center">Merk</th>
              <th class="p-3 text-sm tracking-wide text-center">Warna</th>
              <th class="p-3 text-sm tracking-wide text-center">Harga Jual</th>
              <th class="p-3 text-sm tracking-wide text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $nomor = ($jumlahDataPerHalaman * $halamanAktif) - ($jumlahDataPerHalaman - 1) ?>
            <?php $i = 1 ?>
            <?php foreach ($data as $index) : ?>
              <tr>
                <td class="p-3 text-sm tracking-wide text-center"><?= $nomor ?></td>
                <td class="p-3 text-sm tracking-wide text-center"><?= $index["kode_frame"] ?></td>
                <td class="p-3 text-sm tracking-wide text-center"><?= $index["merk"] ?></td>
                <td class="p-3 text-sm tracking-wide text-center"><?= $index["warna"] ?></td>
                <td class="p-3 text-sm tracking-wide text-center"><?= rupiah($index["harga_jual"]) ?></td>
                <td class="p-3 text-sm tracking-wide text-center">
                  <button id="edit-button-<?= $i; ?>">
                    <svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect width="37" height="37" rx="5" fill="#EDC683" />
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M27.4782 8.38256C27.7335 8.48841 27.9655 8.64355 28.1609 8.83911C28.3564 9.03447 28.5116 9.26646 28.6174 9.52181C28.7233 9.77717 28.7777 10.0509 28.7777 10.3273C28.7777 10.6037 28.7233 10.8774 28.6174 11.1328C28.5116 11.3881 28.3564 11.6201 28.1609 11.8155L25.3473 14.6282L22.3717 11.6526L25.1845 8.83911C25.3798 8.64355 25.6118 8.48841 25.8672 8.38256C26.1225 8.27671 26.3962 8.22223 26.6727 8.22223C26.9491 8.22223 27.2228 8.27671 27.4782 8.38256ZM9.59277 25.7604C9.59295 24.9094 9.93117 24.0933 10.533 23.4916L21.2376 12.787L24.2132 15.7626L13.5086 26.4672C12.9069 27.069 12.0908 27.4072 11.2398 27.4074H9.59277V25.7604Z" fill="#3F2C0D" />
                    </svg>
                  </button>
                  <button id="delete-button-<?= $i; ?>">
                    <svg width="38" height="37" viewBox="0 0 38 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect x="0.444336" width="37" height="37" rx="5" fill="#F35E58" />
                      <path d="M23.3982 10.5062V8.67903C23.3982 8.19444 23.2105 7.72969 22.8764 7.38703C22.5423 7.04437 22.0892 6.85187 21.6167 6.85187H16.2723C15.7998 6.85187 15.3467 7.04437 15.0126 7.38703C14.6785 7.72969 14.4908 8.19444 14.4908 8.67903V10.5062H10.0371V12.3333H11.8186V26.0371C11.8186 26.7639 12.1001 27.4611 12.6013 27.975C13.1024 28.489 13.7821 28.7778 14.4908 28.7778H23.3982C24.1069 28.7778 24.7866 28.489 25.2878 27.975C25.7889 27.4611 26.0704 26.7639 26.0704 26.0371V12.3333H27.8519V10.5062H23.3982ZM18.0538 22.3827H16.2723V16.9012H18.0538V22.3827ZM21.6167 22.3827H19.8353V16.9012H21.6167V22.3827ZM21.6167 10.5062H16.2723V8.67903H21.6167V10.5062Z" fill="#501614" />
                    </svg>

                  </button>
                </td>
              </tr>
              <?php $nomor++ ?>
              <?php $i++ ?>
            <?php endforeach ?>
          </tbody>

        </table>
      </div>
      <!-- End Table -->

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
    <!-- end konten table -->

    <!-- konten catalog -->
    <div class="hidden" id="catalog">
      <div class="container-catalog flex flex-row flex-wrap overflow-y-scroll scrollbar-hide text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 ex-catalog pl-6 pr-[8px] pt-[8pxb ] justify-between max-[391px]:justify-center">

        <?php $idx = 1 ?>
        <?php foreach ($data as $index) : ?>
          <!-- items -->
          <div class="max-[400px]:w-[163px] max-md:w-[149px] w-[163px] h-[273px]  shadow-md relative rounded-2xl overflow-hidden mt-4 mr-4">
            <div class="max-[400px]:w-[163px] max-md:w-[149px] max-[400px]:h-[163px] max-md:h-[149px] h-[163px] w-[163px] bg-red-100 rounded-2xl overflow-hidden">
              <img class="max-[400px]:w-[163px] max-md:w-[149px] max-[400px]:h-[163px] max-md:h-[149px] h-[163px] w-[163px] object-cover" src="../images/produk/<?= $index["gambar"] ?>" alt="product image">
            </div>
            <div class="flex flex-col w-full h-full p-[13px]">
              <h3 class="uppercase text-[11px]"><?= $index["kode_frame"] ?></h3>
              <h2 class="font-ex-semibold text-[14px]"><?= rupiah($index["harga_jual"]) ?></h2>
              <hr class="mt-3">
              <div class="flex flex-row justify-between py-2 items-center">
                <p class="text-[10px]">Stock : <?= $index["stock"] ?></p>
                <div class="flex flex-row">
                  <div id="edit-button-catalog-<?= $idx ?>" class="cursor-pointer flex items-center justify-center w-[29px] h-[29px] bg-[#EDC683] rounded-md mr-[11px]">
                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M13.3722 0.80805C13.5491 0.88139 13.7098 0.988883 13.8452 1.12438C13.9807 1.25974 14.0882 1.42048 14.1615 1.59741C14.2349 1.77434 14.2726 1.96399 14.2726 2.15552C14.2726 2.34704 14.2349 2.53669 14.1615 2.71362C14.0882 2.89055 13.9807 3.05129 13.8452 3.18665L11.8958 5.13551L9.83406 3.07381L11.7829 1.12438C11.9183 0.988883 12.079 0.88139 12.256 0.80805C12.4329 0.73471 12.6225 0.69696 12.8141 0.69696C13.0056 0.69696 13.1952 0.73471 13.3722 0.80805ZM0.979492 12.8487C0.979618 12.2591 1.21396 11.6936 1.63097 11.2767L9.04789 3.8598L11.1096 5.92151L3.69267 13.3384C3.27579 13.7554 2.71034 13.9898 2.12069 13.9899H0.979492V12.8487Z" fill="#3F2C0D" />
                    </svg>
                  </div>
                  <div id="delete-button-catalog-<?= $idx ?>" class="cursor-pointer flex items-center justify-center w-[29px] h-[29px] bg-[#F35E58] rounded-md">
                    <svg width="13" height="16" viewBox="0 0 13 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M9.26735 3.27949V2.01349C9.26735 1.67773 9.1373 1.35572 8.90582 1.1183C8.67434 0.880879 8.36037 0.747498 8.03301 0.747498H4.32997C4.0026 0.747498 3.68864 0.880879 3.45716 1.1183C3.22567 1.35572 3.09563 1.67773 3.09563 2.01349V3.27949H0.00976562V4.54548H1.24411V14.0404C1.24411 14.5441 1.43918 15.0271 1.78641 15.3832C2.13363 15.7394 2.60457 15.9394 3.09563 15.9394H9.26735C9.7584 15.9394 10.2293 15.7394 10.5766 15.3832C10.9238 15.0271 11.1189 14.5441 11.1189 14.0404V4.54548H12.3532V3.27949H9.26735ZM5.56432 11.5085H4.32997V7.71047H5.56432V11.5085ZM8.03301 11.5085H6.79866V7.71047H8.03301V11.5085ZM8.03301 3.27949H4.32997V2.01349H8.03301V3.27949Z" fill="#501614" />
                    </svg>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- items -->
          <?php $idx++ ?>
        <?php endforeach ?>

      </div>

    </div>
  </div>
  </div>
  <!-- konten catalog -->


  <script src="../js/jquery-3.6.1.min.js"></script>
  <script src="../js/sweetalert2.min.js"></script>
  <script>
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
        window.location.replace("master_product.php");
      })
    }

    function getFileExtension(fstring) {
      return fstring.slice((Math.max(0, fstring.lastIndexOf(".")) || Infinity) + 1);
    }

    // load modal input
    $("#modal").load("../assets/components/modal_tambah_master_product.html", function() {

      // tambah
      $('#click-modal').on('click', function() {

        $('#bgmodalinput').addClass("effectmodal");
        $('#modalkonten').removeClass("scale-0");

        chenge("tambah");

        reset();


        console.log("tambah click");

        imgInp.onchange = evt => {
          const [file] = imgInp.files
          if (file) {
            imgpreview_peg.src = URL.createObjectURL(file);
            $('#imgpreview_peg').removeClass("hidden");
            $('#imgdefault_peg').addClass("hidden");
          }
        }

        $('#title').html('Tambah Data');
        $('#btn_tambah').html('Tambah');
        $("#btn_tambah").on("click", function(e) {

          e.preventDefault();

          getData();

          let formData = new FormData();
          let imgProduk = $('#imgInp')[0].files;
          let query;

          if (kode_frame == "") {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: "Kode Frame Tidak Boleh Kosong",
            })
          } else if (kode_frame.length < 5) {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: "Kode Frame Tidak Boleh Kurang Dari 5 Karakter",
            })
          } else if (merk == "") {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: "Merk Tidak Boleh Kosong",
            })
          } else if (warna == "") {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: "Warna Tidak Boleh Kosong",
            })
          } else if ($("#harga_txt").val() == "") {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: "Harga Tidak Boleh Kosong",
            })
          } else if (!imgProduk.length > 0) {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: 'Masukkan Gambar Terlebih Dahulu',
            })
          } else {

            query = "gambar product ada";

            formData.append('image_produk', imgProduk[0]);
            formData.append('type', "insert");

            var img_name_produk = formData.get('image_produk')['name'];
            var generateUniqProduk = "<?php echo uniqid('produk-lensa-', true) . '.' . '"+getFileExtension(img_name_produk).toLowerCase()+"' ?>";

            // cek bagian toLowercase jika error (tmp)

            formData.append('img_file_produk', generateUniqProduk);
            formData.append('query', "INSERT INTO produk VALUES ('" + kode_frame + "','" + merk + "','" + warna + "','0','" + generateUniqProduk + "','" + harga + "')");

            $.ajax({
              type: "post",
              url: "../controllers/productController.php",
              data: formData,
              contentType: false,
              processData: false,
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
                    window.location.replace("master_product.php?halaman=<?= $halamanAktif ?>");
                  });
                }
              }
            });
          }
        });
      });

      // edit
      <?php for ($i = 1; $i <= count($data); $i++) : ?>
        $('#edit-button-<?= $i ?>').on('click', function() {

          chenge("edit");

          reset();

          $('#title').html('Edit Data');
          $('#btn_tambah').html('Edit');

          $('#bgmodalinput').addClass("effectmodal");
          $('#modalkonten').removeClass("scale-0");

          console.log("edit click");

          imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
              imgpreview_peg.src = URL.createObjectURL(file);
              $('#imgpreview_peg').removeClass("hidden");
              $('#imgdefault_peg').addClass("hidden");
            }
          }


          // load data
          $("#kode_txt").val('<?= $data[$i - 1]["kode_frame"] ?>');
          $("#kode_txt").attr('readonly', true);
          $("#merk_txt").val('<?= $data[$i - 1]["merk"] ?>');
          $("#warna_txt").val('<?= $data[$i - 1]["warna"] ?>');
          $("#harga_txt").val('<?= rupiah($data[$i - 1]["harga_jual"]) ?>');

          imgpreview_peg.src = "../images/produk/<?= $data[$i - 1]["gambar"] ?>";
          $('#imgpreview_peg').removeClass("hidden");
          $('#imgdefault_peg').addClass("hidden");

          $("#btn_edit").on("click", function(e) {

            e.preventDefault();

            getData();

            let formData = new FormData();
            let imgProduk = $('#imgInp')[0].files;

            if (!imgProduk.length > 0) {
              console.log("tanpa gambar");
              // gambar tidak ada atau kosong

              if (kode_frame == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Kode Frame Tidak Boleh Kosong",
                })
              } else if (kode_frame.length < 5) {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Kode Frame Tidak Boleh Kurang Dari 5 Karakter",
                })
              } else if (merk == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Merk Tidak Boleh Kosong",
                })
              } else if (warna == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Warna Tidak Boleh Kosong",
                })
              } else if ($("#harga_txt").val() == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Harga Tidak Boleh Kosong",
                })
              } else {
                formData.append('type', "update");
                formData.append('query', "UPDATE produk SET merk='" + merk + "', warna='" + warna + "', harga_jual='" + harga + "' WHERE kode_frame = '" + kode_frame + "'");

                $.ajax({
                  type: "post",
                  url: "../controllers/productController.php",
                  data: formData,
                  contentType: false,
                  processData: false,
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
                        window.location.replace("master_product.php?halaman=<?= $halamanAktif ?>");
                      });
                    }
                  }
                });
              }
            } else {
              console.log("dengan gambar");

              if (kode_frame == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Kode Frame Tidak Boleh Kosong",
                })
              } else if (kode_frame.length < 5) {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Kode Frame Tidak Boleh Kurang Dari 5 Karakter",
                })
              } else if (merk == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Merk Tidak Boleh Kosong",
                })
              } else if (warna == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Warna Tidak Boleh Kosong",
                })
              } else if ($("#harga_txt").val() == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Harga Tidak Boleh Kosong",
                })
              } else {
                formData.append('image_produk', imgProduk[0]);
                formData.append('type', "update");

                var img_name_produk = formData.get('image_produk')['name'];
                var generateUniqProduk = "<?php echo uniqid('produk-lensa-', true) . '.' . '"+getFileExtension(img_name_produk).toLowerCase()+"' ?>";
                var img_name_produk_lama = '<?= $data[$i - 1]["gambar"] ?>';

                formData.append('img_file_produk_baru', generateUniqProduk);
                formData.append('img_file_produk_lama', img_name_produk_lama);

                formData.append('query', "UPDATE produk SET merk='" + merk + "', warna='" + warna + "', harga_jual='" + harga + "', gambar='" + generateUniqProduk + "' WHERE kode_frame = '" + kode_frame + "'");

                $.ajax({
                  type: "post",
                  url: "../controllers/productController.php",
                  data: formData,
                  contentType: false,
                  processData: false,
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
                        window.location.replace("master_product.php?halaman=<?= $halamanAktif ?>");
                      });
                    }
                  }
                });
              }
            }
          });
        });
      <?php endfor ?>

      // edit catalog
      <?php for ($i = 1; $i <= count($data); $i++) : ?>
        $('#edit-button-catalog-<?= $i ?>').on('click', function() {

          chenge("edit");

          reset();

          $('#title').html('Edit Data');
          $('#btn_tambah').html('Edit');

          $('#bgmodalinput').addClass("effectmodal");
          $('#modalkonten').removeClass("scale-0");

          console.log("edit click");

          imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
              imgpreview_peg.src = URL.createObjectURL(file);
              $('#imgpreview_peg').removeClass("hidden");
              $('#imgdefault_peg').addClass("hidden");
            }
          }


          // load data
          $("#kode_txt").val('<?= $data[$i - 1]["kode_frame"] ?>');
          $("#kode_txt").attr('readonly', true);
          $("#merk_txt").val('<?= $data[$i - 1]["merk"] ?>');
          $("#warna_txt").val('<?= $data[$i - 1]["warna"] ?>');
          $("#harga_txt").val('<?= rupiah($data[$i - 1]["harga_jual"]) ?>');

          imgpreview_peg.src = "../images/produk/<?= $data[$i - 1]["gambar"] ?>";
          $('#imgpreview_peg').removeClass("hidden");
          $('#imgdefault_peg').addClass("hidden");

          $("#btn_edit").on("click", function(e) {

            e.preventDefault();

            getData();

            let formData = new FormData();
            let imgProduk = $('#imgInp')[0].files;

            if (!imgProduk.length > 0) {
              console.log("tanpa gambar");
              // gambar tidak ada atau kosong
              if (kode_frame == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Kode Frame Tidak Boleh Kosong",
                })
              } else if (kode_frame.length < 5) {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Kode Frame Tidak Boleh Kurang Dari 5 Karakter",
                })
              } else if (merk == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Merk Tidak Boleh Kosong",
                })
              } else if (warna == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Warna Tidak Boleh Kosong",
                })
              } else if ($("#harga_txt").val() == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Harga Tidak Boleh Kosong",
                })
              } else {
                formData.append('type', "update");
                formData.append('query', "UPDATE produk SET merk='" + merk + "', warna='" + warna + "', harga_jual='" + harga + "' WHERE kode_frame = '" + kode_frame + "'");

                $.ajax({
                  type: "post",
                  url: "../controllers/productController.php",
                  data: formData,
                  contentType: false,
                  processData: false,
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
                        window.location.replace("master_product.php?halaman=<?= $halamanAktif ?>");
                      });
                    }
                  }
                });
              }
            } else {
              console.log("dengan gambar");

              if (kode_frame == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Kode Frame Tidak Boleh Kosong",
                })
              } else if (kode_frame.length < 5) {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Kode Frame Tidak Boleh Kurang Dari 5 Karakter",
                })
              } else if (merk == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Merk Tidak Boleh Kosong",
                })
              } else if (warna == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Warna Tidak Boleh Kosong",
                })
              } else if ($("#harga_txt").val() == "") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: "Harga Tidak Boleh Kosong",
                })
              } else {
                formData.append('image_produk', imgProduk[0]);
                formData.append('type', "update");

                var img_name_produk = formData.get('image_produk')['name'];
                var generateUniqProduk = "<?php echo uniqid('produk-lensa-', true) . '.' . '"+getFileExtension(img_name_produk).toLowerCase()+"' ?>";
                var img_name_produk_lama = '<?= $data[$i - 1]["gambar"] ?>';

                formData.append('img_file_produk_baru', generateUniqProduk);
                formData.append('img_file_produk_lama', img_name_produk_lama);

                formData.append('query', "UPDATE produk SET merk='" + merk + "', warna='" + warna + "', harga_jual='" + harga + "', gambar='" + generateUniqProduk + "' WHERE kode_frame = '" + kode_frame + "'");

                $.ajax({
                  type: "post",
                  url: "../controllers/productController.php",
                  data: formData,
                  contentType: false,
                  processData: false,
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
                        window.location.replace("master_product.php?halaman=<?= $halamanAktif ?>");
                      });
                    }
                  }
                });
              }
            }
          });
        });
      <?php endfor ?>

      var kode_frame;
      var merk;
      var warna;
      var harga;

      function getData() {
        kode_frame = $("#kode_txt").val();
        merk = $("#merk_txt").val();
        warna = $("#warna_txt").val();
        harga = parseInt($("#harga_txt").val().replace("Rp. ", "").replace(".", "").replace(".", "").replace(" ", ""));
      }

      $("#btn_out").on("click", function() {
        $('#bgmodalinput').removeClass("effectmodal");
        $('#modalkonten').addClass("scale-0");
      });

      $("#btn_batal").on("click", function() {
        $('#bgmodalinput').removeClass("effectmodal");
        $('#modalkonten').addClass("scale-0");
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

    // delete modal
    $("#modal-delete").load("../assets/components/modal_hapus.html", function() {

      // delete
      <?php for ($i = 1; $i <= count($data); $i++) : ?>
        $('#delete-button-<?= $i ?>').on('click', function() {
          var id = '<?= $data[$i - 1]["kode_frame"] ?>';
          var img_path = '<?= $data[$i - 1]["gambar"] ?>';

          $('#title_delete').html('Hapus Data Product ini?');

          $('#modalkontenhapus').toggleClass("scale-0");
          $('#bgmodalhapus').addClass("effectmodal");

          $('#submithapus').on('click', function() {

            console.log(img_path);
            $.ajax({
              type: "post",
              url: "../controllers/productController.php",
              data: {
                type: "delete",
                query: "DELETE FROM `produk` WHERE kode_frame = '" + id + "'",
                imgPath: img_path,
              },
              cache: false,
              success: function(res) {
                const data = JSON.parse(res);

                if (data.status == 'success') {
                  Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: data.msg,
                  }).then(function() {
                    window.location.replace("master_product.php");
                  });
                } else {

                }
              }
            });

          })

          $('#closemodalhapus').on('click', function() {

            $('#modalkontenhapus').addClass("scale-0");
            $('#bgmodalhapus').removeClass("effectmodal");
          });

          $('#cancelmodalhapus').on('click', function() {

            $('#modalkontenhapus').addClass("scale-0");
            $('#bgmodalhapus').removeClass("effectmodal");
          });

        });
      <?php endfor ?>

      // delete catalog
      <?php for ($i = 1; $i <= count($data); $i++) : ?>
        $('#delete-button-catalog-<?= $i ?>').on('click', function() {
          var id = '<?= $data[$i - 1]["kode_frame"] ?>';
          var img_path = '<?= $data[$i - 1]["gambar"] ?>';

          $('#title_delete').html('Hapus Data Pegawai ini?');

          $('#modalkontenhapus').toggleClass("scale-0");
          $('#bgmodalhapus').addClass("effectmodal");

          $('#submithapus').on('click', function() {

            console.log("hello");
            $.ajax({
              type: "post",
              url: "../controllers/productController.php",
              data: {
                type: "delete",
                query: "DELETE FROM `produk` WHERE kode_frame = '" + id + "'",
                imgPath: img_path,
              },
              cache: false,
              success: function(res) {
                const data = JSON.parse(res);

                if (data.status == 'success') {
                  Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: data.msg,
                  }).then(function() {
                    window.location.replace("master_product.php");
                  });
                }
              }
            });

          });

          $('#closemodalhapus').on('click', function() {

            $('#modalkontenhapus').removeClass("scale-0");
            $('#bgmodalhapus').removeClass("effectmodal");
          });

          $('#cancelmodalhapus').on('click', function() {

            $('#modalkontenhapus').removeClass("scale-0");
            $('#bgmodalhapus').removeClass("effectmodal");
          });

        });
      <?php endfor ?>
    });

    // search
    $('#search').keypress(function(e) {
      if (e.which == 13) {
        window.location.replace("master_product.php?search=" + $('#search').val());
      }
    });
  </script>

</body>

</html>
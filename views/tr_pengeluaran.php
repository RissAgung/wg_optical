<?php
include '../controllers/pengeluaran.php';
session_start();


if (!isset($_SESSION['statusLogin'])) {
    header('Location: login.php');
} else if ($_SESSION['level'] == 3) {
    header('Location: ../sales/dashboard.php');
}


// pagination
$jumlahDataPerHalaman = 6;
$jumlahData = (isset($_GET["search"])) ? count($crud->showData("SELECT * FROM tr_pengeluaran WHERE keterangan LIKE'%" . $_GET["search"] . "%' LIMIT 0, $jumlahDataPerHalaman")) : count($crud->showData("SELECT * FROM tr_pengeluaran"));
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$execute = (isset($_GET["search"])) ? $crud->showData("SELECT * FROM tr_pengeluaran WHERE keterangan LIKE'%" . $_GET["search"] . "%' ORDER BY tanggal DESC LIMIT $awalData, $jumlahDataPerHalaman") : $crud->showData("SELECT * FROM tr_pengeluaran  ORDER BY tanggal DESC LIMIT $awalData, $jumlahDataPerHalaman");
$restock = $crud->showData("SELECT tr_pengeluaran.kode_tr_pengeluaran, tr_pengeluaran.tanggal, tr_pengeluaran.id_pegawai, tr_pengeluaran.id_Supplier, tr_pengeluaran.jenis, CASE WHEN tr_pengeluaran.kode_perkap IS NULL AND tr_pengeluaran.kode_barang IS NULL THEN tr_pengeluaran.kode_frame ELSE CASE WHEN tr_pengeluaran.kode_frame IS NULL AND tr_pengeluaran.kode_barang IS NULL THEN tr_pengeluaran.kode_perkap ELSE tr_pengeluaran.kode_barang END END as barang, tr_pengeluaran.QTY FROM tr_pengeluaran LEFT JOIN perlengkapan ON tr_pengeluaran.kode_perkap = perlengkapan.kode_perlengkapan LEFT JOIN tambahan ON tambahan.kode_barang = tr_pengeluaran.kode_barang WHERE tr_pengeluaran.kategori = 'restock';");

function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

// header("Content-type: application/vnd-ms-excel");
// header("Content-Disposition: attachment; filename=ini.xls");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengeluaran | WG Optical</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/datepicker.css">
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">

    <!-- modal  -->
    <div id="modal"></div>
    <!-- end modal  -->


    <!-- modal filter date -->
    <div id="modal_date"></div>
    <!-- end modal filter date -->

    <!-- Background hitam saat sidebar show -->
    <div id="bgbody" class="w-full h-screen bg-black fixed z-50 bg-opacity-50 hidden"></div>
    <!-- End Background hitam saat sidebar show -->
    <!-- sidebar -->
    <div id="ex-sidebar" class="ex-sidebar ex-hide-sidebar fixed z-50 max-lg:transition max-lg:duration-[1s]"></div>
    <!-- end sidebar -->
    <div class="lg:ml-72">
        <div class="w-full h-16 bg-white flex items-center md:justify-between md:px-5 justify-between px-6">
            <div class="flex flex-row uppercase font-ex-bold text-sm items-center">

                <!-- hamburger -->
                <div class="ex-burger mr-2 lg:hidden absolute" id="burger">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="20" height="20">
                        <rect y="10.5" width="24" height="3" />
                        <rect y="3.5" width="24" height="3" />
                        <rect y="17.5" width="24" height="3" />
                    </svg>
                </div>
                <div class="ex-burger mr-2 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Isolation_Mode" data-name="Isolation Mode" viewBox="0 0 24 24" width="20" height="20">
                        <rect y="10.5" width="24" height="3" />
                        <rect y="3.5" width="24" height="3" />
                        <rect y="17.5" width="24" height="3" />
                    </svg>
                </div>

                <h1>Pengeluaran</h1>
            </div>
            <div class="flex flex-row items-center">
                <div class="mr-4">
                    <svg width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.8313 21.0763L23.5594 20.8364C22.788 20.1491 22.1129 19.361 21.5521 18.4933C20.9397 17.2957 20.5727 15.9879 20.4725 14.6467V10.6961C20.4778 8.58936 19.7136 6.55319 18.3235 4.97017C16.9334 3.38714 15.013 2.36623 12.9233 2.09923V1.06761C12.9233 0.784463 12.8108 0.512912 12.6106 0.312696C12.4104 0.11248 12.1388 0 11.8557 0C11.5725 0 11.301 0.11248 11.1008 0.312696C10.9005 0.512912 10.7881 0.784463 10.7881 1.06761V2.11523C8.71703 2.40147 6.81989 3.42855 5.44804 5.00626C4.07618 6.58396 3.32257 8.60538 3.32679 10.6961V14.6467C3.22663 15.9879 2.85958 17.2957 2.24718 18.4933C1.69609 19.3588 1.03178 20.1468 0.271901 20.8364L0 21.0763V23.3315H23.8313V21.0763Z" fill="#444D68" />
                        <path d="M9.81348 24.1712C9.8836 24.6781 10.1348 25.1425 10.5206 25.4787C10.9065 25.8148 11.401 26 11.9127 26C12.4245 26 12.9189 25.8148 13.3048 25.4787C13.6906 25.1425 13.9418 24.6781 14.0119 24.1712H9.81348Z" fill="#444D68" />
                    </svg>
                </div>
                <img class="w-10 h-10 rounded-full" src="https://upload.wikimedia.org/wikipedia/id/d/d5/Aang_.jpg" alt="Rounded avatar">
            </div>
        </div>

        <!-- tab bar -->
        <div class="mt-3 flex items-center flex-col md:flex-row md:justify-around lg:justify-between lg:px-16 md:py-[3px]">
            <div class="box-border p-1.5 drop-shadow-sm rounded-md flex justify-between flex-row text-sm font-ex-semibold bg-white z-[1]">
                <div id="hovertab" class="transition translate-x-[0px] ease-in-out h-[35px] rounded-lg w-[80px] absolute bg-[#343948]"></div>
                <div id="tabOperasional" class="flex cursor-pointer justify-center py-1.5 px-4 rounded-md tab-focus">Operasional</div>
                <div id="tabRestock" class="flex cursor-pointer justify-center py-1.5 px-4 rounded-md">Restock</div>
            </div>
            <!-- End tab bar -->
        </div>


        <div class="mx-auto w-[90%] md:w-[90%] md:mx-auto rounded-md py-0 px-0">
            <div class="mt-0 flex items-center content-center flex-wrap justify-between max-[450px]:justify-center">
                <!-- Search -->
                <div class="flex flex-row shadow-sm rounded-md items-center justify-around bg-white w-72 box-border px-2 md:mr-6 mt-6">
                    <div class="w-full flex flex-row items-center">
                        <svg width="19" height="19" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-3">
                            <path d="M19.2502 19.25L15.138 15.1305M17.4168 9.62501C17.4168 11.6915 16.5959 13.6733 15.1347 15.1346C13.6735 16.5958 11.6916 17.4167 9.62516 17.4167C7.55868 17.4167 5.57684 16.5958 4.11562 15.1346C2.6544 13.6733 1.8335 11.6915 1.8335 9.62501C1.8335 7.55853 2.6544 5.57669 4.11562 4.11547C5.57684 2.65425 7.55868 1.83334 9.62516 1.83334C11.6916 1.83334 13.6735 2.65425 15.1347 4.11547C16.5959 5.57669 17.4168 7.55853 17.4168 9.62501V9.62501Z" stroke="#797E8D" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <?php $input = (isset($_GET["search"])) ? $_GET["search"] : null ?>
                        <input id="search" value="<?= $input ?>" type="text" placeholder="Cari Transaksi" class="h-11 bg-transparent ml-2 outline-none" />
                    </div>
                    <div id="btn_reset" class="cursor-pointer hidden justify-center items-center">
                        <svg class="cursor-pointer fill-[#535A6D]" width="10" height="10" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.3289 5.47926L10.6264 2.18142C10.8405 1.93831 10.9539 1.62288 10.9436 1.29924C10.9332 0.975599 10.7999 0.668037 10.5707 0.439072C10.3415 0.210106 10.0337 0.0769213 9.70976 0.0665883C9.38581 0.0562553 9.07009 0.16955 8.82676 0.383443L5.52586 3.67789L2.21901 0.373252C2.10056 0.254916 1.95995 0.161048 1.80519 0.097005C1.65044 0.0329623 1.48457 1.24687e-09 1.31706 0C1.14956 -1.24687e-09 0.983689 0.0329623 0.828933 0.097005C0.674177 0.161048 0.533562 0.254916 0.415117 0.373252C0.296672 0.491587 0.202716 0.632072 0.138614 0.786685C0.0745119 0.941298 0.041519 1.10701 0.041519 1.27436C0.041519 1.44171 0.0745119 1.60743 0.138614 1.76204C0.202716 1.91665 0.296672 2.05714 0.415117 2.17547L3.72282 5.47926L0.425318 8.77625C0.295996 8.89175 0.19162 9.03239 0.118574 9.18957C0.0455293 9.34676 0.00535166 9.51718 0.000499102 9.69041C-0.00435345 9.86364 0.0262212 10.036 0.0903528 10.1971C0.154484 10.3581 0.250824 10.5043 0.373478 10.6269C0.496133 10.7494 0.642522 10.8457 0.80369 10.9097C0.964858 10.9738 1.13742 11.0043 1.31081 10.9995C1.4842 10.9947 1.65478 10.9545 1.81211 10.8815C1.96944 10.8086 2.11021 10.7043 2.22581 10.5751L5.52586 7.28063L8.82251 10.5751C9.06172 10.8141 9.38616 10.9483 9.72446 10.9483C10.0628 10.9483 10.3872 10.8141 10.6264 10.5751C10.8656 10.3361 11 10.0119 11 9.67396C11 9.33598 10.8656 9.01184 10.6264 8.77286L7.3289 5.47926Z" fill="#535A6D" />
                        </svg>
                    </div>

                </div>
                <!-- End Search -->

                <!-- Button Add + Filter + Ekspor -->
                <div class="flex flex-col md:flex-row items-center mt-3 md:mt-0 gap-2">
                    <div>
                        <button href="../controllers/export.php" class="bg-[#ffffff] drop-shadow-sm rounded-md px-2 py-1.5">
                            <!-- onclick="tableHtmlToExcel('tableOPR')" -->
                            <svg width="26px" height="26px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <rect width="100" height="100" fill="#Ffff" />
                                <path d="M18 22a2 2 0 0 0 2-2v-5l-5 4v-3H8v-2h7v-3l5 4V8l-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12zM13 4l5 5h-5V4z" fill="#000000" />
                            </svg>
                        </button>
                    </div>
                    <div id="click-filter">
                        <button class="bg-[#ffffff] drop-shadow-sm rounded-md px-2 py-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6 11.1707L6 4C6 3.44771 5.55228 3 5 3C4.44771 3 4 3.44771 4 4L4 11.1707C2.83481 11.5825 2 12.6938 2 14C2 15.3062 2.83481 16.4175 4 16.8293L4 20C4 20.5523 4.44772 21 5 21C5.55228 21 6 20.5523 6 20L6 16.8293C7.16519 16.4175 8 15.3062 8 14C8 12.6938 7.16519 11.5825 6 11.1707ZM5 13C4.44772 13 4 13.4477 4 14C4 14.5523 4.44772 15 5 15C5.55228 15 6 14.5523 6 14C6 13.4477 5.55228 13 5 13Z" fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19 21C18.4477 21 18 20.5523 18 20L18 18C18 17.9435 18.0047 17.8881 18.0137 17.8341C16.8414 17.4262 16 16.3113 16 15C16 13.6887 16.8414 12.5738 18.0137 12.1659C18.0047 12.1119 18 12.0565 18 12L18 4C18 3.44771 18.4477 3 19 3C19.5523 3 20 3.44771 20 4L20 12C20 12.0565 19.9953 12.1119 19.9863 12.1659C21.1586 12.5738 22 13.6887 22 15C22 16.3113 21.1586 17.4262 19.9863 17.8341C19.9953 17.8881 20 17.9435 20 18V20C20 20.5523 19.5523 21 19 21ZM18 15C18 14.4477 18.4477 14 19 14C19.5523 14 20 14.4477 20 15C20 15.5523 19.5523 16 19 16C18.4477 16 18 15.5523 18 15Z" fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9 9C9 7.69378 9.83481 6.58254 11 6.17071V4C11 3.44772 11.4477 3 12 3C12.5523 3 13 3.44772 13 4V6.17071C14.1652 6.58254 15 7.69378 15 9C15 10.3113 14.1586 11.4262 12.9863 11.8341C12.9953 11.8881 13 11.9435 13 12L13 20C13 20.5523 12.5523 21 12 21C11.4477 21 11 20.5523 11 20L11 12C11 11.9435 11.0047 11.8881 11.0137 11.8341C9.84135 11.4262 9 10.3113 9 9ZM11 9C11 8.44772 11.4477 8 12 8C12.5523 8 13 8.44772 13 9C13 9.55229 12.5523 10 12 10C11.4477 10 11 9.55229 11 9Z" fill="black" />
                            </svg>
                        </button>
                    </div>
                    <div class="md:my-auto h-10 w-24 font-ex-semibold text-white mt-3 md:mt-0" id="add">
                        <button class="bg-[#3DBD9E] h-full w-full rounded-md">Tambah</button>
                    </div>
                    <!-- End Button Add + Filter + Ekspor -->
                </div>
            </div>
        </div>
        <!-- End Search and Button -->

        <div id="pageOperasional">
            <!-- konten table -->
            <div class="" id="tableOPR">
                <!-- Table -->
                <div class="overflow-x-auto  text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 py-6 px-6 ex-table">
                    <table class="w-full ">
                        <thead class="border-b-2 border-gray-100">
                            <tr>
                                <th class="p-3 text-sm tracking-wide text-center">No</th>
                                <th class="p-3 text-sm tracking-wide text-center">Kode Transaksi</th>
                                <th class="p-3 text-sm tracking-wide text-center">Tanggal</th>
                                <th class="p-3 text-sm tracking-wide text-center">User</th>
                                <th class="p-3 text-sm tracking-wide text-center">Keterangan</th>
                                <th class="p-3 text-sm tracking-wide text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $nomor = ($jumlahDataPerHalaman * $halamanAktif) - ($jumlahDataPerHalaman - 1);
                            $i = 0;
                            foreach ($execute as $data) {
                                if ($data['kategori'] == "operasional") {
                            ?>
                                    <tr>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $nomor; ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $data['kode_tr_pengeluaran'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $data['tanggal'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $data['id_pegawai'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $data['keterangan'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo rupiah($data['total_harga']) ?></td>
                                    </tr>
                                    <script>
                                    </script>
                            <?php
                                }
                                $nomor++;
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->

                <!-- Pagination And Info Data -->
                <div class="mx-auto w-[90%] md:w-[90%] md:mx-autorounded-md py-2 px-0">
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
                        <div class="mb-3"><?= count($execute) ?> from <?= $jumlahData ?> data</div>
                    </div>
                    <!-- End Pagination And Info Data -->


                </div>
            </div>


        </div>

        <div id="pageRestock" class="hidden">
            <!-- konten table -->
            <div class="">
                <!-- Table -->
                <div class="overflow-x-auto  text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 py-6 px-6 ex-table">
                    <table class="w-full ">
                        <thead class="border-b-2 border-gray-100">
                            <tr>
                                <th class="p-3 text-sm tracking-wide text-center">No</th>
                                <th class="p-3 text-sm tracking-wide text-center">Kode Transaksi</th>
                                <th class="p-3 text-sm tracking-wide text-center">Tanggal</th>
                                <th class="p-3 text-sm tracking-wide text-center">User</th>
                                <th class="p-3 text-sm tracking-wide text-center">Supplier</th>
                                <th class="p-3 text-sm tracking-wide text-center">Jenis</th>
                                <th class="p-3 text-sm tracking-wide text-center">Barang</th>
                                <th class="p-3 text-sm tracking-wide text-center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $nomer = ($jumlahDataPerHalaman * $halamanAktif) - ($jumlahDataPerHalaman - 1);
                            $i = 0;
                            foreach ($restock as $restok) {
                                
                            ?>
                                    <tr>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $nomer; ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['kode_tr_pengeluaran'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['tanggal'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['id_pegawai'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['id_Supplier'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['jenis'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['barang'] ?></td>
                                        <td class="p-3 text-sm tracking-wide text-center"><?php echo $restok['QTY'] ?></td>
                                    </tr>
                                    <script>

                                    </script>
                            <?php
                                
                                $nomer++;
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->
                <!-- Pagination And Info Data -->
                <div class="mx-auto w-[90%] md:w-[90%] md:mx-autorounded-md py-2 px-0">
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
                        <div class="mb-3"><?= count($execute) ?> from <?= $jumlahData ?> data</div>
                    </div>
                    <!-- End Pagination And Info Data -->


                </div>


                <script src="../js/jquery-3.6.1.min.js"></script>
                <script src="../js/sweetalert2.min.js"></script>
                <script src="../js/jquery.iddle.min.js"></script>
                <script src="../js/datepicker.js"></script>

                <script>
                    // load sidebar
                    $("#ex-sidebar").load("../assets/components/sidebar.html", function() {
                        $('#pengeluaran').addClass("hover-sidebar");
                        $('#button-logout').on('click', function() {
                            // kosong
                        });
                    });

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
                </script>

                <script>
                    $("#modal_date").load("../assets/components/modal_filter_date.html", function() {
                        $('#click-filter').on('click', function() {

                            $('#modalkonten2').toggleClass("scale-0");
                            $('#bgmodal2').addClass("effectmodal");
                        });
                    });
                </script>


                <script>
                    // load modal input
                    $("#modal").load("../assets/components/modal_pengeluaran.php", function() {
                        modals("Opr");
                        $('#pageOperasional').addClass('statusclick');

                        //change tab
                        $('#tabOperasional').on('click', function() {

                            $('#pageOperasional').removeClass("hidden");
                            $('#pageRestock').addClass("hidden");
                            $('#pageOperasional').toggleClass('statusclick');

                            $('#hovertab').addClass("translate-x-[0px]");
                            $('#hovertab').removeClass("translate-x-[165px]");

                            $('#tabOperasional').addClass("tab-focus");
                            $('#tabRestock').removeClass("tab-focus");
                            modals("Opr");

                        });

                        $('#tabRestock').on('click', function() {
                            
                            // $('#pageOperasional').addClass('hidden');
                            // $('#pageRestock').removeClass('hidden');

                            $('#pageOperasional').addClass("hidden");
                            $('#pageRestock').removeClass("hidden");

                            $('#pageRestock').removeClass("hidden");
                            $('#pageOperasional').addClass("hidden");
                            $('#pageRestock').toggleClass('statusclick');
                            $('#pageOperasional').removeClass('statusclick');

                            $('#hovertab').addClass("translate-x-[165px]");
                            $('#hovertab').removeClass("translate-x-[0px]");

                            $('#tabOperasional').removeClass("tab-focus");
                            $('#tabRestock').addClass("tab-focus");
                            modals("Res");
                        });

                        //button close modal
                        function closeModal() {
                            $('#modalkonten').addClass("scale-0");
                            $('#bgmodal').removeClass("effectmodal");

                            $('#date').val("");
                            $('#ket').val("");
                            $('#total').val("");
                            $('#jml').val("");
                        }
                        //end close modal


                        //start add data
                        
                        $('#add').on('click', function() {

                            var idPegawai = "<?php echo $_SESSION["id_pegawai"] ?>";
                            var kode;
                            var tgl;
                            var keterangan;
                            var total;
                            var jenis;
                            var frame;
                            var tambahan;
                            var perkap;
                            var supplier;
                            var qty;

                            console.log("add");
                            console.log(idPegawai);


                            $('#modalkonten').removeClass("scale-0");
                            $('#bgmodal').addClass("effectmodal");
                            $('#title').html('Tambah Data');

                            function getData() {
                                tgl = $("#date").val();
                                date = $("#tanggal").val();
                                keterangan = $('#ket').val();
                                total = parseInt($("#total").val().replace("Rp. ", "").replace(".", "").replace(".", "").replace(" ", ""));
                                kode = "TR" + Math.random().toString(9).slice(2, 10);                              
                                jenis = $("#jns").val();
                                frame = $("#brg").val();
                                tambahan = $("#brg").val();
                                perkap = $("#brg").val();
                                supplier = $("#supplier").val();
                                qty = $("#jml").val();
                            };




                            //start query add
                            if ($( "#pageOperasional" ).hasClass( "statusclick")){
                            $("#btn_tambah").on("click", function(e) {
                                e.preventDefault();
                                getData();
                                let formData = new FormData();
                                let query;
                                formData.append('type', "insert");
                                formData.append('query', "INSERT INTO tr_pengeluaran VALUES ('" + kode + "' ,'" + tgl + "','" + idPegawai + "','operasional','" + keterangan + "','" + total + "','NULL','NULL','NULL','NULL','NULL','NULL')");

                                if ($('#date').val() == "") {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: "Masukkan Tanggal",
                                    })
                                } else if ($('#ket').val() == "") {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: "Keterangan Tidak Boleh Kosong",
                                    })
                                } else if ($('#total').val() == "") {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: "Total Harga Tidak Boleh Kosong",
                                    })
                                } else {
                                    $.ajax({
                                        type: "POST",
                                        url: "../controllers/pengeluaran.php",
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
                                                    closeModal();
                                                    window.location.replace("tr_pengeluaran.php?halaman=<?= $halamanAktif ?>");
                                                });
                                            }
                                        }
                                    });
                                }
                            });
                            //end query add    
                        }else if($( "#pageRestock" ).hasClass( "statusclick")){
                            $("#btn_tambah").on("click", function(e) {
                                console.log("add stock");
                                e.preventDefault();
                                getData();
                                let formData = new FormData();
                                let query;
                                formData.append('type', "insert");
                                formData.append('query', "INSERT INTO tr_pengeluaran VALUES ('" + kode + "' ,'" + date + "','" + idPegawai + "','restock','NULL','NULL','"+jenis+"','NULL','NULL','12212','"+supplier+"','"+qty+"')");

                                $.ajax({
                                        type: "POST",
                                        url: "../controllers/pengeluaran.php",
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
                                                    closeModal();
                                                    window.location.replace("tr_pengeluaran.php?halaman=<?= $halamanAktif ?>");
                                                });
                                            }
                                        }
                                    });
                           
                            });
                        };
                        }); //end code add    

                        //close modal 
                        $("#btn_out").on("click", function() {
                            closeModal();
                        });

                        $("#btn_batal").on("click", function() {
                            closeModal();
                        });

                    }); //end load modal add 
                </script>


                <script>
                    // reset search
                    var input = '<?= $input ?>';
                    if (input !== "") {
                        $('#btn_reset').removeClass('hidden');
                        $('#btn_reset').addClass('flex');
                        $('#btn_reset').on('click', function() {
                            window.location.replace("tr_pengeluaran.php");
                        })
                    }
                    //search
                    $('#search').keypress(function(e) {
                        if (e.which == 13) {
                            if ($('#search').val() == "") {
                                window.location.replace("tr_pengeluaran.php");
                            } else {

                                window.location.replace("tr_pengeluaran.php?search=" + $('#search').val());
                            }
                        }
                    });
                </script>

</body>

</html>
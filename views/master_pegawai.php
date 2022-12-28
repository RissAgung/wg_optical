<?php
include '../controllers/pegawaiController.php';

session_start();


if (!isset($_SESSION['statusLogin'])) {
    header('Location: login.php');
} else if ($_SESSION['level'] == 3) {
    header('Location: ../sales/dashboard.php');
}



// pagination
$jumlahDataPerHalaman = 6;

$roles;

if ($_SESSION['level'] == '1') {
    $jumlahData = (isset($_GET["search"])) ? count($crud->showData("SELECT * FROM pegawai WHERE nama LIKE'%" . $_GET["search"] . "%' LIMIT 0, $jumlahDataPerHalaman")) : count($crud->showData("SELECT * FROM pegawai"));
    $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
    $roles = 1;
} else if ($_SESSION['level'] == '2') {
    $jumlahData = (isset($_GET["search"])) ? count($crud->showData("SELECT * FROM pegawai WHERE nama LIKE'%" . $_GET["search"] . "%' AND id_level = '3' LIMIT 0, $jumlahDataPerHalaman")) : count($crud->showData("SELECT * FROM pegawai WHERE id_level = '3'"));
    $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
    $roles = 2;
}
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
if ($roles == 1) {
    $execute = (isset($_GET["search"])) ? $crud->showData("SELECT * FROM pegawai WHERE nama LIKE'%" . $_GET["search"] . "%' ORDER BY SUBSTRING(id_pegawai, -1, 5) DESC LIMIT $awalData, $jumlahDataPerHalaman") : $crud->showData("SELECT * FROM pegawai ORDER BY SUBSTRING(id_pegawai, -1, 5) DESC LIMIT $awalData, $jumlahDataPerHalaman");
} else {
    $execute = (isset($_GET["search"])) ? $crud->showData("SELECT * FROM pegawai WHERE nama LIKE'%" . $_GET["search"] . "%' AND id_level = '3' ORDER BY SUBSTRING(id_pegawai, -1, 5) DESC LIMIT $awalData, $jumlahDataPerHalaman") : $crud->showData("SELECT * FROM pegawai WHERE id_level = '3' ORDER BY SUBSTRING(id_pegawai, -1, 5) DESC LIMIT $awalData, $jumlahDataPerHalaman");
}



function generateID(Koneksi $obj, $tglmasuk)
{
    $data = $obj->showData('SELECT COUNT(*) AS jumlah FROM pegawai');
    if (empty($data)) {
        return $tglmasuk . '' . 1;
    } else {
        foreach ($data as $value) {
            return $tglmasuk . "" . ($value['jumlah'] + 1);
        }
    }
}

function getNameRoles($id)
{
    switch ($id) {
        case '1':
            return "Super Admin";
            break;
        case '2':
            return "Admin";
            break;
        case '3':
            return "Sales";
            break;
        default:
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Pegawai | WG Optical</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/apexcharts.css">
    <link rel="stylesheet" href="../css/sweetalert2.min.css">
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">
    <div id="loading" class="fixed w-full h-full top-0 left-0 flex flex-col justify-center items-center bg-slate-50 z-[99]">
        <div class="loadingspinner"></div>
    </div>

    <!-- modal detail -->
    <div id="modal-detail" class=""></div>
    <!-- end modal detail -->

    <!-- modal  -->
    <div id="modal-addBarang" class=""></div>
    <!-- end modal  -->

    <!-- modal  -->
    <div id="modal-form" class=""></div>
    <!-- end modal  -->

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

        <div class="mx-auto w-[90%] md:w-[90%] md:mx-auto rounded-md py-0 px-0">
            <div class="mt-0 flex items-center content-center flex-wrap justify-between max-[450px]:justify-center">
                <!-- Search -->
                <div class="flex flex-row shadow-sm rounded-md items-center justify-around bg-white w-72 box-border px-2 md:mr-6 mt-6">
                    <div class="w-full flex flex-row items-center">
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

                <!-- Search and Button Add -->
                <div class="flex flex-col md:flex-row items-center mt-6">
                    <!-- Button Add -->
                    <div class="md:my-auto h-10 w-24 font-ex-semibold text-white" id="click-modal">
                        <button class="bg-[#3DBD9E] h-full w-full rounded-md">Tambah</button>
                    </div>
                    <!-- End Button Add -->
                </div>
                <!-- End Search and Button Add -->
            </div>
        </div>


        <!-- konten table -->
        <div class="" id="table">
            <!-- Table -->
            <div class="overflow-x-auto  text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 py-6 px-6 ex-table">
                <table class="w-full ">
                    <thead class="border-b-2 border-gray-100">
                        <tr>
                            <th class="p-3 text-sm tracking-wide text-center">No</th>
                            <th class="p-3 text-sm tracking-wide text-center">Nama</th>
                            <th class="p-3 text-sm tracking-wide text-center">ID Pegawai</th>
                            <th class="p-3 text-sm tracking-wide text-center">Gender</th>
                            <th class="p-3 text-sm tracking-wide text-center">No Telepon</th>
                            <th class="p-3 text-sm tracking-wide text-center">Level</th>
                            <th class="p-3 text-sm tracking-wide text-center">Alamat</th>
                            <th class="p-3 text-sm tracking-wide text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = ($jumlahDataPerHalaman * $halamanAktif) - ($jumlahDataPerHalaman - 1);
                        $i = 0;
                        foreach ($execute as $data) {
                        ?>
                            <tr>
                                <td class="p-3 text-sm tracking-wide text-center"><?php echo $nomor; ?></td>
                                <td class="p-3 text-sm tracking-wide justify-center">
                                    <div class="flex flex-row items-center  content-center">
                                        <img class="w-6 h-6 rounded-full" src="../images/pegawai/foto_pegawai/<?php echo $data['foto_pegawai'] ?>" alt="Rounded avatar">
                                        <p class="px-2"><?php echo $data['nama'] ?></p>
                                    </div>
                                </td>
                                <td class="p-3 text-sm tracking-wide text-center"><?php echo $data['id_pegawai'] ?></td>
                                <td class="p-3 text-sm tracking-wide text-center"><?php echo $data['gender'] ?></td>
                                <td class="p-3 text-sm tracking-wide text-center"><?php echo $data['no.Telp'] ?></td>
                                <td class="p-3 text-sm tracking-wide text-center"><?php echo getNameRoles($data['id_level']) ?></td>
                                <td class="p-3 text-sm tracking-wide text-center"><?php echo $data['alamat'] ?></td>
                                <td class="p-3 text-sm tracking-wide text-center">
                                    <button onclick="detailBarang('<?= $data['id_pegawai']; ?>', '<?= $data['nama']; ?>')">
                                        <svg width="38" height="37" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="25.36" height="25.36" rx="5" fill="#82DCC6" />
                                            <path d="M11.7255 15.9349C11.7263 15.1391 11.9652 14.361 12.4124 13.6973C12.8596 13.0336 13.4954 12.5136 14.241 12.2017C14.9866 11.8899 15.809 11.8001 16.6061 11.9434C17.4032 12.0867 18.1398 12.4569 18.7246 13.0079V6.87375C18.7246 6.37654 18.5235 5.8997 18.1655 5.54812C17.8075 5.19654 17.322 4.99902 16.8157 4.99902H9.18041C8.33697 5.00002 7.52835 5.32953 6.93195 5.91528C6.33554 6.50103 6.00003 7.29519 5.99902 8.12357V16.8723C6.00003 17.7007 6.33554 18.4949 6.93195 19.0806C7.52835 19.6664 8.33697 19.9959 9.18041 19.9969H15.8613C14.7644 19.9969 13.7125 19.5689 12.9369 18.8071C12.1613 18.0454 11.7255 17.0122 11.7255 15.9349V15.9349ZM9.18041 9.37339C9.18041 9.20765 9.24745 9.04871 9.36677 8.93151C9.4861 8.81432 9.64794 8.74848 9.81669 8.74848H14.9069C15.0757 8.74848 15.2375 8.81432 15.3568 8.93151C15.4762 9.04871 15.5432 9.20765 15.5432 9.37339C15.5432 9.53913 15.4762 9.69808 15.3568 9.81527C15.2375 9.93246 15.0757 9.9983 14.9069 9.9983H9.81669C9.64794 9.9983 9.4861 9.93246 9.36677 9.81527C9.24745 9.69808 9.18041 9.53913 9.18041 9.37339ZM19.8107 19.8138C19.6914 19.9309 19.5296 19.9967 19.3609 19.9967C19.1921 19.9967 19.0303 19.9309 18.911 19.8138L17.3795 18.3096C16.9259 18.5939 16.3994 18.7456 15.8613 18.747C15.295 18.747 14.7415 18.5821 14.2706 18.2731C13.7997 17.9641 13.4327 17.5249 13.216 17.0111C12.9993 16.4972 12.9426 15.9318 13.0531 15.3863C13.1636 14.8408 13.4363 14.3398 13.8367 13.9465C14.2371 13.5532 14.7473 13.2854 15.3027 13.1769C15.8582 13.0684 16.4339 13.1241 16.957 13.3369C17.4802 13.5497 17.9274 13.9102 18.242 14.3726C18.5567 14.8351 18.7246 15.3788 18.7246 15.9349C18.7231 16.4634 18.5687 16.9805 18.2792 17.426L19.8107 18.9301C19.93 19.0473 19.997 19.2062 19.997 19.3719C19.997 19.5377 19.93 19.6966 19.8107 19.8138Z" fill="#51514F" />
                                        </svg>

                                    </button>
                                    <button id="edit-button-<?php echo $i; ?>">
                                        <svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="37" height="37" rx="5" fill="#EDC683" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M27.4782 8.38256C27.7335 8.48841 27.9655 8.64355 28.1609 8.83911C28.3564 9.03447 28.5116 9.26646 28.6174 9.52181C28.7233 9.77717 28.7777 10.0509 28.7777 10.3273C28.7777 10.6037 28.7233 10.8774 28.6174 11.1328C28.5116 11.3881 28.3564 11.6201 28.1609 11.8155L25.3473 14.6282L22.3717 11.6526L25.1845 8.83911C25.3798 8.64355 25.6118 8.48841 25.8672 8.38256C26.1225 8.27671 26.3962 8.22223 26.6727 8.22223C26.9491 8.22223 27.2228 8.27671 27.4782 8.38256ZM9.59277 25.7604C9.59295 24.9094 9.93117 24.0933 10.533 23.4916L21.2376 12.787L24.2132 15.7626L13.5086 26.4672C12.9069 27.069 12.0908 27.4072 11.2398 27.4074H9.59277V25.7604Z" fill="#3F2C0D" />
                                        </svg>
                                    </button>
                                    <button onclick="hapusPegawai('-<?php echo $i; ?>')" id="delete-button-<?php echo $i; ?>">
                                        <svg width="38" height="37" viewBox="0 0 38 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="0.444336" width="37" height="37" rx="5" fill="#F35E58" />
                                            <path d="M23.3982 10.5062V8.67903C23.3982 8.19444 23.2105 7.72969 22.8764 7.38703C22.5423 7.04437 22.0892 6.85187 21.6167 6.85187H16.2723C15.7998 6.85187 15.3467 7.04437 15.0126 7.38703C14.6785 7.72969 14.4908 8.19444 14.4908 8.67903V10.5062H10.0371V12.3333H11.8186V26.0371C11.8186 26.7639 12.1001 27.4611 12.6013 27.975C13.1024 28.489 13.7821 28.7778 14.4908 28.7778H23.3982C24.1069 28.7778 24.7866 28.489 25.2878 27.975C25.7889 27.4611 26.0704 26.7639 26.0704 26.0371V12.3333H27.8519V10.5062H23.3982ZM18.0538 22.3827H16.2723V16.9012H18.0538V22.3827ZM21.6167 22.3827H19.8353V16.9012H21.6167V22.3827ZM21.6167 10.5062H16.2723V8.67903H21.6167V10.5062Z" fill="#501614" />
                                        </svg>

                                    </button>
                                </td>
                            </tr>
                            <script>

                            </script>
                        <?php
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
        <!-- end konten table -->
    </div>
    <script src="../js/jquery-3.6.1.min.js"></script>
    <script src="../js/sweetalert2.min.js"></script>
    <script src="../js/jquery.iddle.min.js"></script>
    <script src="../js/md5.js"></script>


    <script>
        $(window).on('load', function(){
            $('#loading').hide();
        });
        // $(document).idle({
        //     onIdle: function() {
        //         $.ajax({
        //             url: '../controllers/loginController.php',
        //             type: 'post',
        //             data: {
        //                 'type': 'logout',
        //             },
        //             success: function() {

        //             }
        //         });
        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Informasi',
        //             text: 'Sesi anda telah habis, silahkan login kembali',

        //         }).then(function() {
        //             window.location.replace('../views/login.php');
        //         });

        //     },
        //     idle: 50000
        // });

        $('#modal-addBarang').load("../assets/components/modal_pilih_barang.php", function() {
            $('#closemodaladdbarang').on('click', function() {
                $('#modalkontenaddbarang').addClass("scale-0");
                $('#bgmodaladdbarang').removeClass("effectmodal");
            });
        });

        // top_bar
        $('#top_bar').load("../assets/components/top_bar.php", function() {
            $('#title-header').html('Master Data Pegawai');
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

        $('#modal-detail').load("../assets/components/modal_detail_barang_bawa.html", function() {
            $('#closemodaldetail').on('click', function() {
                $('#modalkontendetail').toggleClass("scale-0");
                $('#bgmodaldetail').removeClass("effectmodal");



                kontenhtml = "";
                $('#no-data').removeClass('flex');
                $('#no-data').addClass('hidden');



            });


        });

        function detailBarang(id_pegawai, nama) {

            var kontenhtml = '';

            $.ajax({
                url: '../controllers/tabelBarangBawaController.php?id=' + id_pegawai,
                type: 'GET',
                beforeSend: function() {
                    $('#tabledetail').addClass('h-full');
                    $('#bodytabel').html('<div id="loadingchart" class=" h-full w-full flex flex-col justify-center items-center bg-slate-50 z-[20]"><div class="loadingspinner"></div></div>');
                },
                success: function(res) {
                    $('#tabledetail').removeClass('h-full');
                    $('#loadingchart').hide();
                    const value_utama = JSON.parse(res);
                    if (value_utama.length == 0) {
                        $('#no-data').addClass('flex');
                        $('#no-data').removeClass('hidden');
                        $('#bodytabel').html('');
                    } else {
                        for (let index = 0; index < value_utama.length; index++) {
                            const element = value_utama[index];
                            kontenhtml += '<tr class="h-16">';
                            kontenhtml += '<td class="tracking-wide p-2 text-sm text-center">' + (index + 1) + '</td>';
                            kontenhtml += '<td class="tracking-wide p-2 text-sm text-center">' + element.id_bawa + '</td>';
                            kontenhtml += '<td class="tracking-wide p-2 text-sm text-center">' + element.merk + '</td>';
                            kontenhtml += '<td class="px-4 text-center">';
                            kontenhtml += '<button onClick="deleteDetailBawa(\'' + element.id_bawa + '\')">'
                            kontenhtml += '<svg width="40" height="40" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">';
                            kontenhtml += '<rect width="18" height="18" rx="5" fill="#F35E58" />';
                            kontenhtml += '<path d="M11.1665 5.11079V4.2219C11.1665 3.98615 11.0752 3.76006 10.9127 3.59336C10.7501 3.42666 10.5297 3.33301 10.2998 3.33301H7.69984C7.46998 3.33301 7.24954 3.42666 7.08701 3.59336C6.92448 3.76006 6.83317 3.98615 6.83317 4.2219V5.11079H4.6665V5.99967H5.53317V12.6663C5.53317 13.02 5.67013 13.3591 5.91393 13.6092C6.15773 13.8592 6.48839 13.9997 6.83317 13.9997H11.1665C11.5113 13.9997 11.8419 13.8592 12.0857 13.6092C12.3295 13.3591 12.4665 13.02 12.4665 12.6663V5.99967H13.3332V5.11079H11.1665ZM8.5665 10.8886H7.69984V8.2219H8.5665V10.8886ZM10.2998 10.8886H9.43317V8.2219H10.2998V10.8886ZM10.2998 5.11079H7.69984V4.2219H10.2998V5.11079Z" fill="#501614" />';
                            kontenhtml += '</svg>';
                            kontenhtml += '</button>';
                            kontenhtml += '</td>';
                            kontenhtml += '</tr>';
                        }
                        $('#bodytabel').html(kontenhtml);
                    }

                }
            });

            $('#title-modal-detail').html(nama);
            $('#modalkontendetail').toggleClass("scale-0");
            $('#bgmodaldetail').addClass("effectmodal");

            $('#tambahButton').on('click', function() {

                addBarangBarang(id_pegawai);
            })

        }

        function addBarangBarang(id_pegawai) {
            setID(id_pegawai);
            $('#modalkontenaddbarang').removeClass("scale-0");
            $('#bgmodaladdbarang').addClass("effectmodal");

        }


        // load sidebar
        $("#ex-sidebar").load("../assets/components/sidebar.html", function() {
            $('#master_data').addClass("hover-sidebar");
            $('#button-logout').on('click', function() {
                // kosong
            });
        });

        function convertNameRolestoId(nameroles) {
            switch (nameroles) {
                case "Super Admin":
                    return "1";
                    break;
                case "Admin":
                    return "2";
                    break;
                case "Sales":
                    return "3";
                    break;
                default:
                    break;
            }
        }

        function convertIdRolesToName(idroles) {
            switch (idroles) {
                case "1":
                    return "Super Admin";
                    break;
                case "2":
                    return "Admin";
                    break;
                case "3":
                    return "Sales";
                    break;
                default:
                    break;
            }
        }

        $(document).ready(function() {

            $('#click-modal').on('click', function() {
                $('#title-modalpeg').html('Tambah Pegawai');
                $('#modalkonten').toggleClass("scale-0");
                $('#bgmodal').addClass("effectmodal");

                $('#footer-addpeg').removeClass('hidden');
                $('#footer-addpeg').addClass('flex');

                $('#footer-edit').removeClass('flex');
                $('#footer-edit').addClass('hidden');

                $('#form-password').addClass('hidden');
                $('#form-password').removeClass('flex');

                $('#form-modalpeg').addClass('flex');
                $('#form-modalpeg').removeClass('hidden');

                $("#txt_level").val("Sales");




            });

            <?php
            for ($index = 0; $index < count($execute); $index++) {
            ?>
                $('#edit-button-<?php echo $index; ?>').on('click', function() {
                    console.log('mphstt');
                    $('#footer-addpeg').removeClass('flex');
                    $('#footer-addpeg').addClass('hidden');

                    $('#footer-edit').removeClass('hidden');
                    $('#footer-edit').addClass('flex');

                    console.log("<?php echo $execute[$index]['nama']; ?>");

                    let getd = '<?php echo $execute[$index]['tgl_masuk']; ?>'.substring(8, 10);
                    let getm = '<?php echo $execute[$index]['tgl_masuk']; ?>'.substring(5, 7);
                    let gety = '<?php echo $execute[$index]['tgl_masuk']; ?>'.substring(0, 4);
                    console.log(gety + '-' + getm + '-' + getd);

                    $('#tglmasuk').val(gety + '-' + getm + '-' + getd);
                    $('#txt_email').val('<?php echo $execute[$index]['email']; ?>');
                    $('#txt_nama').val('<?php echo $execute[$index]['nama']; ?>');
                    $('#txt_gender').val('<?php echo $execute[$index]['gender']; ?>');
                    $('#txt_level').val(convertIdRolesToName('<?php echo $execute[$index]['id_level']; ?>'));
                    $('#txt_notelepon').val('<?php echo $execute[$index]['no.Telp']; ?>');
                    $('#txt_alamat').val('<?php echo $execute[$index]['alamat']; ?>');

                    $('#imgpreview_peg').removeClass('hidden');
                    $('#imgdefault_peg').addClass('hidden');
                    $('#imgpreview_peg').attr("src", '../images/pegawai/foto_pegawai/<?php echo $execute[$index]['foto_pegawai']; ?>');

                    imgpeg = '<?php echo $execute[$index]['foto_pegawai']; ?>';
                    console.log(imgpeg);

                    $('#imgpreview_ktp').removeClass('hidden');
                    $('#imgdefault_ktp').addClass('hidden');
                    $('#imgpreview_ktp').attr("src", '../images/pegawai/foto_ktp/<?php echo $execute[$index]['foto_ktp']; ?>');

                    $('#imgpreview_kk').removeClass('hidden');
                    $('#imgdefault_kk').addClass('hidden');
                    $('#imgpreview_kk').attr("src", '../images/pegawai/foto_kk/<?php echo $execute[$index]['foto_kk']; ?>');

                    lokasifotopegawai_lama = '<?php echo $execute[$index]['foto_pegawai']; ?>';
                    lokasifotoktp_lama = '<?php echo $execute[$index]['foto_ktp']; ?>';
                    lokasifotokk_lama = '<?php echo $execute[$index]['foto_kk']; ?>';
                    selected_idpegawai = '<?php echo $execute[$index]['id_pegawai']; ?>';

                    $('#field-password').addClass('hidden');
                    $('#title-modalpeg').html('Ubah Pegawai');

                    $('#modalkonten').toggleClass("scale-0");
                    $('#bgmodal').addClass("effectmodal");

                    $('#div-tgl').addClass('hidden');


                    $('#form-password').addClass('hidden');
                    $('#form-password').removeClass('flex');

                    $('#form-modalpeg').addClass('flex');
                    $('#form-modalpeg').removeClass('hidden');

                });
            <?php
            }
            ?>
        });

        function getFileExtension(fstring) {
            return fstring.slice((Math.max(0, fstring.lastIndexOf(".")) || Infinity) + 1);
        }

        let lokasifotopegawai_lama = "";
        let lokasifotoktp_lama = "";
        let lokasifotokk_lama = "";
        let selected_idpegawai = "";


        // load modal
        $("#modal-form").load("../assets/components/modal_master_pegawai.html", function() {

            if ('2' == '<?php echo $_SESSION['level'] ?>') {
                $("#divlevel").addClass("hidden");
            }

            $('#password-button').on('click', function() {
                $('#form-password').toggleClass('hidden');
                $('#form-password').toggleClass('flex');

                $('#form-password').toggleClass('statusclick');


                $('#form-modalpeg').toggleClass('flex');
                $('#form-modalpeg').toggleClass('hidden');

                console.log('awkoawk');
            });

            imgInp_peg.onchange = evt => {
                const [file] = imgInp_peg.files
                if (file) {
                    imgpreview_peg.src = URL.createObjectURL(file)
                    $('#imgpreview_peg').removeClass("hidden");
                    $('#imgdefault_peg').addClass("hidden");

                }
            }

            imgInp_ktp.onchange = evt => {
                const [file] = imgInp_ktp.files
                if (file) {
                    imgpreview_ktp.src = URL.createObjectURL(file)
                    $('#imgpreview_ktp').removeClass("hidden");
                    $('#imgdefault_ktp').addClass("hidden");
                }
            }

            imgInp_kk.onchange = evt => {
                const [file] = imgInp_kk.files
                if (file) {
                    imgpreview_kk.src = URL.createObjectURL(file)
                    $('#imgpreview_kk').removeClass("hidden");
                    $('#imgdefault_kk').addClass("hidden");
                }
            }
            $('#button-logout').on('click', function() {
                // kosong
            });

            $('#cancelmodal, #closemodal').on('click', function() {

                closeModal();

            });

            function closeModal() {
                $('#field-password').removeClass('hidden');
                $('#modalkonten').toggleClass("scale-0");
                $('#bgmodal').removeClass("effectmodal");


                $('#tglmasuk').val("");
                $('#txt_email').val("");
                $('#txt_password').val("");
                $('#txt_nama').val("");
                // $('#txt_gender').val("");
                $('#txt_notelepon').val("");
                $('#txt_alamat').val("");

                let lokasifotopegawai_lama = "";
                let lokasifotoktp_lama = "";
                let lokasifotokk_lama = "";
                let selected_idpegawai = "";

                $('#imgpreview_peg').addClass('hidden');
                $('#imgdefault_peg').removeClass('hidden');
                $('#imgpreview_peg').removeAttr("src");

                $('#imgpreview_ktp').addClass('hidden');
                $('#imgdefault_ktp').removeClass('hidden');
                $('#imgpreview_ktp').removeAttr("src");

                $('#div-tgl').removeClass('hidden');

                $('#imgpreview_kk').addClass('hidden');
                $('#imgdefault_kk').removeClass('hidden');
                $('#imgpreview_kk').removeAttr("src");
            }

            $(document).ready(function() {

                $('#submitform').on('click', function() {

                    if ($('#form-password').hasClass('statusclick')) {
                        if ($('#txt_newpassword').val() == "") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: "Password Tidak Boleh Kosong",
                            })
                        } else {
                            $.ajax({
                                url: '../controllers/pegawaiController.php',
                                type: 'post',
                                data: {
                                    'type': 'ubah_password_pegawai',
                                    'query': "UPDATE pegawai SET password = '" + CryptoJS.MD5($("#txt_newpassword").val()).toString() + "' WHERE id_pegawai = '" + selected_idpegawai + "'"
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
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: data.msg,

                                    }).then(function() {
                                        closeModal();
                                        window.location.replace("master_pegawai.php");

                                    });
                                }
                            });
                        }


                        console.log('form password');
                    } else {
                        var date = new Date($('#tglmasuk').val());
                        let form_editdata = new FormData();
                        let imgpeg = $("#imgInp_peg")[0].files;
                        let imgktp = $("#imgInp_ktp")[0].files;
                        let imgkk = $("#imgInp_kk")[0].files;

                        var query = "";

                        if (!imgpeg.length > 0 && !imgktp.length > 0 && !imgkk.length > 0) {
                            query = "UPDATE pegawai SET nama = '" + $('#txt_nama').val() + "', gender = '" + $('#txt_gender').val() + "', `no.Telp` = '" + $('#txt_notelepon').val() + "', alamat = '" + $('#txt_alamat').val() + "', tgl_masuk = '" + date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + "', email = '" + $('#txt_email').val() + "', id_level = '" + convertNameRolestoId($('#txt_level').val()) + "' WHERE id_pegawai = '" + selected_idpegawai + "'";
                            form_editdata.append('opsifoto', "tanpa-foto");
                        } else {
                            if (!imgpeg.length > 0 || !imgktp.length > 0 || !imgkk.length > 0) {
                                if (imgpeg.length > 0) {
                                    if (imgpeg.length > 0 && imgktp.length > 0) {
                                        form_editdata.append('image_peg', imgpeg[0]);
                                        form_editdata.append('image_ktp', imgktp[0]);

                                        var img_name_peg = form_editdata.get('image_peg')['name'];
                                        var img_name_ktp = form_editdata.get('image_ktp')['name'];

                                        var generateUniqPeg = "<?php echo uniqid("foto-pegawai-", true) . "." . '"+getFileExtension(img_name_peg)+"'; ?>";
                                        var generateUniqKTP = "<?php echo uniqid("foto-ktp-", true) . "." . '"+getFileExtension(img_name_ktp)+"'; ?>";


                                        query = "UPDATE pegawai SET nama = '" + $('#txt_nama').val() + "', gender = '" + $('#txt_gender').val() + "', `no.Telp` = '" + $('#txt_notelepon').val() + "', alamat = '" + $('#txt_alamat').val() + "', tgl_masuk = '" + date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + "', email = '" + $('#txt_email').val() + "', id_level = '" + convertNameRolestoId($('#txt_level').val()) + "', foto_pegawai = '<?= '"+generateUniqPeg+"'; ?>', foto_ktp = '<?= '"+generateUniqKTP+"'; ?>' WHERE id_pegawai = '" + selected_idpegawai + "'";
                                        form_editdata.append('opsifoto', "fotopegawai-dan-ktp");
                                    } else if (imgpeg.length > 0 && imgkk.length > 0) {
                                        form_editdata.append('image_peg', imgpeg[0]);
                                        form_editdata.append('image_kk', imgkk[0]);

                                        var img_name_peg = form_editdata.get('image_peg')['name'];
                                        var img_name_kk = form_editdata.get('image_kk')['name'];

                                        var generateUniqPeg = "<?php echo uniqid("foto-pegawai-", true) . "." . '"+getFileExtension(img_name_peg)+"'; ?>";
                                        var generateUniqKK = "<?php echo uniqid("foto-kk-", true) . "." . '"+getFileExtension(img_name_kk)+"'; ?>";

                                        query = "UPDATE pegawai SET nama = '" + $('#txt_nama').val() + "', gender = '" + $('#txt_gender').val() + "', `no.Telp` = '" + $('#txt_notelepon').val() + "', alamat = '" + $('#txt_alamat').val() + "', tgl_masuk = '" + date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + "', email = '" + $('#txt_email').val() + "', id_level = '" + convertNameRolestoId($('#txt_level').val()) + "', foto_pegawai = '<?= '"+generateUniqPeg+"'; ?>', foto_kk = '<?= '"+generateUniqKK+"'; ?>' WHERE id_pegawai = '" + selected_idpegawai + "'";
                                        form_editdata.append('opsifoto', "fotopegawai-dan-kk");
                                    } else {
                                        form_editdata.append('image_peg', imgpeg[0]);

                                        var img_name_peg = form_editdata.get('image_peg')['name'];

                                        var generateUniqPeg = "<?php echo uniqid("foto-pegawai-", true) . "." . '"+getFileExtension(img_name_peg)+"'; ?>";

                                        query = "UPDATE pegawai SET nama = '" + $('#txt_nama').val() + "', gender = '" + $('#txt_gender').val() + "', `no.Telp` = '" + $('#txt_notelepon').val() + "', alamat = '" + $('#txt_alamat').val() + "', tgl_masuk = '" + date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + "', email = '" + $('#txt_email').val() + "', id_level = '" + convertNameRolestoId($('#txt_level').val()) + "', foto_pegawai = '<?= '"+generateUniqPeg+"'; ?>' WHERE id_pegawai = '" + selected_idpegawai + "'";
                                        form_editdata.append('opsifoto', "fotopegawai");
                                    }
                                } else if (imgktp.length > 0) {
                                    if (imgktp.length > 0 && imgkk.length > 0) {
                                        form_editdata.append('image_ktp', imgktp[0]);
                                        form_editdata.append('image_kk', imgkk[0]);

                                        var img_name_ktp = form_editdata.get('image_ktp')['name'];
                                        var img_name_kk = form_editdata.get('image_kk')['name'];

                                        var generateUniqKTP = "<?php echo uniqid("foto-ktp-", true) . "." . '"+getFileExtension(img_name_ktp)+"'; ?>";
                                        var generateUniqKK = "<?php echo uniqid("foto-kk-", true) . "." . '"+getFileExtension(img_name_kk)+"'; ?>";

                                        query = "UPDATE pegawai SET nama = '" + $('#txt_nama').val() + "', gender = '" + $('#txt_gender').val() + "', `no.Telp` = '" + $('#txt_notelepon').val() + "', alamat = '" + $('#txt_alamat').val() + "', tgl_masuk = '" + date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + "', email = '" + $('#txt_email').val() + "', id_level = '" + convertNameRolestoId($('#txt_level').val()) + "', foto_ktp = '<?= '"+generateUniqKTP+"'; ?>', foto_kk = '<?= '"+generateUniqKK+"'; ?>' WHERE id_pegawai = '" + selected_idpegawai + "'";
                                        form_editdata.append('opsifoto', "fotoktp-dan-kk");
                                    } else {
                                        form_editdata.append('image_ktp', imgktp[0]);

                                        var img_name_ktp = form_editdata.get('image_ktp')['name'];

                                        var generateUniqKTP = "<?php echo uniqid("foto-ktp-", true) . "." . '"+getFileExtension(img_name_ktp)+"'; ?>";

                                        query = "UPDATE pegawai SET nama = '" + $('#txt_nama').val() + "', gender = '" + $('#txt_gender').val() + "', `no.Telp` = '" + $('#txt_notelepon').val() + "', alamat = '" + $('#txt_alamat').val() + "', tgl_masuk = '" + date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + "', email = '" + $('#txt_email').val() + "', id_level = '" + convertNameRolestoId($('#txt_level').val()) + "', foto_ktp = '<?= '"+generateUniqKTP+"'; ?>' WHERE id_pegawai = '" + selected_idpegawai + "'";
                                        form_editdata.append('opsifoto', "fotoktp");
                                    }
                                } else if (imgkk.length > 0) {
                                    form_editdata.append('image_kk', imgkk[0]);

                                    var img_name_kk = form_editdata.get('image_kk')['name'];

                                    var generateUniqKK = "<?php echo uniqid("foto-kk-", true) . "." . '"+getFileExtension(img_name_kk)+"'; ?>";

                                    query = "UPDATE pegawai SET nama = '" + $('#txt_nama').val() + "', gender = '" + $('#txt_gender').val() + "', `no.Telp` = '" + $('#txt_notelepon').val() + "', alamat = '" + $('#txt_alamat').val() + "', tgl_masuk = '" + date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + "', email = '" + $('#txt_email').val() + "', id_level = '" + convertNameRolestoId($('#txt_level').val()) + "', foto_kk = '<?= '"+generateUniqKK+"'; ?>' WHERE id_pegawai = '" + selected_idpegawai + "'";
                                    form_editdata.append('opsifoto', "fotokk");
                                }
                            } else {
                                form_editdata.append('image_peg', imgpeg[0]);
                                form_editdata.append('image_ktp', imgktp[0]);
                                form_editdata.append('image_kk', imgkk[0]);

                                var img_name_peg = form_editdata.get('image_peg')['name'];
                                var img_name_ktp = form_editdata.get('image_ktp')['name'];
                                var img_name_kk = form_editdata.get('image_kk')['name'];


                                var generateUniqPeg = "<?php echo uniqid("foto-pegawai-", true) . "." . '"+getFileExtension(img_name_peg)+"'; ?>";
                                var generateUniqKTP = "<?php echo uniqid("foto-ktp-", true) . "." . '"+getFileExtension(img_name_ktp)+"'; ?>";
                                var generateUniqKK = "<?php echo uniqid("foto-kk-", true) . "." . '"+getFileExtension(img_name_kk)+"'; ?>";

                                query = "UPDATE pegawai SET nama = '" + $('#txt_nama').val() + "', gender = '" + $('#txt_gender').val() + "', `no.Telp` = '" + $('#txt_notelepon').val() + "', alamat = '" + $('#txt_alamat').val() + "', tgl_masuk = '" + date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + "', email = '" + $('#txt_email').val() + "', id_level = '" + convertNameRolestoId($('#txt_level').val()) + "', foto_pegawai = '<?= '"+generateUniqPeg+"'; ?>', foto_ktp = '<?= '"+generateUniqKTP+"'; ?>', foto_kk = '<?= '"+generateUniqKK+"'; ?>' WHERE id_pegawai = '" + selected_idpegawai + "'";
                                form_editdata.append('opsifoto', "semua-foto");
                            }

                        }


                        form_editdata.append('query', query);

                        form_editdata.append('type', "ubah_pegawai");
                        form_editdata.append('img_file_peg', generateUniqPeg);
                        form_editdata.append('img_file_ktp', generateUniqKTP);
                        form_editdata.append('img_file_kk', generateUniqKK);
                        form_editdata.append('img_file_peg_old', lokasifotopegawai_lama);
                        form_editdata.append('img_file_ktp_old', lokasifotoktp_lama);
                        form_editdata.append('img_file_kk_old', lokasifotokk_lama);

                        if (!date.getDate()) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: "Tanggal Tidak Boleh Kosong",
                            })
                        } else if ($('#txt_email').val() == "") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: "Email Tidak Boleh Kosong",
                            })

                        } else if (!validasiEmail($('#txt_email').val())) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: "Email tidak valid",
                            })

                        } else if ($('#txt_nama').val() == "") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: "Nama Tidak Boleh Kosong",
                            })
                        } else if ($('#txt_gender').val() == null) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: "Gender Tidak Boleh Kosong",
                            })
                        } else if ($('#txt_notelepon').val() == "") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: "No Telepon Tidak Boleh Kosong",
                            })

                        } else if ($('#txt_alamat').val() == "") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: "Alamat Tidak Boleh Kosong",
                            })
                        } else {
                            $.ajax({
                                url: '../controllers/pegawaiController.php',
                                type: 'post',
                                data: form_editdata,

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
                                            closeModal();
                                            window.location.replace("master_pegawai.php");

                                        });
                                    }
                                }
                            });
                        }
                    }

                });

                function validasiEmail(email) {
                    var rs = email;
                    var atps = rs.indexOf("@");
                    var dots = rs.lastIndexOf(".");
                    if (atps < 1 || dots < atps + 2 || dots + 2 >= rs.length) {

                        return false;
                    } else {
                        return true;
                    }
                }


                $('#submitformadd').on('click', function(e) {
                    e.preventDefault();
                    //here
                    let form_data = new FormData();
                    let imgpeg = $("#imgInp_peg")[0].files;
                    let imgktp = $("#imgInp_ktp")[0].files;
                    let imgkk = $("#imgInp_kk")[0].files;

                    var date = new Date($('#tglmasuk').val());

                    if (!date.getDate()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: "Tanggal Tidak Boleh Kosong",
                        })
                    } else if ($('#txt_email').val() == "") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: "Email Tidak Boleh Kosong",
                        })

                    } else if (!validasiEmail($('#txt_email').val())) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: "Email tidak valid",
                        })

                    } else if ($('#txt_password').val() == "") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: "Password Tidak Boleh Kosong",
                        })
                        console.log($('#txt_password').val());
                    } else if ($('#txt_nama').val() == "") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: "Nama Tidak Boleh Kosong",
                        })
                    } else if ($('#txt_gender').val() == null) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: "Gender Tidak Boleh Kosong",
                        })
                    } else if ($('#txt_notelepon').val() == "") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: "No Telepon Tidak Boleh Kosong",
                        })

                    } else if ($('#txt_alamat').val() == "") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: "Alamat Tidak Boleh Kosong",
                        })
                    } else {
                        // Check image selected or not
                        if (imgpeg.length > 0 && imgktp.length > 0 && imgkk.length > 0) {
                            form_data.append('image_peg', imgpeg[0]);
                            form_data.append('image_ktp', imgktp[0]);
                            form_data.append('image_kk', imgkk[0]);
                            form_data.append('type', "tambah_pegawai");
                            var img_name_peg = form_data.get('image_peg')['name'];
                            var img_name_ktp = form_data.get('image_ktp')['name'];
                            var img_name_kk = form_data.get('image_kk')['name'];

                            var generateUniqPeg = "<?php echo uniqid("foto-pegawai-", true) . "." . '"+getFileExtension(img_name_peg)+"'; ?>";
                            var generateUniqKTP = "<?php echo uniqid("foto-ktp-", true) . "." . '"+getFileExtension(img_name_ktp)+"'; ?>";
                            var generateUniqKK = "<?php echo uniqid("foto-kk-", true) . "." . '"+getFileExtension(img_name_kk)+"'; ?>";

                            form_data.append('query', "INSERT INTO pegawai VALUES ('<?= generateID($crud, '"+ date.getDate() + + ( date.getMonth() + 1) + date.getFullYear()+"'); ?>', '" + $('#txt_nama').val() + "', '" + $('#txt_gender').val() + "', '" + $('#txt_notelepon').val() + "', '" + $('#txt_alamat').val() + "', '" + date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + "', '<?= '"+generateUniqPeg+"'; ?>', '<?= '"+generateUniqKTP+"'; ?>', '<?= '"+generateUniqKK+"'; ?>', '" + $('#txt_email').val() + "', '" + CryptoJS.MD5($("#txt_password").val()).toString() + "', '" + convertNameRolestoId($('#txt_level').val()) + "')");
                            form_data.append('img_file_peg', generateUniqPeg);
                            form_data.append('img_file_ktp', generateUniqKTP);
                            form_data.append('img_file_kk', generateUniqKK);
                            form_data.append('txt_email', $('#txt_email').val());


                            $.ajax({
                                url: '../controllers/pegawaiController.php',
                                type: 'post',
                                data: form_data,
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
                                            closeModal();
                                            window.location.replace("master_pegawai.php");
                                        });
                                    }

                                }
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Masukkan Gambar Terlebih Dahulu',

                            })
                        }
                    }
                });
            });
        });

        function hapusPegawai(id) {
            Swal.fire({
                title: 'Hapus Data',
                text: "Apakah anda yakin ingin menghapus?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../controllers/pegawaiController.php',
                        type: 'post',
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Loading',
                                html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
                                allowOutsideClick: false,
                                showConfirmButton: false,

                            });
                        },
                        data: {
                            'type': 'hapus_pegawai',
                            'query': "DELETE FROM pegawai WHERE id_pegawai = '" + selected_idpegawai + "'",
                            'pathfotopegawai': lokasifotopegawai_lama,
                            'pathfotoktp': lokasifotoktp_lama,
                            'pathfotokk': lokasifotokk_lama
                        },
                        success: function(res) {
                            alert(res);
                            const data = JSON.parse(res);
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.msg,
                            }).then(function() {
                                window.location.replace("master_pegawai.php");
                            });

                        }
                    });
                }
            })
        }


        // reset 
        var input = '<?= $input ?>';
        if (input !== "") {
            $('#btn_reset').removeClass('hidden');
            $('#btn_reset').addClass('flex');
            $('#btn_reset').on('click', function() {
                window.location.replace("master_pegawai.php");
            })
        }

        $('#search').keypress(function(e) {
            if (e.which == 13) {
                if ($('#search').val() == "") {
                    window.location.replace("master_pegawai.php");
                } else {

                    window.location.replace("master_pegawai.php?search=" + $('#search').val());
                }
            }
        });
    </script>


</body>

</html>
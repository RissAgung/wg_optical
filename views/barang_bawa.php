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

$jumlahData = (isset($_GET["search"])) ? count($crud->showData("SELECT * FROM pegawai WHERE nama LIKE'%" . $_GET["search"] . "%' AND id_level = '3' LIMIT 0, $jumlahDataPerHalaman")) : count($crud->showData("SELECT * FROM pegawai WHERE id_level = '3'"));
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$roles = 2;

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


    <!-- modal  -->
    <div id="modal-addBarang" class=""></div>
    <!-- end modal  -->

    <!-- modal detail -->
    <div id="modal-detail" class=""></div>
    <!-- end modal detail -->

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

                <h1>Barang Bawa</h1>
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
                            <th class="p-3 text-sm tracking-wide text-start">Nama</th>
                            <th class="p-3 text-sm tracking-wide text-center">ID Pegawai</th>
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
                                <td class="p-3 text-sm tracking-wide text-center">
                                    <button onclick="detailBarang('<?= $data['id_pegawai']; ?>', '<?= $data['nama']; ?>')">
                                        <svg width="38" height="37" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="25.36" height="25.36" rx="5" fill="#EDC683" />
                                            <path d="M11.7255 15.9349C11.7263 15.1391 11.9652 14.361 12.4124 13.6973C12.8596 13.0336 13.4954 12.5136 14.241 12.2017C14.9866 11.8899 15.809 11.8001 16.6061 11.9434C17.4032 12.0867 18.1398 12.4569 18.7246 13.0079V6.87375C18.7246 6.37654 18.5235 5.8997 18.1655 5.54812C17.8075 5.19654 17.322 4.99902 16.8157 4.99902H9.18041C8.33697 5.00002 7.52835 5.32953 6.93195 5.91528C6.33554 6.50103 6.00003 7.29519 5.99902 8.12357V16.8723C6.00003 17.7007 6.33554 18.4949 6.93195 19.0806C7.52835 19.6664 8.33697 19.9959 9.18041 19.9969H15.8613C14.7644 19.9969 13.7125 19.5689 12.9369 18.8071C12.1613 18.0454 11.7255 17.0122 11.7255 15.9349V15.9349ZM9.18041 9.37339C9.18041 9.20765 9.24745 9.04871 9.36677 8.93151C9.4861 8.81432 9.64794 8.74848 9.81669 8.74848H14.9069C15.0757 8.74848 15.2375 8.81432 15.3568 8.93151C15.4762 9.04871 15.5432 9.20765 15.5432 9.37339C15.5432 9.53913 15.4762 9.69808 15.3568 9.81527C15.2375 9.93246 15.0757 9.9983 14.9069 9.9983H9.81669C9.64794 9.9983 9.4861 9.93246 9.36677 9.81527C9.24745 9.69808 9.18041 9.53913 9.18041 9.37339ZM19.8107 19.8138C19.6914 19.9309 19.5296 19.9967 19.3609 19.9967C19.1921 19.9967 19.0303 19.9309 18.911 19.8138L17.3795 18.3096C16.9259 18.5939 16.3994 18.7456 15.8613 18.747C15.295 18.747 14.7415 18.5821 14.2706 18.2731C13.7997 17.9641 13.4327 17.5249 13.216 17.0111C12.9993 16.4972 12.9426 15.9318 13.0531 15.3863C13.1636 14.8408 13.4363 14.3398 13.8367 13.9465C14.2371 13.5532 14.7473 13.2854 15.3027 13.1769C15.8582 13.0684 16.4339 13.1241 16.957 13.3369C17.4802 13.5497 17.9274 13.9102 18.242 14.3726C18.5567 14.8351 18.7246 15.3788 18.7246 15.9349C18.7231 16.4634 18.5687 16.9805 18.2792 17.426L19.8107 18.9301C19.93 19.0473 19.997 19.2062 19.997 19.3719C19.997 19.5377 19.93 19.6966 19.8107 19.8138Z" fill="#51514F" />
                                        </svg>

                                    </button>
                                    <button onclick="addBarangBarang('<?php echo $data['id_pegawai']; ?>')">
                                        <svg width="39" height="37" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="25.36" height="25.36" rx="5" fill="#82DCC6" />
                                            <path d="M12.5 5C11.0166 5 9.56659 5.43987 8.33323 6.26398C7.09986 7.08809 6.13856 8.25943 5.57091 9.62987C5.00325 11.0003 4.85472 12.5083 5.14411 13.9632C5.4335 15.418 6.14781 16.7544 7.1967 17.8033C8.2456 18.8522 9.58197 19.5665 11.0368 19.8559C12.4917 20.1453 13.9997 19.9968 15.3701 19.4291C16.7406 18.8614 17.9119 17.9001 18.736 16.6668C19.5601 15.4334 20 13.9834 20 12.5C19.9979 10.5115 19.207 8.60513 17.8009 7.19907C16.3949 5.79302 14.4885 5.00215 12.5 5V5ZM15 13.125H13.125V15C13.125 15.1658 13.0592 15.3247 12.9419 15.4419C12.8247 15.5592 12.6658 15.625 12.5 15.625C12.3342 15.625 12.1753 15.5592 12.0581 15.4419C11.9409 15.3247 11.875 15.1658 11.875 15V13.125H10C9.83424 13.125 9.67527 13.0592 9.55806 12.9419C9.44085 12.8247 9.375 12.6658 9.375 12.5C9.375 12.3342 9.44085 12.1753 9.55806 12.0581C9.67527 11.9408 9.83424 11.875 10 11.875H11.875V10C11.875 9.83424 11.9409 9.67527 12.0581 9.55806C12.1753 9.44085 12.3342 9.375 12.5 9.375C12.6658 9.375 12.8247 9.44085 12.9419 9.55806C13.0592 9.67527 13.125 9.83424 13.125 10V11.875H15C15.1658 11.875 15.3247 11.9408 15.4419 12.0581C15.5592 12.1753 15.625 12.3342 15.625 12.5C15.625 12.6658 15.5592 12.8247 15.4419 12.9419C15.3247 13.0592 15.1658 13.125 15 13.125Z" fill="#073D2F" />
                                        </svg>


                                    </button>
                                </td>
                            </tr>

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





    <script>
        $(document).idle({
            onIdle: function() {
                $.ajax({
                    url: '../controllers/loginController.php',
                    type: 'post',
                    data: {
                        'type': 'logout',
                    },
                    success: function() {

                    }
                });
                Swal.fire({
                    icon: 'warning',
                    title: 'Informasi',
                    text: 'Sesi anda telah habis, silahkan login kembali',

                }).then(function() {
                    window.location.replace('../views/login.php');
                });

            },
            idle: 50000
        });

        $('#modal-addBarang').load("../assets/components/modal_pilih_barang.php", function() {

            $('#closemodal').on('click', function() {
                $('#modalkonten').toggleClass("scale-0");
                $('#bgmodal').removeClass("effectmodal");
            });
        });

        $('#modal-detail').load("../assets/components/modal_detail_barang_bawa.html", function() {
            $('#closemodaldetail, #okemodaldetali').on('click', function() {
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
                    $('#bodytabel').html("<div class='h-full w-full flex justify-center items-center'>Loading...</div>");
                },
                success: function(res) {
                    const value_utama = JSON.parse(res);
                    if (value_utama.length == 0) {
                        $('#no-data').addClass('flex');
                        $('#no-data').removeClass('hidden');
                        $('#bodytabel').html('');
                    } else {
                        for (let index = 0; index < value_utama.length; index++) {
                            const element = value_utama[index];
                            kontenhtml += '<tr>';
                            kontenhtml += '<td class="tracking-wide p-2 text-sm text-center">' + (index + 1) + '</td>';
                            kontenhtml += '<td class="tracking-wide p-2 text-sm text-center">' + element.id_bawa + '</td>';
                            kontenhtml += '<td class="tracking-wide p-2 text-sm text-center">' + element.merk + '</td>';
                            kontenhtml += '<td class="px-4">';
                            kontenhtml += '<button onClick="deleteDetailBawa(\'' + element.id_bawa + '\')">'
                            kontenhtml += '<svg width="22" height="22" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">';
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

        }

        function addBarangBarang(id_pegawai) {
            setID(id_pegawai);

            $('#modalkonten').toggleClass("scale-0");
            $('#bgmodal').addClass("effectmodal");


        }


        // load sidebar
        $("#ex-sidebar").load("../assets/components/sidebar.html", function() {
            $('#barang_bawa').addClass("hover-sidebar");
            $('#button-logout').on('click', function() {
                // kosong
            });

            
        });



        // auto hide sidebar

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
<?php

session_start();

if (!isset($_SESSION['statusLogin'])) {
    header('Location: login.php');
  } else if($_SESSION['level'] == 3 ){
    header('Location: ../sales/dashboard.php');
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary | WG Optical</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/apexcharts.css">
    <link rel="stylesheet" href="../css/sweetalert2.min.css">
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">


    <!-- modal detail -->
    <div id="modal-detail" class=""></div>
    <!-- end modal detail -->
    <!-- modal bonus -->
    <div id="modal-bonus" class=""></div>
    <!-- end modal bonus -->

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

                <h1>Salary</h1>
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

        <div class="mt-3 flex items-center flex-col md:flex-row md:justify-between md:px-14 lg:justify-between md:py-[3px]">
            <!-- Search -->
            <div class="flex flex-row shadow-sm rounded-md items-center bg-white box-border">
                <svg width="19" height="19" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-3">
                    <path d="M19.2502 19.25L15.138 15.1305M17.4168 9.62501C17.4168 11.6915 16.5959 13.6733 15.1347 15.1346C13.6735 16.5958 11.6916 17.4167 9.62516 17.4167C7.55868 17.4167 5.57684 16.5958 4.11562 15.1346C2.6544 13.6733 1.8335 11.6915 1.8335 9.62501C1.8335 7.55853 2.6544 5.57669 4.11562 4.11547C5.57684 2.65425 7.55868 1.83334 9.62516 1.83334C11.6916 1.83334 13.6735 2.65425 15.1347 4.11547C16.5959 5.57669 17.4168 7.55853 17.4168 9.62501V9.62501Z" stroke="#797E8D" stroke-width="2" stroke-linecap="round" />
                </svg>

                <input type="text" placeholder="Cari Sales" class="h-11 bg-transparent ml-2 outline-none" />
            </div>
            <!-- End Search -->
        </div>

        <!-- konten table -->
        <div class="" id="table">
            <!-- Table -->
            <div class="overflow-x-auto  text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 py-6 px-6 ex-table">
                <table class="w-full ">
                    <thead class="border-b-2 border-gray-100">
                        <tr>
                            <th class="p-3 text-sm tracking-wide text-center">Tanggal</th>
                            <th class="p-3 text-sm tracking-wide text-center">Sales</th>
                            <th class="p-3 text-sm tracking-wide text-center">Salery Final</th>
                            <th class="p-3 text-sm tracking-wide text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i  = 1;
                        while ($i < 20) {
                        ?>
                            <tr>
                                <td class="p-3 text-sm tracking-wide text-center ">01-20-2022</td>
                                <td class="p-3 text-sm tracking-wide text-center">Rizal Dwi Koryanto</td>
                                <td class="p-3 text-sm tracking-wide text-center">Salary Final</td>
                                <td class="p-3 text-sm tracking-wide text-center">
                                    <button id="add-bonus-<?php echo $i; ?>">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="40" height="40" rx="5" fill="#82DCC6" />
                                            <path d="M21.1487 11.9255C22.208 10.865 23.7058 9.17217 24.3058 7.5575C24.584 6.80967 24.0255 6 23.2727 6H16.7273C15.9745 6 15.416 6.8085 15.6942 7.5575C16.2942 9.17217 17.792 10.865 18.8513 11.9255C12.9844 12.8577 8 20.721 8 27C8 30.8605 10.9356 34 14.5455 34H25.4545C29.0644 34 32 30.8605 32 27C32 20.721 27.0156 12.8577 21.1487 11.9255V11.9255ZM18.5207 22.0545L21.8393 22.646C23.3022 22.9062 24.3647 24.2478 24.3647 25.8345C24.3647 27.7642 22.8964 29.3345 21.092 29.3345V30.5012C21.092 31.1452 20.6033 31.6678 20.0011 31.6678C19.3989 31.6678 18.9102 31.1452 18.9102 30.5012V29.3345H18.6178C17.4527 29.3345 16.3673 28.6648 15.7836 27.5857C15.4825 27.028 15.6604 26.3152 16.1818 25.992C16.7011 25.6688 17.3698 25.859 17.672 26.4178C17.8662 26.7772 18.2295 27.0012 18.6178 27.0012H21.092C21.6931 27.0012 22.1829 26.4773 22.1829 25.8345C22.1829 25.3935 21.8873 25.0202 21.4804 24.9478L18.1618 24.3563C16.6989 24.0962 15.6364 22.7545 15.6364 21.1678C15.6364 19.2382 17.1047 17.6678 18.9091 17.6678V16.5012C18.9091 15.8572 19.3978 15.3345 20 15.3345C20.6022 15.3345 21.0909 15.8572 21.0909 16.5012V17.6678H21.3833C22.5473 17.6678 23.6338 18.3387 24.2175 19.4178C24.5185 19.9755 24.3407 20.6883 23.8193 21.0115C23.2989 21.3347 22.6313 21.1445 22.3291 20.5857C22.1338 20.2252 21.7716 20.0023 21.3833 20.0023H18.9091C18.308 20.0023 17.8182 20.5262 17.8182 21.169C17.8182 21.61 18.1138 21.9833 18.5207 22.0557V22.0545Z" fill="#073D2F" />
                                        </svg>
                                    </button>
                                    <button id="detail-button-<?php echo $i; ?>">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="40" height="40" rx="5" fill="#EDC683" />
                                            <path d="M18.4947 25.1339C18.496 23.8785 18.8727 22.6513 19.5781 21.6044C20.2835 20.5576 21.2864 19.7373 22.4624 19.2455C23.6383 18.7537 24.9355 18.6121 26.1928 18.8381C27.45 19.0641 28.6119 19.648 29.5343 20.517V10.8418C29.5343 10.0575 29.2171 9.30539 28.6524 8.75085C28.0878 8.1963 27.322 7.88477 26.5235 7.88477L14.4804 7.88477C13.15 7.88633 11.8746 8.40606 10.9339 9.32996C9.99318 10.2539 9.464 11.5065 9.4624 12.8131V26.6123C9.464 27.9189 9.99318 29.1716 10.9339 30.0955C11.8746 31.0194 13.15 31.5391 14.4804 31.5407H25.0181C23.288 31.5407 21.6287 30.8657 20.4054 29.6641C19.182 28.4626 18.4947 26.833 18.4947 25.1339ZM14.4804 14.7844C14.4804 14.523 14.5861 14.2723 14.7743 14.0874C14.9625 13.9026 15.2178 13.7987 15.484 13.7987H23.5127C23.7789 13.7987 24.0341 13.9026 24.2223 14.0874C24.4106 14.2723 24.5163 14.523 24.5163 14.7844C24.5163 15.0458 24.4106 15.2965 24.2223 15.4814C24.0341 15.6662 23.7789 15.7701 23.5127 15.7701H15.484C15.2178 15.7701 14.9625 15.6662 14.7743 15.4814C14.5861 15.2965 14.4804 15.0458 14.4804 14.7844ZM31.2474 31.2519C31.0592 31.4366 30.804 31.5404 30.5378 31.5404C30.2717 31.5404 30.0165 31.4366 29.8283 31.2519L27.4127 28.8794C26.6973 29.3278 25.8668 29.5671 25.0181 29.5693C24.1249 29.5693 23.2517 29.3092 22.509 28.8218C21.7664 28.3344 21.1875 27.6417 20.8457 26.8312C20.5039 26.0208 20.4144 25.1289 20.5887 24.2685C20.763 23.4081 21.1931 22.6178 21.8247 21.9975C22.4563 21.3772 23.261 20.9547 24.137 20.7836C25.0131 20.6125 25.9211 20.7003 26.7464 21.036C27.5716 21.3717 28.2769 21.9402 28.7731 22.6696C29.2694 23.399 29.5343 24.2566 29.5343 25.1339C29.532 25.9674 29.2883 26.783 28.8317 27.4856L31.2474 29.8581C31.4355 30.043 31.5412 30.2936 31.5412 30.555C31.5412 30.8164 31.4355 31.067 31.2474 31.2519Z" fill="#51514F" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Pagination And Info Data -->
            <div class="flex flex-col-reverse md:flex-row lg:flex-row lg:justify-between md:justify-between lg:px-14 lg:mt-5 items-center mt-3 text-sm">
                <div class="flex flex-row mb-3 font-ex-semibold">
                    <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white drop-shadow-md">
                        <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 0.748694C7.99976 0.947765 7.89284 1.13862 7.70275 1.2793L2.51977 5.11966C2.36289 5.23587 2.23845 5.37384 2.15354 5.52569C2.06864 5.67754 2.02494 5.84029 2.02494 6.00466C2.02494 6.16903 2.06864 6.33178 2.15354 6.48363C2.23845 6.63549 2.36289 6.77346 2.51977 6.88967L7.69599 10.7275C7.88058 10.8691 7.98272 11.0588 7.98042 11.2557C7.97811 11.4525 7.87153 11.6409 7.68365 11.7801C7.49576 11.9193 7.2416 11.9983 6.9759 12C6.71021 12.0017 6.45423 11.926 6.26311 11.7892L1.08689 7.95437C0.390892 7.43766 4.76837e-07 6.73745 4.76837e-07 6.00741C4.76837e-07 5.27738 0.390892 4.57717 1.08689 4.06045L6.26986 0.220095C6.41138 0.115167 6.59168 0.0436506 6.78799 0.0145702C6.98431 -0.0145102 7.18786 0.000148773 7.37294 0.0566969C7.55803 0.113245 7.71636 0.209149 7.82796 0.332306C7.93956 0.455462 7.99942 0.600353 8 0.748694Z" fill="#343948" />
                        </svg>
                    </div>
                    <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white drop-shadow-md">2</div>
                    <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white drop-shadow-md">3</div>
                    <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white drop-shadow-md">4</div>
                    <div class="flex justify-center items-center h-10 w-10 mr-2 rounded-sm bg-white drop-shadow-md">
                        <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 11.2513C0.00023652 11.0522 0.107156 10.8614 0.297251 10.7207L5.48023 6.88034C5.63711 6.76413 5.76155 6.62616 5.84646 6.47431C5.93136 6.32246 5.97506 6.15971 5.97506 5.99534C5.97506 5.83097 5.93136 5.66822 5.84646 5.51637C5.76155 5.36451 5.63711 5.22654 5.48023 5.11033L0.304007 1.27248C0.119416 1.13087 0.0172752 0.941199 0.019584 0.744328C0.0218929 0.547457 0.128467 0.359134 0.316351 0.21992C0.504235 0.0807055 0.758398 0.00173914 1.0241 2.83842e-05C1.28979 -0.00168237 1.54577 0.0739993 1.73689 0.210773L6.91311 4.04563C7.60911 4.56234 8 5.26255 8 5.99259C8 6.72262 7.60911 7.42283 6.91311 7.93955L1.73014 11.7799C1.58862 11.8848 1.40832 11.9563 1.21201 11.9854C1.01569 12.0145 0.812142 11.9999 0.627057 11.9433C0.441971 11.8868 0.283639 11.7909 0.17204 11.6677C0.0604405 11.5445 0.000575787 11.3996 0 11.2513Z" fill="#343948" />
                        </svg>
                    </div>
                </div>
                <div class="mb-3">20 from 120 data</div>
            </div>
            <!-- End Pagination And Info Data -->
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
        // load sidebar
        $("#ex-sidebar").load("../assets/components/sidebar.html", function() {
            $('#salary').addClass("hover-sidebar");
            
        });

        $("#modal-detail").load("../assets/components/modal_detail_salary.html", function() {
            for (var index = 1; index < 20; index++) {
                $("#detail-button-" + index).on('click', function() {
                    $('#modalkonten').toggleClass("scale-100");
                    $('#bgmodal').addClass("effectmodal");
                });
            }
            $('#closemodal').on('click', function() {
                $('#modalkonten').toggleClass("scale-100");
                $('#bgmodal').removeClass("effectmodal");
            });
        });


        $("#modal-bonus").load("../assets/components/modal_bonus_gaji.html", function() {
            for (var index = 1; index < 20; index++) {
                $("#add-bonus-" + index).on('click', function() {
                    $('#modalkontenbonus').toggleClass("scale-100");
                    $('#bgmodalbonus').addClass("effectmodal");
                });
            }
            $('#closemodalbonus').on('click', function() {
                $('#modalkontenbonus').toggleClass("scale-100");
                $('#bgmodalbonus').removeClass("effectmodal");
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

        $('#click-modal').on('click', function() {
            $('#title-modal').html('Tambah Pegawai');
            $('#modalkonten').toggleClass("scale-100");
            $('#bgmodal').addClass("effectmodal");
        });

        $('#closemodal').on('click', function() {

            $('#modalkonten').toggleClass("scale-100");
            $('#bgmodal').removeClass("effectmodal");
        });
    </script>


</body>

</html>
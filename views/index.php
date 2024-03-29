<?php
date_default_timezone_set("Asia/Bangkok");
include "../config/koneksi.php";
$crud = new koneksi();

$dataDb = $crud->showData("SELECT * FROM content_landing");
$imbDb = $crud->showData("SELECT * FROM image_landing");
$imgFrame = $crud->showData("SELECT merk, gambar FROM produk LIMIT 6");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/swiper-bundle.min.css">
    <link rel="icon" type="image/x-icon" href="../assets/images/wgLogo.png">

    <title>WG Optical</title>
</head>

<body class="bg-[#171A23]">
    <div class="flex flex-col h-screen justify-between">
        <section id="navbar">
            <header class="">
                <div class="w-full z-[9999] fixed bg-[#171A23]">
                    <div class="flex justify-between px-12 my-6 relative">
                        <a href="index.php"><span class="text-white">WG <span class="font-bold">Optical</span></span></a>

                        <button name="menuu" id="menuu" type="button" class="flex flex-col md:hidden">
                            <span class="menu-line transition duration-500 ease-in-out origin-bottom-left"></span>
                            <span class="menu-line transition duration-500 ease-in-out"></span>
                            <span class="menu-line transition duration-500 ease-in-out origin-top-left"></span>
                        </button>

                        <nav id="showmenu" class="absolute top-14 right-8 px-4 py-5 bg-[#171A23] border-2 rounded-lg shadow-lg md:shadow-none max-w-[250px] w-full hidden md:py-0 md:w-3/4 md:block md:max-w-full md:static md:border-none md:bg-transparent">
                            <ul class="block md:flex md:gap-4 md:justify-end">
                                <li class="group">
                                    <a href="login.php"><button class="text-white font-semibold px-4 py-2 hover:bg-slate-700 hover:rounded-lg">Login</button></a>
                                </li>
                                <li class="group">
                                    <a href="tracking.html"><button class="text-white font-semibold px-4 py-2 hover:bg-slate-700 hover:rounded-lg">Cari</button></a>
                                </li>
                                <li class="group">
                                    <a href="index.php"><button class="py-2 font-semibold px-4 bg-transparent text-white md:bg-white md:text-black md:rounded-lg">Home</button></a>
                                </li>
                            </ul>

                        </nav>

                    </div>
                </div>
            </header>
        </section>

        <section id="hero_section" class="">
            <div class="mx-auto bg-[#171A23] w-full">
                <div class="flex flex-wrap">
                    <div class="w-full pt-40 px-12 md:w-1/2 md:pb-44 lg:mb-32 md:pl-12 lg:pl-28">
                        <p class="text-6xl md:text-4xl lg:text-6xl text-white font-bold"><?= $dataDb[0]["header"] ?></p>
                        <p class="text-sm lg:text-xl pt-6 font-semibold text-white font-base"><?= $dataDb[0]["description"] ?></p>


                        <div class="flex flex-wrap py-6 gap-3">
                            <a href="login.php">
                                <button class="px-4 py-2 bg-white rounded-lg border-2 hover:bg-slate-300">
                                    <p class="text-slate-900 text-sm lg:text-xl font-semibold">Masuk</p>
                                </button>
                            </a>
                            <a href="tracking.html">
                                <button class="px-4 py-2 bg-slate-800 rounded-lg border-2 hover:bg-slate-600">
                                    <p class="text-white text-sm lg:text-xl font-semibold">Lacak</p>
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="w-full pt-12 px-12 md:pl-6 pb-32 md:w-1/2 md:pt-40 lg:pt-40 lg:pl-16">

                        <div class="w-[87%] md:w-[80%] lg:w-[80%] h-[300px] rounded-xl overflow-hidden shadow-xl swiper one">
                            <div class="swiper-wrapper">
                                <?php foreach ($imbDb as $index) : ?>
                                    <img class="w-full object-cover swiper-slide z-[22]" src="../images/landing/<?= $index['img'] ?>" alt="image_hero">
                                <?php endforeach ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section id="product_section" class="bg-white">

            <h1 class="text-4xl text-center font-bold py-12 px-12">Our Product</h1>
            <div class="w-full md:w-[80%] lg:w-3/4 mx-auto justify-center items-center relative">
                <!-- Slider main container -->
                <div class="swiper two mb-12">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper card-wrapper mb-8">
                        <!-- Slides -->
                        <?php foreach ($imgFrame as $index) : ?>
                            <div class="swiper-slide content-center">
                                <div class="flex flex-wrap gap-6 justify-center m-auto pb-10 w-60">
                                    <div class="object-center overflow-hidden rounded-2xl w-[240px] h-[160px]">
                                        <img class="w-[240px] h-[160px] object-cover" src="../images/produk/<?= $index["gambar"] ?>" alt="catalog">
                                    </div>
                                    <h2 class="text-center text-3xl font-bold py-4"><?= $index["merk"] ?></h2>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <!-- If we need pagination -->

                    <div class="swiper-pagination"></div>
                </div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev product pl-6 btn-prev md:-translate-x-20 lg:-translate-x-24"></div>
                <div class="swiper-button-next product pr-6 btn-next md:translate-x-28 lg:translate-x-24"></div>
            </div>

        </section>

        <!-- hero -->

        <section id="product_section" class="bg-[#171A23]">

            <h1 class="text-4xl text-center font-bold py-12 px-12 text-white">OUR LENS</h1>
            <div class="w-full md:w-[80%] lg:w-3/4 mx-auto justify-center items-center relative">
                <!-- Slider main container -->
                <div class="swiper three mb-12">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper card-wrapper mb-8">
                        <!-- Slides -->
                        <div class="swiper-slide content-center">
                            <div class="flex flex-col justify-center">
                                <div class="w-full h-full px-10">
                                    <div class="h-[300px] w-full rounded-xl overflow-hidden">
                                        <img src="../assets/images/progresive.png" class="h-[300px] w-full object-cover" alt="progressive">
                                    </div>
                                </div>
                                <div class="flex items-center justify-center pt-8">
                                    <h1 class="text-white font-bold text-2xl">PROGRESSIVE LENS</h1>
                                </div>
                                <div class="flex items-center justify-center py-4 px-[30px]">
                                    <h1 class="text-white font-bold text-center">Lensa ini juga memiliki dua titik
                                        fokus, bedanya lensa progresif tidak memiliki jarak atau garis pembatas pada
                                        titik fokus untuk melihat jarak jauh dan titik fokus untuk melihat jarak dekat.
                                        Selain itu, lensa ini dilengkapi dengan titik fokus yang berkemampun untuk
                                        melihat jarak sedang sehingga lebih nyaman. Lensa Progresif bisa
                                        dibilang lensa trifokal.</h1>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide content-center">
                            <div class="flex flex-col justify-center">
                                <div class="w-full h-full px-10">
                                    <div class="h-[300px] w-full rounded-xl overflow-hidden">
                                        <img src="../assets/images/single_vision.png" class="h-[300px] w-full object-cover" alt="progressive">
                                    </div>
                                </div>
                                <div class="flex items-center justify-center pt-8">
                                    <h1 class="text-white font-bold text-2xl">SINGLE VISION</h1>
                                </div>
                                <div class="flex items-center justify-center py-4 px-[30px]">
                                    <h1 class="text-white font-bold text-center">Dinamakan Single Vision karena hanya memiliki satu titik fokus.
                                        Lensa tunggal digunakan untuk kacamata miopi (negatif) ataupun hipermetropi (positif),
                                        atau astigmatisma (silindris).</h1>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- If we need pagination -->

                    <div class="swiper-pagination"></div>
                </div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev lens paksa-putih pl-6 btn-prev md:-translate-x-20 lg:-translate-x-24">
                </div>
                <div class="swiper-button-next lens paksa-putih pr-6 btn-next md:translate-x-28 lg:translate-x-24">
                </div>
            </div>

        </section>



        <!--end hero-->

        <section id="footer">
            <footer>
                <div class="w-full h-auto bg-[#171A23]">
                    <div class=" mx-auto flex flex-col items-center justify-center py-12 px-9">
                        <h1 class="text-white font-bold text-xl">WG Optical</h1>

                        <div class="flex gap-4 py-12">
                            <div class="w-14 h-14 bg-[#333A4E] rounded-full relative">
                                <svg class="absolute scale-50 fill-white" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <title>Instagram</title>
                                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                                </svg>
                            </div>
                            <div class="w-14 h-14 bg-[#333A4E] rounded-full relative">
                                <svg class="absolute scale-50 fill-white" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <title>Facebook</title>
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </div>
                            <div class="w-14 h-14 bg-[#333A4E] rounded-full relative">
                                <svg class="absolute scale-50 fill-white" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <title>WhatsApp</title>
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.75<svg class=" absolute scale-50 fill-white" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <title>Instagram</title>
                                        <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                                </svg>
                                </svg>
                            </div>
                        </div>

                        <h1 class="text-white font-base text-center">Copyright @2022 <span class="text-white font-bold">WG Optical</span> IT Team. All Right Reserved</h1>

                    </div>
                </div>
            </footer>
        </section>

    </div>

    <script src="../js/swiper-bundle.min.js"></script>
    <script src="../js/script.js"></script>

</body>

</html>
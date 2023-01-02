<?php
include '../../config/koneksi.php';

session_start();

$select = new Koneksi();

$data = $select->showData("SELECT produk.kode_frame, produk.merk, produk.stock, COUNT(detail_bawa.Id_Bawa) as detailTerbawa FROM detail_bawa RIGHT JOIN produk ON produk.kode_frame = detail_bawa.Kode_Frame GROUP BY produk.kode_frame");


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Pegawai</title>
    <link rel="stylesheet" href="../../../css/output.css">
</head>

<body class=" bg-slate-600 text-[#343948] font-ex-medium">
    <!-- Modal -->
    <!-- Background -->
    <div id="bgmodaladdbarang" class="hidden w-full h-screen fixed  bg-black z-[51] opacity-0 transition duration-300"></div>
    <!-- konten modal-->
    <div id="modalkontenaddbarang" class=" bg-white fixed z-[51] left-[50%] top-[50%] -translate-y-[50%] -translate-x-[50%] shadow-xl rounded-lg scale-0 transition ease-in-out">
        <div class="header relative">
            <div onclick="backPilih()" id="back" class="hidden absolute fill-black left-5 top-5 cursor-pointer text-center my-auto rounded-md transition">
                <svg width="9" height="19" viewBox="0 0 9 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 1.18543C8.99973 1.50063 8.87945 1.80281 8.66559 2.02555L2.83474 8.10612C2.65826 8.29012 2.51825 8.50857 2.42274 8.749C2.32722 8.98943 2.27806 9.24713 2.27806 9.50738C2.27806 9.76763 2.32722 10.0253 2.42274 10.2658C2.51825 10.5062 2.65826 10.7246 2.83474 10.9086L8.65799 16.9852C8.86566 17.2095 8.98057 17.5098 8.97797 17.8215C8.97537 18.1332 8.85548 18.4314 8.64411 18.6518C8.43274 18.8722 8.1468 18.9972 7.84789 19C7.54898 19.0027 7.26101 18.8828 7.046 18.6663L1.22275 12.5944C0.439753 11.7763 9.53674e-07 10.6676 9.53674e-07 9.51174C9.53674e-07 8.35585 0.439753 7.24719 1.22275 6.42905L7.0536 0.348482C7.21281 0.182346 7.41564 0.0691128 7.63649 0.0230694C7.85735 -0.022974 8.08634 0.000234604 8.29456 0.0897694C8.50278 0.179304 8.68091 0.331152 8.80646 0.526152C8.932 0.721149 8.99935 0.95056 9 1.18543Z" fill="black" />
                </svg>

            </div>
            <h1 id="title-modal" class=" font-ex-bold px-8 py-4 text-lg text-[#343948] text-center">Pilih Frame</h1>
            <div class="h-[1px] bg-[#C9C9C9]"></div>
            <div id="closemodaladdbarang" class="absolute right-5 top-5 cursor-pointer flex text-center my-auto rounded-md transition">
                <svg id="btn_out" class="cursor-pointer" width="15" height="15" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.3289 5.47926L10.6264 2.18142C10.8405 1.93831 10.9539 1.62288 10.9436 1.29924C10.9332 0.975599 10.7999 0.668037 10.5707 0.439072C10.3415 0.210106 10.0337 0.0769213 9.70976 0.0665883C9.38581 0.0562553 9.07009 0.16955 8.82676 0.383443L5.52586 3.67789L2.21901 0.373252C2.10056 0.254916 1.95995 0.161048 1.80519 0.097005C1.65044 0.0329623 1.48457 1.24687e-09 1.31706 0C1.14956 -1.24687e-09 0.983689 0.0329623 0.828933 0.097005C0.674177 0.161048 0.533562 0.254916 0.415117 0.373252C0.296672 0.491587 0.202716 0.632072 0.138614 0.786685C0.0745119 0.941298 0.041519 1.10701 0.041519 1.27436C0.041519 1.44171 0.0745119 1.60743 0.138614 1.76204C0.202716 1.91665 0.296672 2.05714 0.415117 2.17547L3.72282 5.47926L0.425318 8.77625C0.295996 8.89175 0.19162 9.03239 0.118574 9.18957C0.0455293 9.34676 0.00535166 9.51718 0.000499102 9.69041C-0.00435345 9.86364 0.0262212 10.036 0.0903528 10.1971C0.154484 10.3581 0.250824 10.5043 0.373478 10.6269C0.496133 10.7494 0.642522 10.8457 0.80369 10.9097C0.964858 10.9738 1.13742 11.0043 1.31081 10.9995C1.4842 10.9947 1.65478 10.9545 1.81211 10.8815C1.96944 10.8086 2.11021 10.7043 2.22581 10.5751L5.52586 7.28063L8.82251 10.5751C9.06172 10.8141 9.38616 10.9483 9.72446 10.9483C10.0628 10.9483 10.3872 10.8141 10.6264 10.5751C10.8656 10.3361 11 10.0119 11 9.67396C11 9.33598 10.8656 9.01184 10.6264 8.77286L7.3289 5.47926Z" fill="#343948" />
                </svg>
            </div>
        </div>

        <!-- <div id="jumlah-frame" class="hidden">
            <div class="" id="konten-jumlah">
                
            </div>
            <div id="footer-modal" class="mt-4">
                <div class="h-[1px] bg-[#C9C9C9]"></div>
                <div id="footer-add" class="flex flex-row gap-4 justify-center py-4 text-center items-center">
                    <div onclick="testlagi()" id="subm" class="cursor-pointer bg-[#1C8066] text-center rounded-md py-2 px-2 text-white text-sm sm:text-lg">
                        <p class="cursor-pointer">Next</p>
                    </div>
                </div>
            </div>
        </div> -->

        <div id="pilih-frame" class="w-[90vw] md:w-[60vw] lg:w-[40vw]">
            <form action="../assets/components/detail_bawa/modal_jumlah_barang.php" method="POST">
                <input type="hidden" name="id_pegawai" id="input_id_pegawai">
                <div id="form-modal" class="flex flex-col overflow-y-hidden h-[60vh] pb-8">
                    <div class="flex flex-col gap-4 flex-wrap justify-start items-start mt-6 scrollbar overflow-y-hidden px-4">
                        <?php foreach ($data as $value) : ?>
                            <?php if ($value['detailTerbawa'] >= $value['stock']) : ?>
                                <!-- kosong -->
                            <?php else : ?>
                                <div class="flex flex-row p-4 w-32 gap-4">
                                    <input onclick="test('<?= $value['kode_frame']; ?>', '<?= $value['stock']; ?>', '<?= $value['detailTerbawa']; ?>', '<?= $value['merk']; ?>')" class="flex items-center" type="checkbox" name="select-<?= $value["kode_frame"] ?>" id="select-<?= $value["kode_frame"] ?>">
                                    <label for="select-<?= $value["kode_frame"] ?>"><?= $value["merk"] ?></label>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </div>

                <div id="footer-modal" class="mt-4">
                    <div class="h-[1px] bg-[#C9C9C9]"></div>
                    <div id="footer-add" class="flex flex-row gap-4 justify-center py-4 text-center items-center">
                        <button onclick="nextJumlah()" type="button" id="next" class="cursor-pointer bg-[#1C8066] text-center rounded-md py-2 px-2 text-white text-sm sm:text-lg">
                            <p class="cursor-pointer">Next</p>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- pilih jumlah -->
        <div id="form-frame" class="flex-col overflow-y-hidden h-[60vh] pb-8 hidden">

            <!-- ini itu  -->
        </div>
        <div id="footer-modal-submit" class="hidden mt-4">
            <div class="h-[1px] bg-[#C9C9C9]"></div>
            <div id="footer-add" class="flex flex-row gap-4 justify-center py-4 text-center items-center">
                <button onclick="submitForm()" type="button" id="next" class="cursor-pointer bg-[#1C8066] text-center rounded-md py-2 px-2 text-white text-sm sm:text-lg">
                    <p class="cursor-pointer">Submit</p>
                </button>
            </div>
        </div>
    </div>

    <!-- end modal -->

    <script>
        function submitForm() {
            var app = new FormData();


            for (let index = 0; index < saveD.length; index++) {


                app.append('data-' + index, JSON.stringify({
                    'kode': saveD[index]['kode'],
                    'jumlah': $("#value-" + saveD[index]['kode']).html(),
                    'pegawai': peg,
                }));

            }


            $.ajax({
                url: "../controllers/detailbawaController.php",
                type: "post",
                data: app,
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
                    // alert(res);
                    // console.log(res);
                    const data = JSON.parse(res);
                    if (data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.msg,
                        }).then(function() {
                            window.location.reload();
                        });
                    }

                }
            })

        }

        function nextJumlah() {
            if (saveD.length == 0) {
                // pilih dulu
            } else {

                $('#pilih-frame').addClass('hidden');
                $('#form-frame').removeClass('hidden');
                $('#back').removeClass('hidden');

                $('#footer-modal').addClass('hidden');
                $('#footer-modal-submit').removeClass('hidden');

                for (let index = 0; index < saveD.length; index++) {

                    var stock = saveD[index]['stock'];
                    var kode = saveD[index]['kode'];
                    var terbawa = saveD[index]['terbawa'];

                    var html_pilihJumlah = '<div class="flex flex-row justify-between px-8 h-16 items-center w-[300px]">';
                    html_pilihJumlah += '<p class="text-lg">' + saveD[index]['merk'] + '</p>';
                    html_pilihJumlah += '<div class="flex flex-row gap-4">';
                    html_pilihJumlah += '<button onclick="kurang(\'' + stock + '\', \'' + kode + '\')" type="button">'
                    html_pilihJumlah += '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">'
                    html_pilihJumlah += '<circle cx="9" cy="9" r="9" fill="#343948" />'
                    html_pilihJumlah += '<rect x="4" y="10" width="2" height="10" rx="1" transform="rotate(-90 4 10)" fill="white" />'
                    html_pilihJumlah += '</svg>'
                    html_pilihJumlah += '</button>'
                    html_pilihJumlah += '<h1 id="value-' + saveD[index]['kode'] + '">1</h1>'
                    html_pilihJumlah += '<button onclick="tambah(\'' + stock + '\', \'' + kode + '\', \'' + terbawa + '\')" type="button">'
                    html_pilihJumlah += '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">'
                    html_pilihJumlah += '<circle cx="9" cy="9" r="9" fill="#343948" />'
                    html_pilihJumlah += '<path d="M8.25684 4.33105C8.09717 4.50781 8 4.74219 8 5V8H5C4.44775 8 4 8.44727 4 9C4 9.55273 4.44775 10 5 10H8V13C8 13.2393 8.0835 13.458 8.22314 13.6299C8.40674 13.8555 8.68652 14 9 14C9.55225 14 10 13.5527 10 13V10H13C13.5522 10 14 9.55273 14 9C14 8.44727 13.5522 8 13 8H10V5C10 4.44727 9.55225 4 9 4C8.70508 4 8.43994 4.12793 8.25684 4.33105Z" fill="white" />'
                    html_pilihJumlah += '</svg>'
                    html_pilihJumlah += '</button>'
                    html_pilihJumlah += '</div>'
                    html_pilihJumlah += '</div>'

                    console.log(html_pilihJumlah);

                    $('#form-frame').append(html_pilihJumlah);


                }

            }


        }

        function backPilih() {
            $('#pilih-frame').removeClass('hidden');
            $('#form-frame').addClass('hidden');
            $('#back').addClass('hidden');

            $('#form-frame').html('');
            saveD = [];
            $('input[type="checkbox"]').prop('checked', false);

            $('#footer-modal').removeClass('hidden');
            $('#footer-modal-submit').addClass('hidden');
        }

        var peg;

        function setID(id_peg) {
            console.log(id_peg);
            peg = id_peg;

        }

        let saveData = new FormData();
        let saveD = [];

        function testlagi() {
            alert(saveD);
        }

        function tambah(stok, kode, terbawa) {

            if ($('#value-' + kode).html() < (stok - terbawa)) {
                var nilai = parseInt($('#value-' + kode).html()) + 1;

                $('#value-' + kode).html(nilai);
                //  console.log($('#value-' + kode).html());
            }
        }

        function kurang(stok, kode) {
            if ($('#value-' + kode).html() > 1) {
                var nilai = parseInt($('#value-' + kode).html()) - 1;

                $('#value-' + kode).html(nilai);
                // console.log($('#value-' + kode).html());
            }

        }

        function test(kode, stock, terbawa, merk) {
            if ($('#select-' + kode).is(":checked")) {
                saveD.push({
                    kode: kode,
                    stock: stock,
                    terbawa: terbawa,
                    merk: merk
                });
                console.log(saveD);

            } else {
                for (let index = 0; index < saveD.length; index++) {
                    const element = saveD[index];
                    if (element['kode'] == kode) {
                        removeItemOnce(saveD, element);
                    }
                }
                console.log(saveD);
            }
            // console.log(saveD);
        }

        function removeItemOnce(arr, value) {
            var index = arr.indexOf(value);
            if (index > -1) {
                arr.splice(index, 1);
            }
            return arr;
        }

        function next() {
            console.log(saveD);

        }

        function back() {
            $('#jumlah-frame').addClass('hidden');
            $('#pilih-frame').removeClass('hidden');

            $('#back').addClass('hidden');
        }

        // 
    </script>
</body>



</html>
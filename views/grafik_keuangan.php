<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafk Keuangan | WG Optical</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/apexcharts.css">
    <link rel="stylesheet" href="../css/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/datePicker.css">
    <link rel="stylesheet" href="../css/daterangepicker.css">
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">
    <div id="loading" class="fixed w-full h-full top-0 left-0 flex flex-col justify-center items-center bg-slate-50 z-[99]">
        <div class="loadingspinner"></div>
    </div>
    <!-- modal detail -->
    <div id="modal_filter_date" class=""></div>
    <!-- end modal detail -->

    <!-- Background hitam saat sidebar show -->
    <div id="bgbody" class="w-full h-screen bg-black fixed z-50 bg-opacity-50 hidden"></div>
    <!-- End Background hitam saat sidebar show -->

    <!-- sidebar -->
    <div id="ex-sidebar" class="ex-sidebar ex-hide-sidebar fixed z-50 max-lg:transition max-lg:duration-[1s]"></div>
    <!-- end sidebar -->



    <div id="container_utama" class="lg:ml-72">


        <div id="top_bar">

        </div>

        <div class="px-14">

            <div class="mt-3 flex items-center flex-wrap justify-between max-[450px]:justify-center max-[450px]:flex-col max-[450px]:gap-2">
                <!-- Tab Bar -->
                <div class="box-border p-1.5 drop-shadow-sm rounded-md flex justify-between flex-row text-sm z-[1] font-ex-semibold bg-white">
                    <div id="hovertab" class="transition translate-x-[0px] ease-in-out h-[35px] rounded-lg w-[80px] absolute bg-[#343948]"></div>
                    <div id="tabgrafik" class="flex cursor-pointer justify-center py-1.5 px-4 rounded-md tab-focus">Grafik</div>
                    <div id="tablaporan" class="flex cursor-pointer justify-center py-1.5 px-4 rounded-md">Laporan</div>
                    <div id="tabgatau" class="flex cursor-pointer justify-center py-1.5 pr-4 rounded-md">Belum Tau</div>
                </div>

                <div class="flex flex-row items-center gap-2">

                    <div onclick="refresh()" class="p-2 rounded-lg drop-shadow-sm font-ex-semibold bg-white hover:bg-gray-200 cursor-pointer" id="refresh-modal">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.21275 6.48793C4.30706 4.5993 6.05044 3.17272 8.11829 2.47382C10.1861 1.77492 12.4375 1.85134 14.4532 2.68885C16.4689 3.52635 18.1115 5.06786 19.0753 7.02635C20.039 8.98484 20.2581 11.2268 19.6918 13.3349C19.1256 15.4429 17.8125 17.2733 15.9971 18.4852C14.1817 19.6972 11.9877 20.2081 9.8237 19.9228C7.65966 19.6375 5.67305 18.5755 4.23377 16.9345C2.79448 15.2935 2.00062 13.1853 2 11.0025" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7.62499 6.50256H3.125V2.00256" stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>

                    <div onclick="filter()" class="p-2 rounded-lg drop-shadow-sm font-ex-semibold bg-white hover:bg-gray-200 cursor-pointer" id="click-modal">

                        <svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 6C15.6401 7.38914 15.0453 8.68431 14.2491 9.81231C13.2029 11.2805 11.8455 12.4193 10.3057 13.1206V18.0702L9.03774 18.992L7.64528 20V13.0732C6.17994 12.3424 4.88307 11.2336 3.8566 9.83385C3.40726 9.21703 3.01522 8.54862 2.68679 7.83938C2.41293 7.24941 2.18318 6.6341 2 6H16Z" fill="black" stroke="black" stroke-miterlimit="10" />
                            <path d="M17 1.33806V2.00002C17.0003 2.1308 16.9782 2.26037 16.9348 2.38123C16.8914 2.5021 16.8277 2.61187 16.7473 2.70423C16.667 2.79824 16.5712 2.87283 16.4655 2.92362C16.3599 2.97441 16.2465 3.00038 16.132 3H1.86838C1.64339 2.99879 1.42743 2.89793 1.26523 2.71831C1.18116 2.62549 1.11433 2.51396 1.06879 2.39048C1.02326 2.26701 0.999968 2.13417 1.00034 2.00002V1.33806C0.99898 1.30957 1.00173 1.28101 1.00849 1.25356C1.0248 1.18078 1.0617 1.11633 1.11337 1.07042C1.16503 1.02451 1.22851 0.999744 1.29376 1.00004H16.7066C16.7601 0.99906 16.8129 1.01522 16.8589 1.04671C16.9049 1.07821 16.9425 1.12381 16.9674 1.17844C16.9892 1.22789 17.0003 1.28262 17 1.33806Z" fill="black" stroke="black" stroke-miterlimit="10" />
                        </svg>
                    </div>
                </div>
                <!-- End Search and Button Add -->
            </div>

            <div id="pagegrafik">
                <div class="text-sm mx-auto md:mx-auto relative bg-white rounded-md mt-4">
                    <div id="loadingchart" class="absolute h-full w-full flex flex-col justify-center items-center bg-slate-50 z-[20]">
                        <div class="loadingspinner"></div>
                    </div>
                    <div class="px-4 py-4" id="chart">
                    </div>
                </div>
            </div>

            <div id="pagelaporan" class="hidden">
                <div class="text-sm h-[500px] mx-auto md:mx-auto bg-white rounded-md mt-4 mb-32">
                    <div class="flex justify-center h-full my-[50px]">
                        <p class="text-center my-auto">laporan</p>
                    </div>
                </div>
            </div>

            <div id="pagegatau" class="hidden">
                <div class="text-sm h-[500px] mx-auto md:mx-auto bg-white rounded-md mt-4 mb-32">
                    <div class="flex justify-center h-full my-[50px]">
                        <p class="text-center my-auto">Belum tau</p>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <script src="../js/jquery-3.6.1.min.js"></script>
    <script src="../js/apexcharts.js"></script>
    <script src="../js/sweetalert2.min.js"></script>
    <script src="../js/jquery.iddle.min.js"></script>
    <script src="../js/moment.js"></script>
    <script src="../js/DateRangePicker.js"></script>
    <script src="../js/datePicker.js"></script>
    <script>
        var dataframe = [];
        var datalensa = [];
        var datafullset = [];
        var categories = [];

        // load modal filter date
        $("#modal_filter_date").load("../assets/components/modal_filter_date.php", function() {
            $("#closefilterdate").on("click", function() {
                $('#modalkontendate').addClass("scale-0");
                $('#bgmodaldate').removeClass("effectmodal");
            });

            $('#apply').on('click', async function() {
                dataframe = [];
                datafullset = [];
                datalensa = [];
                // categories = [];
                if (selectedTab == 'harian') {
                    console.log(selectedFilterHarian);

                    options.title.text = 'Grafik Wilayah Harian';
                    chart.updateOptions(options.title.text)

                    // chart.update();
                    await getSeriesFilterHarian();

                    $('#modalkontendate').addClass("scale-0");
                    $('#bgmodaldate').removeClass("effectmodal");

                } else if (selectedTab == 'mingguan') {
                    options.title.text = 'Grafik Wilayah Mingguan';
                    chart.updateOptions(options.title.text)
                    console.log(selectedFilterMingguan);
                    await getSeriesFilterMingguan();
                    $('#modalkontendate').addClass("scale-0");
                    $('#bgmodaldate').removeClass("effectmodal");

                } else if (selectedTab == 'bulanan') {
                    options.title.text = 'Grafik Wilayah Bulanan';
                    chart.updateOptions(options.title.text)
                    // console.log(selectedFilterBu);
                    await getSeriesFilterBulanan();
                    $('#modalkontendate').addClass("scale-0");
                    $('#bgmodaldate').removeClass("effectmodal");

                } else if (selectedTab == 'tahunan') {
                    options.title.text = 'Grafik Wilayah Tahunan';
                    chart.updateOptions(options.title.text)
                    // console.log(selectedFilterBu);
                    await getSeriesFilterTahunan();
                    $('#modalkontendate').addClass("scale-0");
                    $('#bgmodaldate').removeClass("effectmodal");

                } else {
                    console.log('bukan harian');
                    if (range_start == '' && range_end == '') {} else {
                        options.title.text = 'Grafik Wilayah | ' + range_start + ' to ' + range_end;
                        chart.updateOptions(options.title.text)
                        await getSeriesFilterRange();
                        $('#modalkontendate').addClass("scale-0");
                        $('#bgmodaldate').removeClass("effectmodal");
                    }
                }
                // chart.updateOptions(options);
                chart.updateSeries(getSeries());
                chart.update();


                // chart.updateOptions(options);

                // chart.updateOptions(options);



                // chart.updateOptions(categories);



            });

            // filter 

        });

        async function getSeriesFilterHarian() {
            var modal_loading = Swal.fire({
                title: 'Loading',
                html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
                allowOutsideClick: false,
                showConfirmButton: false,

            });
            await $.ajax({
                url: '../controllers/laporanController.php?type=getLensa&filter=harian',
                type: 'POST',
                data: {
                    'tanggal': selectedFilterHarian,
                },
                success: function(res) {
                    // alert(res);
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //dataframe.push(20);
                        datalensa.push(element.jumlah);
                        // datafullset.push(5);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }

                    // chart.update();
                }
            });

            await $.ajax({
                url: '../controllers/laporanController.php?type=getFullset&filter=harian',
                type: 'POST',
                data: {
                    'tanggal': selectedFilterHarian,
                },
                success: function(res) {
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //dataframe.push(20);
                        // datalensa.push(element.jumlah);
                        datafullset.push(element.jumlah);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    // chart.updateSeries(getSeries(), true);
                    // chart.update();
                }
            });

            await $.ajax({
                url: '../controllers/laporanController.php?type=getFrame&filter=harian',
                type: 'POST',
                data: {
                    'tanggal': selectedFilterHarian,
                },
                success: function(res) {

                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        dataframe.push(element.jumlah);

                        //datafullset.push(5);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    console.log(dataframe.length);
                    // chart.updateSeries(getSeries(), true);
                    // chart.update();
                }
            });


            await $.ajax({
                url: '../controllers/laporanController.php?type=getWilayah&filter=harian',
                type: 'POST',
                data: {
                    'tanggal': selectedFilterHarian,
                },
                success: function(res) {
                    options.xaxis.categories = [];
                    // alert(res);
                    const data = JSON.parse(res);

                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //options.series[0].data.push(10);
                        // options.series[1].data.push(20);
                        //options.series[2].data.push(5);

                        options.xaxis.categories.push(element.kecamatan);
                        // console.log(element.kecamatan);

                    }
                    //alert(categories);
                    // chart.update();
                }
            });
            modal_loading.close();
            chart.updateOptions(options);
            // chart.updateSeries(getSeries(), true);

        }



        async function getSeriesFilterMingguan() {
            var modal_loading = Swal.fire({
                title: 'Loading',
                html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
                allowOutsideClick: false,
                showConfirmButton: false,

            });
            await $.ajax({
                url: '../controllers/laporanController.php?type=getLensa&filter=mingguan',
                type: 'POST',
                data: {
                    'tanggal': selectedFilterMingguan,
                },
                success: function(res) {
                    // alert(res);
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //dataframe.push(20);
                        datalensa.push(element.jumlah);
                        // datafullset.push(5);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }

                    // chart.update();
                }
            });

            await $.ajax({
                url: '../controllers/laporanController.php?type=getFullset&filter=mingguan',
                type: 'POST',
                data: {
                    'tanggal': selectedFilterMingguan,
                },
                success: function(res) {
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //dataframe.push(20);
                        // datalensa.push(element.jumlah);
                        datafullset.push(element.jumlah);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    // chart.updateSeries(getSeries(), true);
                    // chart.update();
                }
            });

            await $.ajax({
                url: '../controllers/laporanController.php?type=getFrame&filter=mingguan',
                type: 'POST',
                data: {
                    'tanggal': selectedFilterMingguan,
                },
                success: function(res) {
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        dataframe.push(element.jumlah);

                        //datafullset.push(5);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    console.log(dataframe.length);
                    // chart.updateSeries(getSeries(), true);
                    // chart.update();
                }
            });


            await $.ajax({
                url: '../controllers/laporanController.php?type=getWilayah&filter=mingguan',
                type: 'POST',
                data: {
                    'tanggal': selectedFilterMingguan,
                },
                success: function(res) {
                    options.xaxis.categories = [];
                    // alert(res);
                    const data = JSON.parse(res);

                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //options.series[0].data.push(10);
                        // options.series[1].data.push(20);
                        //options.series[2].data.push(5);

                        options.xaxis.categories.push(element.kecamatan);
                        // console.log(element.kecamatan);

                    }
                    //alert(categories);
                    // chart.update();
                }
            });
            chart.updateOptions(options);
            modal_loading.close();
            // chart.updateSeries(getSeries(), true);
        }


        async function getSeriesFilterBulanan() {
            var modal_loading = Swal.fire({
                title: 'Loading',
                html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
                allowOutsideClick: false,
                showConfirmButton: false,

            });
            await $.ajax({
                url: '../controllers/laporanController.php?type=getLensa&filter=bulanan',
                type: 'POST',
                data: {
                    'bulan': $('#filterbulanan_bulan').val(),
                    'tahun': $('#filterbulanan_tahun').val(),
                },
                success: function(res) {

                    // alert(res);
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //dataframe.push(20);
                        datalensa.push(element.jumlah);
                        // datafullset.push(5);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }

                    // chart.update();
                }
            });

            await $.ajax({
                url: '../controllers/laporanController.php?type=getFullset&filter=bulanan',
                type: 'POST',
                data: {
                    'bulan': $('#filterbulanan_bulan').val(),
                    'tahun': $('#filterbulanan_tahun').val(),
                },
                success: function(res) {
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //dataframe.push(20);
                        // datalensa.push(element.jumlah);
                        datafullset.push(element.jumlah);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    // chart.updateSeries(getSeries(), true);
                    // chart.update();
                }
            });

            await $.ajax({
                url: '../controllers/laporanController.php?type=getFrame&filter=bulanan',
                type: 'POST',
                data: {
                    'bulan': $('#filterbulanan_bulan').val(),
                    'tahun': $('#filterbulanan_tahun').val(),
                },
                success: function(res) {
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        dataframe.push(element.jumlah);

                        //datafullset.push(5);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    console.log(dataframe.length);
                    // chart.updateSeries(getSeries(), true);
                    // chart.update();
                }
            });


            await $.ajax({
                url: '../controllers/laporanController.php?type=getWilayah&filter=bulanan',
                type: 'POST',
                data: {
                    'bulan': $('#filterbulanan_bulan').val(),
                    'tahun': $('#filterbulanan_tahun').val(),
                },
                success: function(res) {
                    options.xaxis.categories = [];
                    // alert(res);
                    const data = JSON.parse(res);

                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //options.series[0].data.push(10);
                        // options.series[1].data.push(20);
                        //options.series[2].data.push(5);

                        options.xaxis.categories.push(element.kecamatan);
                        // console.log(element.kecamatan);

                    }
                    //alert(categories);
                    // chart.update();
                }
            });
            chart.updateOptions(options);
            modal_loading.close();
            // chart.updateSeries(getSeries(), true);
        }

        async function getSeriesFilterTahunan() {
            var modal_loading = Swal.fire({
                title: 'Loading',
                html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
                allowOutsideClick: false,
                showConfirmButton: false,

            });
            await $.ajax({
                url: '../controllers/laporanController.php?type=getLensa&filter=tahunan',
                type: 'POST',
                data: {
                    'tahun': $('#filtertahunan_tahun').val(),
                },
                success: function(res) {

                    // alert(res);
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //dataframe.push(20);
                        datalensa.push(element.jumlah);
                        // datafullset.push(5);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }

                    // chart.update();
                }
            });

            await $.ajax({
                url: '../controllers/laporanController.php?type=getFullset&filter=tahunan',
                type: 'POST',
                data: {
                    'tahun': $('#filtertahunan_tahun').val(),
                },
                success: function(res) {
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //dataframe.push(20);
                        // datalensa.push(element.jumlah);
                        datafullset.push(element.jumlah);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    // chart.updateSeries(getSeries(), true);
                    // chart.update();
                }
            });

            await $.ajax({
                url: '../controllers/laporanController.php?type=getFrame&filter=tahunan',
                type: 'POST',
                data: {
                    'tahun': $('#filtertahunan_tahun').val(),
                },
                success: function(res) {
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        dataframe.push(element.jumlah);

                        //datafullset.push(5);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    console.log(dataframe.length);
                    // chart.updateSeries(getSeries(), true);
                    // chart.update();
                }
            });


            await $.ajax({
                url: '../controllers/laporanController.php?type=getWilayah&filter=tahunan',
                type: 'POST',
                data: {
                    'tahun': $('#filtertahunan_tahun').val(),
                },
                success: function(res) {
                    options.xaxis.categories = [];
                    // alert(res);
                    const data = JSON.parse(res);

                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //options.series[0].data.push(10);
                        // options.series[1].data.push(20);
                        //options.series[2].data.push(5);

                        options.xaxis.categories.push(element.kecamatan);
                        // console.log(element.kecamatan);

                    }
                    //alert(categories);
                    // chart.update();
                }
            });

            chart.updateOptions(options);
            modal_loading.close();
            // chart.updateSeries(getSeries());
        }

        async function getSeriesFilterRange() {
            var modal_loading = Swal.fire({
                title: 'Loading',
                html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
                allowOutsideClick: false,
                showConfirmButton: false,

            });
            await $.ajax({
                url: '../controllers/laporanController.php?type=getLensa&filter=range',
                type: 'POST',
                data: {
                    'start': range_start,
                    'end': range_end,
                },
                success: function(res) {

                    // alert(res);
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //dataframe.push(20);
                        datalensa.push(element.jumlah);
                        // datafullset.push(5);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }

                    // chart.update();
                }
            });

            await $.ajax({
                url: '../controllers/laporanController.php?type=getFullset&filter=range',
                type: 'POST',
                data: {
                    'start': range_start,
                    'end': range_end,
                },
                success: function(res) {
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //dataframe.push(20);
                        // datalensa.push(element.jumlah);
                        datafullset.push(element.jumlah);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    // chart.updateSeries(getSeries(), true);
                    // chart.update();
                }
            });

            await $.ajax({
                url: '../controllers/laporanController.php?type=getFrame&filter=range',
                type: 'POST',
                data: {
                    'start': range_start,
                    'end': range_end,
                },
                success: function(res) {
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        dataframe.push(element.jumlah);

                        //datafullset.push(5);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    console.log(dataframe.length);
                    // chart.updateSeries(getSeries(), true);
                    // chart.update();
                }
            });


            await $.ajax({
                url: '../controllers/laporanController.php?type=getWilayah&filter=range',
                type: 'POST',
                data: {
                    'start': range_start,
                    'end': range_end,
                },
                success: function(res) {
                    options.xaxis.categories = [];
                    // alert(res);
                    const data = JSON.parse(res);

                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //options.series[0].data.push(10);
                        // options.series[1].data.push(20);
                        //options.series[2].data.push(5);

                        options.xaxis.categories.push(element.kecamatan);
                        // console.log(element.kecamatan);

                    }
                    //alert(categories);
                    // chart.update();
                }
            });
            chart.updateOptions(options);
            modal_loading.close();
            // chart.updateSeries(getSeries(), true);
        }


        // chart

        // console.log(container.height() * 2.6);
        // sizeChart = ($(document).height() * 0.7);

        window.addEventListener('resize', function() {
            chart.updateOptions({
                chart: {
                    height: $(window).height() * 0.7
                }
            });
            // options.chart.height = ;

            chart.update();
            // console.log($(document).outerHeight());
            // console.log(options.chart.height);

        });
        // if ($(document).width() >= 720 && $(document).width() < 1080) {

        var options = {
            chart: {
                redrawOnWindowResize: true,
                type: 'bar',
                height: $(document).height() * 0.7,
                // width: undefined,
                toolbar: {
                    show: true,
                    offsetX: 0,
                    offsetY: 0,

                    export: {
                        csv: {
                            filename: undefined,
                            columnDelimiter: ',',
                            headerCategory: 'category',
                            headerValue: 'value',
                            dateFormatter(timestamp) {
                                return new Date(timestamp).toDateString()
                            }
                        },
                        svg: {
                            filename: undefined,
                        },
                        png: {
                            filename: undefined,
                        }
                    },
                    autoSelected: 'zoom'
                },
            },
            dataLabels: {
                enabled: false,

            },
            legend: {
                show: true,

                position: 'bottom',
                horizontalAlign: 'center',

                floating: false,
                fontSize: '14px',
                fontFamily: 'Helvetica, Arial',
                fontWeight: 400,



                offsetX: 0,
                offsetY: 0,
                labels: {
                    colors: ['#ED30A2', '#0782C8'],
                    useSeriesColors: false
                },
            },

            title: {
                text: 'Grafik Wilayah Bulanan',
                align: 'left',
                margin: 60,
                offsetX: 0,
                offsetY: -20,
                floating: true,
                style: {
                    fontSize: '24px',
                    fontWeight: 'bold',
                    fontFamily: undefined,
                    color: '#263238'
                },
            },
            noData: {
                text: "No Data",
                align: 'center',
                verticalAlign: 'middle',
                offsetX: 0,
                offsetY: 0,
                style: {
                    color: undefined,
                    fontSize: '14px',
                    fontFamily: undefined
                },
                xaxis: {
                    type: 'category',
                    categories: [],
                    labels: {
                        show: false,
                    },
                }
            },

            series: [],
            stroke: {
                colors: ["transparent"],
                width: 2
            },

            colors: ['#ED30A2', '#0782C8', '#00ff00'],

            xaxis: {
                type: 'category',
                categories: [],
                labels: {
                    show: true,
                },
                rotateLabels: 0,
            }

        }


        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();

        // loadSeries();
        getCategories();

        console.log(dataframe);

        function loadSeries() {
            loadDefaultSeries();

            // chart.update();
        }

        $(document).ready(function() {
            loadDefaultSeries();
            // refreshChart();
            // chart.updateSeries(getSeries());
            // chart.update();
            console.log('abcd');
        });

        function refreshChart() {
            dataframe = [];
            datafullset = [];
            datalensa = [];
            options.title.text = 'Grafik Wilayah';
            chart.updateOptions(options.title.text)
            loadSeries();
        }

        function refresh() {

            $('#loadingchart').show();
            refreshChart();
            getCategories();
            console.log('ahaaa');


            // chart.updateSeries(getSeries());
        }


        function filter() {

            console.log('dwad');
            $('#modalkontendate').removeClass("scale-0");
            $('#bgmodaldate').addClass("effectmodal");
        }

        function getSeries() {
            return [{
                name: 'Frame',
                data: dataframe,

            }, {
                name: 'Lensa',
                data: datalensa,

            }, {
                name: 'Fullset',
                data: datafullset,
            }]
        }

        async function loadDefaultSeries() {
            await $.ajax({
                url: '../controllers/laporanController.php?type=getLensa',
                type: 'GET',
                success: function(res) {
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //dataframe.push(20);
                        datalensa.push(element.jumlah);
                        // datafullset.push(5);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    chart.update();
                }
            });

            await $.ajax({
                url: '../controllers/laporanController.php?type=getFullset',
                type: 'GET',
                success: function(res) {
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //dataframe.push(20);
                        // datalensa.push(element.jumlah);
                        datafullset.push(element.jumlah);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    // chart.update();
                }
            });

            await $.ajax({
                url: '../controllers/laporanController.php?type=getFrame',
                type: 'GET',
                success: function(res) {
                    //alert(res);
                    const data = JSON.parse(res);
                    //categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        dataframe.push(element.jumlah);

                        //datafullset.push(5);
                        // options.series[1].data.push(element.jumlah);
                        //alert(element.jumlah);
                    }
                    // chart.update();
                }
            });

            chart.updateSeries(getSeries(), true);
            $('#loadingchart').hide();
        }





        async function getCategories() {
            await $.ajax({
                url: '../controllers/laporanController.php?type=getWilayah',
                type: 'GET',
                success: function(res) {
                    // alert(res);
                    //alert(res);
                    const data = JSON.parse(res);
                    // categories = [];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        // categories = element.kecamatan;
                        //options.series[0].data.push(10);
                        // options.series[1].data.push(20);
                        //options.series[2].data.push(5);

                        options.xaxis.categories.push(element.kecamatan);

                    }
                    //alert(categories);
                    // chart.update();

                }
            });
            chart.updateOptions(options);
        }


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



        // load sidebar
        $("#ex-sidebar").load("../assets/components/sidebar.html", function() {
            $('#grafik_keuangan').addClass("hover-sidebar");
        });
        // top_bar
        $('#top_bar').load("../assets/components/top_bar.php", function() {
            $('#title-header').html('Master Data Pegawai');

            $('#loading').hide();

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
                console.log('aaaaqqqq');

            });
        });





        $('#click-modal').on('click', function() {
            console.log("modal click");
            $('#modal').removeClass("scale-0");
            $('#bgmodal').addClass("effectmodal");
        });

        $('#tabgrafik').on('click', function() {

            $('#pagegrafik').removeClass("hidden");
            $('#pagelaporan').addClass("hidden");
            $('#pagegatau').addClass("hidden");

            $('#hovertab').addClass("translate-x-[0px]");
            $('#hovertab').removeClass("translate-x-[80px]");
            $('#hovertab').removeClass("translate-x-[165px]");

            // change theme tab
            $('#tabgrafik').addClass("tab-focus");
            $('#tablaporan').removeClass("tab-focus");
            $('#tabgatau').removeClass("tab-focus");


            // chart.update();
            chart.updateSeries(getSeries(), true);


        });

        $('#tablaporan').on('click', function() {

            $('#pagegrafik').addClass("hidden");
            $('#pagegatau').addClass("hidden");
            $('#pagelaporan').removeClass("hidden");

            $('#hovertab').addClass("translate-x-[80px]");
            $('#hovertab').removeClass("translate-x-[0px]");
            $('#hovertab').removeClass("translate-x-[165px]");

            // change theme tab
            $('#tabgrafik').removeClass("tab-focus");
            $('#tabgatau').removeClass("tab-focus");

            $('#tablaporan').addClass("tab-focus");
        });

        $('#tabgatau').on('click', function() {

            $('#pagegrafik').addClass("hidden");
            $('#pagelaporan').addClass("hidden");
            $('#pagegatau').removeClass("hidden");

            $('#hovertab').removeClass("translate-x-[80px]");
            $('#hovertab').removeClass("translate-x-[0px]");
            $('#hovertab').addClass("translate-x-[165px]");

            // change theme tab
            $('#tabgrafik').removeClass("tab-focus");
            $('#tablaporan').removeClass("tab-focus");
            $('#tabgatau').addClass("tab-focus");

        });
    </script>

</body>

</html>
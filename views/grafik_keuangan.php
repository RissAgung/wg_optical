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



    <div class="lg:ml-72">


        <div id="top_bar">

        </div>

        <div class="mt-3 flex items-center flex-col md:flex-row md:justify-around lg:justify-between lg:px-16 md:py-[3px]">

            <!-- Tab Bar -->
            <div class="box-border p-1.5 drop-shadow-sm rounded-md flex justify-between flex-row text-sm z-[1] font-ex-semibold bg-white">
                <div id="hovertab" class="transition translate-x-[0px] ease-in-out h-[35px] rounded-lg w-[80px] absolute bg-[#343948]"></div>
                <div id="tabgrafik" class="flex cursor-pointer justify-center py-1.5 px-4 rounded-md tab-focus">Grafik</div>
                <div id="tablaporan" class="flex cursor-pointer justify-center py-1.5 px-4 rounded-md">Laporan</div>
                <div id="tabgatau" class="flex cursor-pointer justify-center py-1.5 pr-4 rounded-md">Belum Tau</div>
            </div>

            <div class="flex flex-col md:flex-row items-center mt-3 md:mt-0">
                <!-- Button Add -->
                <div class="md:my-auto h-10 w-24 font-ex-semibold text-white mt-3 md:mt-0" id="click-modal">
                    <button onclick="filter()" class="bg-[#ffffff] drop-shadow-sm text-[#343948] text-sm h-full w-full rounded-md">Filter</button>
                </div>
                <!-- End Button Add -->

            </div>
            <!-- End Search and Button Add -->
        </div>

        <div id="pagegrafik">
            <div class="text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-12 mb-32">
                <div class="px-4 py-4" id="chart">
                </div>
            </div>
        </div>

        <div id="pagelaporan" class="hidden">
            <div class="text-sm h-[500px] mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 mb-32">
                <div class="flex justify-center h-full my-[50px]">
                    <p class="text-center my-auto">laporan</p>
                </div>
            </div>
        </div>

        <div id="pagegatau" class="hidden">
            <div class="text-sm h-[500px] mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 mb-32">
                <div class="flex justify-center h-full my-[50px]">
                    <p class="text-center my-auto">Belum tau</p>
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

            $('#apply').on('click', function() {


                dataframe = [];
                datafullset = [];
                datalensa = [];
                categories = [];
                if (selectedTab == 'Harian') {
                    console.log(selectedFilterHarian);
                    getSeriesFilterHarian();

                } else if (selectedTab == 'Mingguan') {
                    console.log(selectedFilterHarian);
                    getSeriesFilterHarian();

                } else {
                    console.log('bukan harian');
                }

                // chart.updateOptions(options);

                // chart.updateOptions(options);



                // chart.updateOptions(categories);

                $('#modalkontendate').addClass("scale-0");
                $('#bgmodaldate').removeClass("effectmodal");

            });

            // filter 

        });

        async function getSeriesFilterHarian() {

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
            chart.updateOptions(options);
            chart.updateSeries(getSeries(), true);

        }



        function prosesFilter(option) {
            if (option == 'harian') {

            }
        }



        // chart
        var sizeChart;
        if ($(document).width() >= 720 && $(document).width() < 1080) {
            sizeChart = 500;
        } else if ($(document).width() >= 1080) {
            sizeChart = 450;
        } else {
            sizeChart = 300;
        }

        var options = {
            chart: {
                redrawOnWindowResize: true,
                type: 'bar',
                height: sizeChart,
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
                text: 'Grafik Keuangan',
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
                        show: true,
                    },
                }
            },

            series: getSeries(),
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
            }

        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();

        loadSeries();
        getCategories();

        function loadSeries() {
            getSeriesLensa();
            getSeriesFrame();
            getSeriesFullset();
        }

        function refreshChart() {
            dataframe = [];
            datafullset = [];
            datalensa = [];
            loadSeries();
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


        function getSeriesLensa() {
            $.ajax({
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
                    // chart.update();
                }
            });
        }

        function getSeriesFullset() {

            $.ajax({
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
                    chart.update();
                }
            });
        }

        function getSeriesFrame() {
            $.ajax({
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
                    chart.update();
                }
            });
        }

        function getCategories() {
            $.ajax({
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

                    chart.update();

                }
            });
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

            $('#loading').hide();
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
<?php
date_default_timezone_set("Asia/Bangkok");

$date = getdate();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/output.css">
    <title>Document</title>
</head>

<body id="bodynya" class=" bg-slate-600 text-[#343948] font-ex-medium">
    <!-- Background -->
    <div id="bgmodaldate" class="hidden w-full h-screen fixed bg-black z-[51] opacity-0 transition duration-300"></div>
    <!-- konten modal-->
    <div id="modalkontendate" class="scale-0 w-[90%] md:w-[55%] lg:w-[40%] xl:w-[35%] 2xl:w-[25%] bg-white fixed z-[51] left-[50%] top-[50%] -translate-y-[50%] -translate-x-[50%] shadow-xl rounded-lg  transition ease-in-out">
        <div class="flex flex-col md:flex-row justify-center overflow-hidden">
            <div class="flex max-[767px]:h-20 drop-shadow-md z-[100] bg-white w-full md:w-[50%]">
                <li class="flex flex-row px-3 ml-2 md:ml-0 w-full md:py-8 scrollbar-hide overflow-x-scroll overflow-y-hidden md:overflow-x-hidden md:flex-col justify-between md:justify-center md:mb-20 items-center">
                    <ul id="harian" onclick="clickTab('harian')" class="px-2 transition duration-500 text-center bg-slate-700 cursor-pointer py-2 rounded-md w-28 text-white">Harian</ul>
                    <ul id="mingguan" onclick="clickTab('mingguan')" class="px-2 transition duration-500 text-center hover:bg-gray-200 cursor-pointer py-2 rounded-md">Mingguan</ul>
                    <ul id="bulanan" onclick="clickTab('bulanan')" class="px-2 transition duration-500 text-center hover:bg-gray-200 cursor-pointer py-2 rounded-md">Bulanan</ul>
                    <ul id="tahunan" onclick="clickTab('tahunan')" class="px-2 transition duration-500 text-center hover:bg-gray-200 cursor-pointer py-2 rounded-md">Tahunan</ul>
                    <ul id="range" onclick="clickTab('range')" class="px-2 transition duration-500 text-center hover:bg-gray-200 cursor-pointer py-2 rounded-md">Range</ul>
                </li>
            </div>
            <div id="container-date" class="z-1 h-[300px] w-full relative overflow-y-scroll md:overflow-y-scroll my-4 mb-20">
                <div id="div-harian" class="h-[120%] items-center scale-100 absolute -translate-y-10 w-full"></div>
                <div id="div-mingguan" class="hidden h-[120%] items-center scale-100 absolute -translate-y-10 w-full"></div>
                <div id="div-bulanan" class="hidden  h-12 mt-8 items-center flex-wrap px-8 gap-4">
                    <div class="flex flex-col items-start w-full gap-2">
                        <h1 class="w-1/2 font-semibold text-sm text-start">Bulan</h1>
                        <div class="h-[50px] w-full border border-[#C9C9C9] rounded-lg overflow-hidden">
                            <select name="txt_level" id="txt_level" class="h-full w-full outline-0 border-0 px-4">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">Aprill</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col items-start w-full gap-2">
                        <h1 class="w-1/2 font-semibold text-sm text-start">Tahun</h1>
                        <div class="h-[50px] w-full border border-[#C9C9C9] rounded-lg overflow-hidden">
                            <select name="txt_level" id="txt_level" class="h-full w-full outline-0 border-0 px-4">
                                <?php for ($i = ($date['year'] - 10); $i < ($date['year'] + 10); $i++) : ?>
                                    <option <?php echo $i == $date['year'] ? "selected" : ""; ?> value="<?= $i; ?>"><?= $i; ?></option>
                                <?php endfor ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="div-tahunan" class="hidden  h-12 mt-8 items-center flex-wrap px-8 gap-4">
                    <div class="flex flex-col items-start w-full gap-2">
                        <h1 class="w-1/2 font-semibold text-sm text-start">Tahun</h1>
                        <div class="h-[50px] w-full border border-[#C9C9C9] rounded-lg overflow-hidden">
                            <select name="txt_level" id="txt_level" class="h-full w-full outline-0 border-0 px-4">
                                <?php for ($i = ($date['year'] - 10); $i < ($date['year'] + 10); $i++) : ?>
                                    <option <?php echo $i == $date['year'] ? "selected" : ""; ?> value="<?= $i; ?>"><?= $i; ?></option>
                                <?php endfor ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="div-range" class="hidden  h-12 mt-8 items-center flex-wrap px-8 gap-4">
                    <div class="flex flex-col items-start w-full gap-2">
                        <h1 class="w-1/2 font-semibold text-sm text-start">Range Date</h1>
                        <div class="h-[50px] w-full border border-[#C9C9C9] rounded-lg overflow-hidden">
                            <button itemid="inputDateRange" name="daterange" class="h-full w-full border-0 outline-none px-4"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer-modaldate" class="mt-4 fixed bottom-0 z-[9999] bg-white w-full">
            <div class="h-[1px] bg-[#C9C9C9]"></div>
            <div class="flex flex-row justify-end gap-4 px-4 py-2">
                <div id="closefilterdate" class="bg-slate-600 cursor-pointer w-[70px] md:w-[80px] text-center rounded-md py-1 text-white text-sm sm:text-lg">
                    <p>Cancel</p>
                </div>
                <div id="apply" class="bg-slate-600 cursor-pointer w-[70px] md:w-[80px] text-center rounded-md py-1 text-white text-sm sm:text-lg">
                    <p>Apply</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->

    <script>
        datenow = new Date();
        
        var selectedTab = 'Harian';
        const pilihan = ['harian', 'mingguan', 'bulanan', 'tahunan', 'range'];
        var selectedFilterHarian = datenow.getFullYear() + '-' + (datenow.getMonth() + 1) + '-' + datenow.getDate();

        function clickTab(name) {
            for (let index = 0; index < pilihan.length; index++) {
                const element = pilihan[index];
                $('#div-' + element).addClass('hidden');
                $('#div-' + element).removeClass('flex');
                $('#' + element).addClass('hover:bg-gray-200');
                $('#' + element).removeClass('bg-slate-700');
                $('#' + element).removeClass('text-white');
            }

            $('#' + name).addClass('bg-slate-700');
            $('#' + name).addClass('text-white');
            $('#' + name).removeClass('hover:bg-gray-200');
            $('#div-' + name).removeClass('hidden');
            $('#div-' + name).addClass('flex');
            selectedTab = name;
            // console.log('#' + name);
        }

        $('#inputDateRange').on('keydown', function(e) {
            e.preventDefault();
        });


        const hari = document.getElementById('div-harian');
        const datepicker_hari = new Datepicker(hari, {
            todayHighlight: true,
            endDate: '+367d',
            // ...options
        });

        hari.addEventListener('changeDate', function(evt) {
            dateharian = new Date(evt.detail.date);
            selectedFilterHarian = dateharian.getFullYear() + '-' + (dateharian.getMonth() + 1) + '-' + dateharian.getDate();

            // alert(ateharian.getFullYear() + '-' + (dateharian.getMonth() + 1) + '-' + dateharian.getDate());

        });

        const minggu = document.getElementById('div-mingguan');
        const datepicker_minggu = new Datepicker(minggu, {
            todayHighlight: true,
            endDate: '+367d',
            // ...options
        });

        var getDateRange = '';


        $(function() {
            $('button[name="daterange"]').daterangepicker({
                "opens": 'center',
                "showDropdowns": true,
                "parentEl": $('#bodynya'),
            }, function(start, end, label) {
                getDateRange = start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD');
                $('button[name="daterange"]').html('<p>' + getDateRange + '</p>')
                // console.log(getDateRange);
            });
        });



        // elem.addEventListener('changeDate', function(evt) {
        //     testaaa = new Date(evt.detail.date);
        //     alert(testaaa.getDate() + '-' + (testaaa.getMonth() + 1) + '-' + testaaa.getFullYear());

        // });

        // $('#apply').on('click', function() {
        //     console.log('test');
        //     console.log(testaaa.getDate());
        // });
    </script>
</body>

</html>
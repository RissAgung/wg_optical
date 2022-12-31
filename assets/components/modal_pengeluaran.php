<!-- <?php
include '../../config/koneksi.php';

session_start();

$select = new Koneksi();

$supplier = $select->showData("SELECT * FROM supplier");


?> -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/output.css">
  <title>Document</title>
</head>

<body class="text-[#343948]">
<div id="bgmodal" class="w-full h-screen fixed hidden bg-black z-[51] opacity-0 transition duration-300"></div> 
  <div id="modalkonten" class="flex flex-col fixed z-[51] left-[50%] top-[50%] -translate-y-[50%] -translate-x-[50%] justify-center size-modal-add items-center scale-0 transition ease-in-out w-[380px] shadow-xl bg-white rounded-xl overflow-hidden">

     <!-- header -->
    <div class="flex flex-col items-center w-full">
      <div class="flex flex-row items-center" id="close">
        <h1 id="title" class="py-[27px] font-ex-bold"></h1>
        <div class="cursor-pointer btn-modal-close relative bottom-3 left-24" id="btn_out">
          <svg width="15" height="15" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M7.3289 5.47926L10.6264 2.18142C10.8405 1.93831 10.9539 1.62288 10.9436 1.29924C10.9332 0.975599 10.7999 0.668037 10.5707 0.439072C10.3415 0.210106 10.0337 0.0769213 9.70976 0.0665883C9.38581 0.0562553 9.07009 0.16955 8.82676 0.383443L5.52586 3.67789L2.21901 0.373252C2.10056 0.254916 1.95995 0.161048 1.80519 0.097005C1.65044 0.0329623 1.48457 1.24687e-09 1.31706 0C1.14956 -1.24687e-09 0.983689 0.0329623 0.828933 0.097005C0.674177 0.161048 0.533562 0.254916 0.415117 0.373252C0.296672 0.491587 0.202716 0.632072 0.138614 0.786685C0.0745119 0.941298 0.041519 1.10701 0.041519 1.27436C0.041519 1.44171 0.0745119 1.60743 0.138614 1.76204C0.202716 1.91665 0.296672 2.05714 0.415117 2.17547L3.72282 5.47926L0.425318 8.77625C0.295996 8.89175 0.19162 9.03239 0.118574 9.18957C0.0455293 9.34676 0.00535166 9.51718 0.000499102 9.69041C-0.00435345 9.86364 0.0262212 10.036 0.0903528 10.1971C0.154484 10.3581 0.250824 10.5043 0.373478 10.6269C0.496133 10.7494 0.642522 10.8457 0.80369 10.9097C0.964858 10.9738 1.13742 11.0043 1.31081 10.9995C1.4842 10.9947 1.65478 10.9545 1.81211 10.8815C1.96944 10.8086 2.11021 10.7043 2.22581 10.5751L5.52586 7.28063L8.82251 10.5751C9.06172 10.8141 9.38616 10.9483 9.72446 10.9483C10.0628 10.9483 10.3872 10.8141 10.6264 10.5751C10.8656 10.3361 11 10.0119 11 9.67396C11 9.33598 10.8656 9.01184 10.6264 8.77286L7.3289 5.47926Z"
              fill="#343948" />
          </svg>
        </div>
      </div>
      <hr class="w-full">
    </div>
    <!-- end header -->

    <!-- input -->
    <div id="formOperasional" class="flex flex-col overflow-y-scroll scrollbar-hide w-full px-3 h-[60vh] gap-2">
      <div class="h-12 flex mt-8 items-center px-5">
        <h1 class="w-1/2 font-semibold text-sm">Tanggal</h1>
        <div class=" h-[50px] w-full border border-[#C9C9C9] rounded-lg ml-4 overflow-hidden">
            <input type="date" name="" class="h-full w-full" id="date">
        </div>
      </div>
      <div class="h-12 flex mt-8 items-center px-5 ">   
        <p class="font-ex-semibold w-1/2">Keterangan</p>
        <div class=" w-full border border-[#C9C9C9] rounded-lg ml-4 overflow-hidden">
        <textarea id="ket" rows="4" class="block h-full w-full rounded-md outline-none px-4 py-2" maxlength="50"></textarea>
        </div>
      </div>      
      <div class="h-12 flex mt-8 items-center  px-5">
        <p class="font-ex-semibold w-1/2">Total</p>                
        <div class="h-[50px] w-full border border-[#C9C9C9] rounded-lg ml-4 overflow-hidden">
        <input type="text" id="total" class="border-0 h-12 w-full px-3 rounded-md border-[#C9C9C9] outline-none" maxlength="15">
        </div>
      </div>
    </div>

    <div id="formRestock" class="flex flex-col overflow-y-scroll scrollbar-hide w-full px-3 h-[60vh]">
      <div class="h-12 flex mt-8 items-center  px-5">
        <h1 class="w-1/2 font-semibold text-sm">Tanggal</h1>
        <div class=" h-[50px] w-full border border-[#C9C9C9] rounded-lg ml-4 overflow-hidden">
            <input type="date" id="tanggal" class="h-full w-full" id="date">
        </div>
      </div> 
      <div class=" flex w-full items-center px-5 mt-7">
        <p class="font-ex-semibold w-1/2">Jenis</p>
        <div class="h-[50px] w-full border border-[#C9C9C9] rounded-lg ml-4 overflow-hidden">
          <select name="jns" id="jns" class="h-full w-full outline-0 border-0 px-4 bg-white">
              <option selected disabled  value="">Pilih Jenis Barang</option>
              <option value="produk">Produk</option>
              <option value="tambahan">Tambahan</option>
              <option value="perlengkapan">Perlengkapan</option>
          </select>
      </div>
      </div>      
      <div class=" flex w-full items-center px-5 mt-7">
        <p class="font-ex-semibold w-1/2">Barang</p>
        <div class="h-[50px] w-full border border-[#C9C9C9] rounded-lg ml-4 overflow-hidden">
          <select name="brg" id="brg" class="h-full w-full outline-0 border-0 px-4 bg-white">
              <option selected disabled value="">Pilih Barang</option>             
              <option></option>
              </select>
      </div>
      </div>  
      
     <div class=" flex w-full items-center  px-5 mt-7">
        <p class="font-ex-semibold w-1/2">Supplier</p>
        <div class=" h-[50px] w-full border border-[#C9C9C9] rounded-lg ml-4 overflow-hidden">
        <select name="supplier" id="supplier" class="h-full w-full outline-0 border-0 px-4 bg-white">
              <option selected disabled value="">Pilih Supplier</option>
              <?php 
                 foreach ($supplier as $data) {
              ?>            
              <option value="<?php echo $data['Id_Supplier']?>"><?php echo $data['Nama_Supplier'] ?></option>
              <?php } ?>
              </select>
        </div>
      </div>

      <div class=" flex w-full items-center  px-5 mt-7">
        <p class="font-ex-semibold w-1/2">Jumlah</p>
        <div class=" h-[50px] w-full border border-[#C9C9C9] rounded-lg ml-4 overflow-hidden">
        <input type="text" id="jml" class="border-0 h-12  w-full px-3  outline-none" maxlength="5" onkeypress="return inputNumber(event)">
        </div>
      </div>
  
    </div>
    <!-- end input -->

    <!-- button -->
    <div class="flex flex-row justify-center w-full px-[30px] py-[20px] font-ex-semibold text-white border-t-2">
      <div
        class="cursor-pointer flex hover:bg-[#E7261F] hover:transition hover:duration-[0.3s] justify-center items-center h-[40px] w-[103px] bg-[#F35E58] rounded-md"
        id="btn_batal">
        Batal
      </div>
      <div
        class="cursor-pointer flex hover:bg-[#06A981] hover:transition hover:duration-[0.3s] justify-center items-center ml-4 h-[40 px] w-[103px] bg-[#3DBD9E] rounded-md"
        id="btn_tambah">
        Tambah
      </div>
    </div>
    <!-- end button -->

  </div>
</div>

  <script src="../../js/jquery-3.6.1.min.js"></script>
  <script>

  

    function modals(page){
        if(page == "Opr"){
            $('#formOperasional').addClass("flex");          
            $('#formOperasional').removeClass("hidden");
            $('#formRestock').addClass("hidden");
            $('#formRestock').removeClass("flex");
        
        } else if(page == "Res"){
            $('#formRestock').removeClass("hidden");
            $('#formRestock').addClass("flex");
            $('#formOperasional').removeClass("flex");
            $('#formOperasional').addClass("hidden");
        }
      }

      /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('total');
    dengan_rupiah.addEventListener('keyup', function (e) {
      dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi */
    function formatRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function inputNumber(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57)){ 
		    return false;
		    return true;
      }
		}    
  </script>


<script>
  $("#jns").change(function(){
    var jenis = $("#jns").val();
    if (jenis == "produk"){
      console.log("list frame"); 
        $.ajax({
          url:'../controllers/modal_pengeluaran.php?type=frame',
          type : 'GET',
          success : function(res){
            var isi = '';
            const data = JSON.parse(res);

            // console.log(data[0].kode_frame);
            for(let index = 0; index < data.length; index++){
              //console.log(data);
              isi += '<option value='+data[index].kode_frame+'>'+data[index].kode_frame+'</option>';
            }            
            
             $('#brg').html(isi);

            }
          })      
        }else if (jenis == "tambahan"){
          console.log("list tmbhaan");
          $.ajax({
          url:'../controllers/modal_pengeluaran.php?type=tambahan',
          type : 'GET',
          success : function(res){
            var isi = '';
            const data = JSON.parse(res);

            // console.log(data[0].kode_frame);
            for(let index = 0; index < data.length; index++){
              //console.log(data);
              isi += '<option value='+data[index].kode_barang+'>'+data[index].kode_barang+'</option>';
            }            
            
             $('#brg').html(isi);

            }
          })  
        }else if(jenis == "perlengkapan"){
          console.log("list perkap");
          $.ajax({
          url:'../controllers/modal_pengeluaran.php?type=perlengkapan',
          type : 'GET',
          success : function(res){
            var isi = '';
            const data = JSON.parse(res);

            // console.log(data[0].kode_frame);
            for(let index = 0; index < data.length; index++){
              //console.log(data);
              isi += '<option value='+data[index].kode_perlengkapan+'>'+data[index].kode_perlengkapan+'</option>';
            }            
            
             $('#brg').html(isi);

            }
          })  
        }else{
          console.log("list none");
        }
        console.log($('#brg').val());
      });
    </script>
</body>
</html>
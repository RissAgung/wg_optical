<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <title>MasterProduct_Tambahan</title>
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">
  <!-- Logout modal -->
  <div id="bgmodal" class="w-full h-screen fixed hidden bg-black z-[51] opacity-0 transition duration-300"></div>
  <div id="modalLogout" class="w-[90%] md:w-[60%] lg:w-[30%] bg-white fixed z-[51] left-[50%] top-[50%] -translate-y-[50%] -translate-x-[50%] shadow-xl rounded-lg scale-0  transition ease-in-out">
    <div class="flex flex-row justify-between px-8 pt-[20px]">
      <h1 class="font-bold text-xl md:text-2xl">Keluar</h1>
      <h1>X</h1>
    </div>
    <div class="px-8 pt-[20px]">

      <p class="text-sm md:text-lg text-slate-600">Apakah anda yakin ingin keluar?</p>
    </div>

    <div class="flex flex-row justify-end px-8 gap-2 pt-8 pb-8">

      <div class="bg-[#8a9e99] w-[70px] md:w-[80px] text-center rounded-md py-1 text-white text-sm sm:text-lg">
        <p>Cancel</p>
      </div>
      <div class="bg-[#F35E58] w-[70px] md:w-[80px] text-center rounded-md py-1 text-white text-sm sm:text-lg">
        <p>Oke</p>
      </div>

    </div>
  </div>
  <!-- end modal logout -->

  <!-- modal -->
  <div class="fixed left-[50%] top-[50%] -translate-y-[50%] -translate-x-[50%] z-[51] transition ease-in-out scale-0" id="modal">

  </div>
  <!-- end modal -->

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

    <div class="mt-3 flex items-center justify-between flex-col md:flex-row md:justify-around  lg:justify-between lg:px-16 md:py-[3px]">

      <!-- Tab Bar -->
      <!-- <div class="w-44 box-border p-1.5 shadow-sm rounded-md flex justify-between flex-row text-sm font-ex-semibold bg-white">
        <div class="transition bg-[#343948] h-8 w-[80px] absolute rounded-md translate-x-0 ease-in-out" id="bgtab">
        </div>
        <div class="flex justify-center py-1.5 w-20 rounded-md tab-focus cursor-pointer" id="tab_table">Table</div>
        <div class="flex justify-center py-1.5 w-20 rounded-md cursor-pointer" id="tab_catalog">Catalog</div>
      </div> -->

      <!-- Search and Button Add -->
      <div class="flex flex-col md:flex-row items-center mt-3 md:mt-0">

        <!-- Search -->
        <div class="flex flex-row shadow-sm rounded-md items-center bg-white box-border px-2 md:mr-6">
          <svg width="19" height="19" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-3">
            <path d="M19.2502 19.25L15.138 15.1305M17.4168 9.62501C17.4168 11.6915 16.5959 13.6733 15.1347 15.1346C13.6735 16.5958 11.6916 17.4167 9.62516 17.4167C7.55868 17.4167 5.57684 16.5958 4.11562 15.1346C2.6544 13.6733 1.8335 11.6915 1.8335 9.62501C1.8335 7.55853 2.6544 5.57669 4.11562 4.11547C5.57684 2.65425 7.55868 1.83334 9.62516 1.83334C11.6916 1.83334 13.6735 2.65425 15.1347 4.11547C16.5959 5.57669 17.4168 7.55853 17.4168 9.62501V9.62501Z" stroke="#797E8D" stroke-width="2" stroke-linecap="round" />
          </svg>

          <input type="text" placeholder="Type here" class="h-11 bg-transparent ml-2 outline-none" />
        </div>

      </div>
      <!-- End Search -->

      <!-- Button Add -->
      <div class="  md:my-auto h-10 w-24 font-ex-semibold text-white mt-3 md:mt-0" id="click-modal">
        <button class="bg-[#3DBD9E] h-full w-full rounded-md">Tambah</button>
      </div>
      <!-- End Button Add -->
      <!-- End Search and Button Add -->
    </div>
    <!-- konten table -->
    <div class="" id="table">
      <!--table-->
      <div class="overflow-x-auto  text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 ex-table">
        <table class="w-full">
          <thead class="border-b-2 border-gray-100">
            <tr>
              <th class="p-3 text-sm tracking-wide text-center">No</th>
              <th class="p-3 text-sm tracking-wide text-center">Kode Barang</th>
              <th class="p-3 text-sm tracking-wide text-center">Nama Barang</th>
              <th class="p-3 text-sm tracking-wide text-center">Stock</th>
              <th class="p-3 text-sm tracking-wide text-center">unknow</th>
              <th class="p-3 text-sm tracking-wide text-center">aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="flex justify-center">
                <button>
                  <svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="37" height="37" rx="5" fill="#EDC683" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M27.4782 8.38256C27.7335 8.48841 27.9655 8.64355 28.1609 8.83911C28.3564 9.03447 28.5116 9.26646 28.6174 9.52181C28.7233 9.77717 28.7777 10.0509 28.7777 10.3273C28.7777 10.6037 28.7233 10.8774 28.6174 11.1328C28.5116 11.3881 28.3564 11.6201 28.1609 11.8155L25.3473 14.6282L22.3717 11.6526L25.1845 8.83911C25.3798 8.64355 25.6118 8.48841 25.8672 8.38256C26.1225 8.27671 26.3962 8.22223 26.6727 8.22223C26.9491 8.22223 27.2228 8.27671 27.4782 8.38256ZM9.59277 25.7604C9.59295 24.9094 9.93117 24.0933 10.533 23.4916L21.2376 12.787L24.2132 15.7626L13.5086 26.4672C12.9069 27.069 12.0908 27.4072 11.2398 27.4074H9.59277V25.7604Z" fill="#3F2C0D" />
                  </svg>
                </button>
                <button>
                  <svg width="38" height="37" viewBox="0 0 38 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.444336" width="37" height="37" rx="5" fill="#F35E58" />
                    <path d="M23.3982 10.5062V8.67903C23.3982 8.19444 23.2105 7.72969 22.8764 7.38703C22.5423 7.04437 22.0892 6.85187 21.6167 6.85187H16.2723C15.7998 6.85187 15.3467 7.04437 15.0126 7.38703C14.6785 7.72969 14.4908 8.19444 14.4908 8.67903V10.5062H10.0371V12.3333H11.8186V26.0371C11.8186 26.7639 12.1001 27.4611 12.6013 27.975C13.1024 28.489 13.7821 28.7778 14.4908 28.7778H23.3982C24.1069 28.7778 24.7866 28.489 25.2878 27.975C25.7889 27.4611 26.0704 26.7639 26.0704 26.0371V12.3333H27.8519V10.5062H23.3982ZM18.0538 22.3827H16.2723V16.9012H18.0538V22.3827ZM21.6167 22.3827H19.8353V16.9012H21.6167V22.3827ZM21.6167 10.5062H16.2723V8.67903H21.6167V10.5062Z" fill="#501614" />
                  </svg>

                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Pagination And Info Data -->
      <div class="flex flex-col-reverse md:flex-row lg:flex-row lg:justify-between md:justify-around lg:px-16 lg:mt-5 items-center mt-3 text-sm">
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
  </div>

  <script src="../js/jquery-3.6.1.min.js"></script>
  <script>
    // top_bar
    $('#top_bar').load("../assets/components/top_bar.php", function() {
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

    // load sidebar
    $("#ex-sidebar").load("../assets/components/sidebar.html", function() {
      $('#master_data').addClass("hover-sidebar");
      $('#button-logout').on('click', function() {
        $('#modalLogout').toggleClass("scale-0");
        $('#bgmodal').addClass("effectmodal");
      });
    });


    // load modal input
    $("#modal").load("../assets/components/modal_tambah_master_product_tambahan.html", function() {

      $("#btn_out").on("click", function() {
        $('#modal').addClass("scale-0");
        $('#bgmodal').removeClass("effectmodal");
      });

      $("#btn_batal").on("click", function() {
        $('#modal').addClass("scale-0");
        $('#bgmodal').removeClass("effectmodal");
      });

      $("#btn_tambah").on("click", function() {
        $('#modal').addClass("scale-0");
        $('#bgmodal').removeClass("effectmodal");
      });

    });

    // tab focus
    $('#tab_catalog').on("click", function() {
      $('#bgtab').removeClass("translate-x-0");
      $('#bgtab').addClass("translate-x-[83px]");
      $('#tab_catalog').addClass("tab-focus");
      $('#tab_table').removeClass("tab-focus");
      $('#table').addClass("hidden");
      $('#catalog').removeClass("hidden");
    });

    $('#tab_table').on("click", function() {
      $('#bgtab').removeClass("translate-x-[83px]");
      $('#bgtab').addClass("translate-x-0");
      $('#tab_catalog').removeClass("tab-focus");
      $('#tab_table').addClass("tab-focus");
      $('#table').removeClass("hidden");
      $('#catalog').addClass("hidden");
    });

    $('#bgmodal').on('click', function() {
      $('#modalLogout').toggleClass("scale-0");
      $('#bgmodal').removeClass("effectmodal");
    });

    $('#click-modal').on('click', function() {
      console.log("modal click");
      $('#modal').removeClass("scale-0");
      $('#bgmodal').addClass("effectmodal");
    });
  </script>
</body>

</html>
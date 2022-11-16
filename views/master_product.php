<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <style>
    .container-catalog::-webkit-scrollbar {
      display: none;
    }
  </style>
  <title>Master Data | WG Optical</title>
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

      <div class="bg-[#3DBD9E] w-[70px] md:w-[80px] text-center rounded-md py-1 text-white text-sm sm:text-lg">
        <p>Cancel</p>
      </div>
      <div class="bg-[#F35E58] w-[70px] md:w-[80px] text-center rounded-md py-1 text-white text-sm sm:text-lg">
        <p>Oke</p>
      </div>

    </div>
  </div>
  <!-- end modal logout -->

  <!-- modal -->
  <div class="fixed left-[50%] top-[50%] -translate-y-[50%] -translate-x-[50%] z-[51] scale-0 transition ease-in-out" id="modal">

  </div>
  <!-- end modal -->

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

        <h1>Master Data Product</h1>
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

    <div class="mt-3 flex items-center flex-col md:flex-row md:justify-around lg:justify-between lg:px-16 md:py-[3px]">

      <!-- Tab Bar -->
      <div class="w-44 box-border p-1.5 shadow-sm rounded-md flex justify-between flex-row text-sm font-ex-semibold bg-white">
        <div class="transition bg-[#343948] h-8 w-[80px] absolute rounded-md translate-x-0 ease-in-out" id="bgtab">
        </div>
        <div class="flex justify-center py-1.5 w-20 rounded-md tab-focus cursor-pointer" id="tab_table">Table</div>
        <div class="flex justify-center py-1.5 w-20 rounded-md cursor-pointer" id="tab_catalog">Catalog</div>
      </div>

      <!-- Search and Button Add -->
      <div class="flex flex-col md:flex-row items-center mt-3 md:mt-0">

        <!-- Search -->
        <div class="flex flex-row shadow-sm rounded-md items-center bg-white box-border px-2 md:mr-6">
          <svg width="19" height="19" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="ml-3">
            <path d="M19.2502 19.25L15.138 15.1305M17.4168 9.62501C17.4168 11.6915 16.5959 13.6733 15.1347 15.1346C13.6735 16.5958 11.6916 17.4167 9.62516 17.4167C7.55868 17.4167 5.57684 16.5958 4.11562 15.1346C2.6544 13.6733 1.8335 11.6915 1.8335 9.62501C1.8335 7.55853 2.6544 5.57669 4.11562 4.11547C5.57684 2.65425 7.55868 1.83334 9.62516 1.83334C11.6916 1.83334 13.6735 2.65425 15.1347 4.11547C16.5959 5.57669 17.4168 7.55853 17.4168 9.62501V9.62501Z" stroke="#797E8D" stroke-width="2" stroke-linecap="round" />
          </svg>

          <input type="text" placeholder="Type here" class="h-11 bg-transparent ml-2 outline-none" />
        </div>
        <!-- End Search -->

        <!-- Button Add -->
        <div class="md:my-auto h-10 w-24 font-ex-semibold text-white mt-3 md:mt-0" id="click-modal">
          <button class="bg-[#3DBD9E] h-full w-full rounded-md">Tambah</button>
        </div>
        <!-- End Button Add -->

      </div>
      <!-- End Search and Button Add -->

    </div>

    <!-- konten table -->
    <div class="" id="table">
      <!-- Table -->
      <div class="overflow-x-auto  text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 ex-table">
        <table class="w-full">
          <thead class="border-b-2 border-gray-100">
            <tr>
              <th class="p-3 text-sm tracking-wide text-center">No</th>
              <th class="p-3 text-sm tracking-wide text-center">Kode Frame</th>
              <th class="p-3 text-sm tracking-wide text-center">Harga Jual</th>
              <th class="p-3 text-sm tracking-wide text-center">Nama</th>
              <th class="p-3 text-sm tracking-wide text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="p-3 text-sm tracking-wide text-center">1</td>
              <td class="p-3 text-sm tracking-wide text-center">DLGH01</td>
              <td class="p-3 text-sm tracking-wide text-center">Kacamata Koboy</td>
              <td class="p-3 text-sm tracking-wide text-center">Rp. 50.000</td>
              <td class="p-3 text-sm tracking-wide text-center">
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
            <tr>
              <td class="p-3 text-sm tracking-wide text-center">1</td>
              <td class="p-3 text-sm tracking-wide text-center">DLGH01</td>
              <td class="p-3 text-sm tracking-wide text-center">Kacamata Koboy</td>
              <td class="p-3 text-sm tracking-wide text-center">Rp. 50.000</td>
              <td class="p-3 text-sm tracking-wide text-center">
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
            <tr>
              <td class="p-3 text-sm tracking-wide text-center">1</td>
              <td class="p-3 text-sm tracking-wide text-center">DLGH01</td>
              <td class="p-3 text-sm tracking-wide text-center">Kacamata Koboy</td>
              <td class="p-3 text-sm tracking-wide text-center">Rp. 50.000</td>
              <td class="p-3 text-sm tracking-wide text-center">
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
      <!-- End Table -->

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
    <!-- end konten table -->

    <!-- konten catalog -->
    <div class="hidden" id="catalog">
      <div class="container-catalog flex flex-row flex-wrap overflow-y-auto text-sm mx-auto w-[90%] md:w-[90%] md:mx-auto bg-white rounded-md mt-4 ex-catalog px-6 justify-between">


        <?php for ($i = 0; $i < 20; $i++) : ?>
          <!-- items -->
          <div class="w-[163px] h-[273px] shadow-md relative rounded-2xl overflow-hidden mt-4 mr-4">
            <div class="w-[163px] h-[163px] bg-red-100 rounded-2xl overflow-hidden">
              <img class="h-full" src="https://media.glasses.com/2022/PLATFORM/CLP/Virtual_Mirror/GL_CLP_Virtual_Mirror_02_D.jpg" alt="product image">
            </div>
            <div class="flex flex-col w-full h-full p-[13px]">
              <h3 class="uppercase text-[11px]">dlgh3</h3>
              <h2 class="font-ex-semibold text-[14px]">Rp.300.000</h2>
              <hr class="mt-3">
              <div class="flex flex-row justify-between py-2 items-center">
                <p class="text-[10px]">Stock : 20</p>
                <div class="flex flex-row">
                  <div class="flex items-center justify-center w-[25px] h-[25px] bg-[#EDC683] rounded-md mr-[11px]">
                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M13.3722 0.80805C13.5491 0.88139 13.7098 0.988883 13.8452 1.12438C13.9807 1.25974 14.0882 1.42048 14.1615 1.59741C14.2349 1.77434 14.2726 1.96399 14.2726 2.15552C14.2726 2.34704 14.2349 2.53669 14.1615 2.71362C14.0882 2.89055 13.9807 3.05129 13.8452 3.18665L11.8958 5.13551L9.83406 3.07381L11.7829 1.12438C11.9183 0.988883 12.079 0.88139 12.256 0.80805C12.4329 0.73471 12.6225 0.69696 12.8141 0.69696C13.0056 0.69696 13.1952 0.73471 13.3722 0.80805ZM0.979492 12.8487C0.979618 12.2591 1.21396 11.6936 1.63097 11.2767L9.04789 3.8598L11.1096 5.92151L3.69267 13.3384C3.27579 13.7554 2.71034 13.9898 2.12069 13.9899H0.979492V12.8487Z" fill="#3F2C0D" />
                    </svg>
                  </div>
                  <div class="flex items-center justify-center w-[25px] h-[25px] bg-[#F35E58] rounded-md">
                    <svg width="13" height="16" viewBox="0 0 13 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M9.26735 3.27949V2.01349C9.26735 1.67773 9.1373 1.35572 8.90582 1.1183C8.67434 0.880879 8.36037 0.747498 8.03301 0.747498H4.32997C4.0026 0.747498 3.68864 0.880879 3.45716 1.1183C3.22567 1.35572 3.09563 1.67773 3.09563 2.01349V3.27949H0.00976562V4.54548H1.24411V14.0404C1.24411 14.5441 1.43918 15.0271 1.78641 15.3832C2.13363 15.7394 2.60457 15.9394 3.09563 15.9394H9.26735C9.7584 15.9394 10.2293 15.7394 10.5766 15.3832C10.9238 15.0271 11.1189 14.5441 11.1189 14.0404V4.54548H12.3532V3.27949H9.26735ZM5.56432 11.5085H4.32997V7.71047H5.56432V11.5085ZM8.03301 11.5085H6.79866V7.71047H8.03301V11.5085ZM8.03301 3.27949H4.32997V2.01349H8.03301V3.27949Z" fill="#501614" />
                    </svg>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- items -->
        <?php endfor ?>

      </div>

    </div>
  </div>
  </div>
  <!-- konten catalog -->

  <script src="../js/jquery-3.6.1.min.js"></script>
  <script>
    // load sidebar
    $("#ex-sidebar").load("../assets/components/sidebar.html", function() {
      $('#master_data').addClass("hover-sidebar");
      $('#button-logout').on('click', function() {
        $('#modalLogout').toggleClass("scale-0");
        $('#bgmodal').addClass("effectmodal");
      });
    });

    // load modal input
    $("#modal").load("../assets/components/modal_tambah_master_product.html", function() {

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
      $('#table').toggleClass("hidden");
      $('#catalog').toggleClass("hidden");
    });

    $('#tab_table').on("click", function() {
      $('#bgtab').removeClass("translate-x-[83px]");
      $('#bgtab').addClass("translate-x-0");
      $('#tab_catalog').removeClass("tab-focus");
      $('#tab_table').addClass("tab-focus");
      $('#table').toggleClass("hidden");
      $('#catalog').toggleClass("hidden");
    });

    if ($(document).width() >= 1024) {
      $('#ex-sidebar').removeClass("ex-hide-sidebar");
    } else {
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
    }

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
<?php

include "../config/koneksi.php";
session_start();
if (!isset($_SESSION['statusLogin'])) {
  header('Location: login.php');
} else if ($_SESSION['level'] == 3) {
  header('Location: ../sales/dashboard.php');
}

$crud = new koneksi();

$imgDb = $crud->showData("SELECT img FROM image_landing");
$dataDB = $crud->showData("SELECT * FROM content_landing");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <link rel="stylesheet" href="../css/sweetalert2.min.css">
  <title>Document</title>
</head>

<body class="bg-[#F0F0F0] font-ex-color box-border">

  <!-- loading -->
  <!-- <div id="loading" class="fixed w-full h-full top-0 left-0 flex flex-col justify-center items-center bg-slate-50 z-[99]">
    <div class="loadingspinner"></div>
  </div> -->

  <div id="modalAddHeader"></div>

  <!-- sidebar -->
  <div id="sidebar" class="ex-sidebar ex-hide-sidebar fixed z-[51] max-lg:transition max-lg:duration-[1s]"></div>

  <!-- Background hitam saat sidebar show -->
  <div id="bgbody" class="w-full h-screen bg-black fixed z-[52] bg-opacity-50 hidden"></div>


  <div class="lg:ml-72">

    <!-- top bar -->
    <div id="topBar"></div>

    <!-- Tab Bar -->
    <!-- <div class="max-lg:flex max-lg:justify-center max-lg:items-center max-lg:w-screen">
      <div class="w-[264px] box-border p-1.5 shadow-sm rounded-md mt-[23px] lg:ml-[61px] flex justify-between flex-row text-sm font-ex-semibold bg-white">
        <div class="transition bg-[#343948] h-8 w-[80px] absolute rounded-md translate-x-0 ease-in-out" id="bgtab">
        </div>
        <div class="flex justify-center py-1.5 w-20 rounded-md tab-focus cursor-pointer" id="tab_header">Header</div>
        <div class="flex justify-center py-1.5 w-20 rounded-md cursor-pointer" id="tab_frame">Frame</div>
        <div class="flex justify-center py-1.5 w-20 rounded-md cursor-pointer" id="tab_lensa">Lensa</div>
      </div>
    </div> -->

    <!-- Header -->
    <div class="flex w-full lg:h-[75vh] my-[23px] justify-center items-center">
      <div class="flex lg:flex-row flex-col w-[93%] h-full rounded-lg bg-white shadow-md p-5">

        <!-- left -->
        <div class="flex flex-col max-md:items-center lg:h-full h-[400px] lg:w-[65%] border-2 rounded-md p-[10px] md:p-[20px] mb-[10px]">
          <button id="btn_add_header" onclick="showFoto()" class="bg-[#1C8066] hover:bg-[#145b48] transition ease-in-out text-white rounded-md p-2 w-40 mb-[10px] font-ex-medium">Tambah Gambar</button>
          <div class="w-full h-full flex flex-row flex-wrap overflow-y-auto gap-2 md:gap-4 max-md:justify-center scrollbar-hide">
            <?php $i = 1; ?>
            <?php foreach ($imgDb as $index) : ?>
              <div class="relative max-md:w-full max-[1023px]:w-[31%] w-[30%] max-lg:h-[50%] h-[30%] overflow-hidden rounded-md">
                <div id="hapus_gambar<?= $i ?>" class="absolute flex justify-center items-center w-full h-full bg-black opacity-50">

                  <svg onclick="delete_img('<?= $index['img'] ?>')" class="cursor-pointer" id="hapus<?= $i ?>" width="25" height="27" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.25 2.83333V1.41667C11.25 1.04094 11.092 0.680609 10.8107 0.414932C10.5294 0.149256 10.1478 0 9.75 0L5.25 0C4.85218 0 4.47064 0.149256 4.18934 0.414932C3.90804 0.680609 3.75 1.04094 3.75 1.41667V2.83333H0V4.25H1.5V14.875C1.5 15.4386 1.73705 15.9791 2.15901 16.3776C2.58097 16.7761 3.15326 17 3.75 17H11.25C11.8467 17 12.419 16.7761 12.841 16.3776C13.2629 15.9791 13.5 15.4386 13.5 14.875V4.25H15V2.83333H11.25ZM6.75 12.0417H5.25V7.79167H6.75V12.0417ZM9.75 12.0417H8.25V7.79167H9.75V12.0417ZM9.75 2.83333H5.25V1.41667H9.75V2.83333Z" fill="white" />
                  </svg>

                </div>
                <img src="../images/landing/<?= $index['img'] ?>" id="img-<?= $i ?>" onmouseover="mouseIn('img-<?= $i ?>', 'hapus_gambar<?= $i ?>')" class="transition ease-in-out absolute w-full h-full object-cover">
              </div>
              <?php $i++ ?>
            <?php endforeach ?>
          </div>
        </div>

        <!-- right -->
        <div class="flex flex-col lg:h-full h-[400px] lg:w-[35%] justify-between lg:pl-5 max-lg:mt-5">

          <input id="header" type="text" class="outline-none h-[15%] w-full border-2 rounded-md p-3" value="<?= $dataDB[0]['header'] ?>">

          <textarea id="description" class="w-full h-[60%] outline-none border-2 rounded-md p-3"><?= $dataDB[0]['description'] ?></textarea>

          <div onclick="hahai()" class="cursor-pointer flex justify-center items-center text-white font-ex-semibold h-[16%] w-full rounded-md bg-[#393e4c] hover:bg-[#343948]">
            Apply
          </div>

        </div>

      </div>
    </div>

  </div>

  <script src="../js/jquery-3.6.1.min.js"></script>
  <script src="../js/sweetalert2.min.js"></script>
  <script>
    //Modal Header
    $('#modalAddHeader').load("../assets/components/up_img_landing_header.html", function() {
      $('#btn_add_header').on('click', function() {

        // reset_header();
      });

      $('#btnOutHeader').on('click', function() {
        $('#modalImgHeader').addClass('scale-0');
        $('#bgmodalinput').removeClass("effectmodal");
      });

      $('#btn_out').on('click', function() {
        $('#modalImgHeader').addClass('scale-0');
        $('#bgmodalinput').removeClass("effectmodal");
      });

      imgInp.onchange = evt => {
        const [file] = imgInp.files
        console.log(file);
        if (file) {
          console.log("masuk");
          imgpreview_peg.src = URL.createObjectURL(file);
          $('#imgpreview_peg').removeClass("hidden");
          $('#imgdefault_peg').addClass("hidden");
        }
      }

    });


    function resetImg() {
      $('#imgInp').val(null);
      imgpreview_peg.src = "#";
      $('#imgpreview_peg').addClass("hidden");
      $('#imgdefault_peg').removeClass("hidden");
    }

    function hahai() {
      let description = $('#description').val();
      let header = $('#header').val();
      Swal.fire({
        icon: 'question',
        title: 'Apakah anda yakin?',
        text: "",
        showDenyButton: true,
        confirmButtonText: 'Ya',
        denyButtonText: `Batal`,
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "post",
            url: "../controllers/landingController.php",
            data: {
              "type": "update",
              "query": "UPDATE content_landing SET header='"+header+"',description='"+description+"' WHERE id_landing = 'landing1'",
            },
            beforeSend: function() {
              loading = Swal.fire({
                title: 'Loading',
                html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
                allowOutsideClick: false,
                showConfirmButton: false,
              });
            },
            success: function(res) {
              loading.close();
              const data = JSON.parse(res);
              if (data.status == "error") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: data.msg,
                })
              } else {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: data.msg,
                }).then(function() {
                  window.location.replace("setting_landing.php");
                });
              }

            }
          });
        } else if (result.isDenied) {

        }
      })
      // console.log("aowkokawokoaw");
    }

    function showFoto() {
      $('#modalImgHeader').removeClass('scale-0');
      $('#bgmodalinput').addClass("effectmodal");
      resetImg();

      $('#btn_upload').on('click', function(e) {

        e.preventDefault()
        let formData = new FormData();
        let imgProduk = $('#imgInp')[0].files;

        if (!imgProduk.length > 0) {
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "Anda Belum mengupload gambar",
          })
        } else {
          formData.append('image_produk', imgProduk[0]);
          formData.append('type', "up_bukti");

          var img_name_landing = formData.get('image_produk')['name'];
          var generateUniqProduk = "<?php echo uniqid('landing-', true) . '.' . '"+getFileExtension(img_name_landing).toLowerCase()+"' ?>";

          formData.append('img_file_produk', generateUniqProduk);
          // formData.append("query", "UPDATE transaksi SET bukti_pengiriman = '" + generateUniqProduk + "' WHERE kode_pesanan = '" + id + "'");
          formData.append("query", "INSERT INTO image_landing VALUES ('landing1','" + generateUniqProduk + "')");

          $.ajax({
            type: "post",
            url: "../controllers/landingController.php",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
              loading = Swal.fire({
                title: 'Loading',
                html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
                allowOutsideClick: false,
                showConfirmButton: false,
              });
            },
            success: function(res) {
              loading.close();
              const data = JSON.parse(res);

              if (data.status == "error") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: data.msg,
                })
              } else {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: data.msg,
                }).then(function() {
                  window.location.replace("setting_landing.php");
                });
              }

            }
          });

        }


      });
    }

    function getFileExtension(fstring) {
      return fstring.slice((Math.max(0, fstring.lastIndexOf(".")) || Infinity) + 1);
    }

    // load sidebar
    $('#sidebar').load("../assets/components/sidebar.html", function() {

    });

    // load topBar
    $('#topBar').load("../assets/components/top_bar.php", function() {
      $('#title-header').html('Master Data Product');
      $("#burger").on("click", function() {
        $('#bgbody').toggleClass("hidden");

        $('#sidebar').toggleClass("ex-hide-sidebar");
        $('#burger').toggleClass("show");
      });

      $("#bgbody").on("click", function() {
        $('#sidebar').toggleClass("ex-hide-sidebar");
        $('#burger').toggleClass("show");

        $('#bgbody').toggleClass("hidden");

      });

      $('#loading').hide();
    });


    // tab focus
    $('#tab_frame').on("click", function() {
      $('#bgtab').removeClass("translate-x-0");
      $('#bgtab').addClass("translate-x-[85px]");
      $('#bgtab').removeClass("translate-x-[171px]");
      $('#tab_frame').addClass("tab-focus");
      $('#tab_header').removeClass("tab-focus");
      $('#tab_lensa').removeClass("tab-focus");
    });

    $('#tab_header').on("click", function() {
      $('#bgtab').removeClass("translate-x-[85px]");
      $('#bgtab').addClass("translate-x-0");
      $('#bgtab').removeClass("translate-x-[171px]");
      $('#tab_frame').removeClass("tab-focus");
      $('#tab_header').addClass("tab-focus");
      $('#tab_lensa').removeClass("tab-focus");
    });

    $('#tab_lensa').on("click", function() {
      $('#bgtab').removeClass("translate-x-[85px]");
      $('#bgtab').removeClass("translate-x-0");
      $('#bgtab').addClass("translate-x-[171px]");
      $('#tab_frame').removeClass("tab-focus");
      $('#tab_header').removeClass("tab-focus");
      $('#tab_lensa').addClass("tab-focus");
    });

    function mouseIn(name_class, name_class_delete) {
      $('#' + name_class).addClass("scale-110");
      $('#' + name_class_delete).addClass("z-[31]");
    }

    function mouseOut(name_class, name_class_delete) {
      $('#' + name_class).removeClass("scale-110");
      $('#' + name_class_delete).removeClass("z-[31]");
    }

    function delete_img(id) {
      Swal.fire({
        icon: 'question',
        title: 'Apakah anda yakin?',
        showDenyButton: true,
        confirmButtonText: 'Ya',
        denyButtonText: `Batal`,
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "post",
            url: "../controllers/landingController.php",
            data: {
              "type": "delete",
              "imgPath": id,
              "query": "DELETE FROM image_landing WHERE img = '" + id + "'",
            },
            beforeSend: function() {
              loading = Swal.fire({
                title: 'Loading',
                html: '<div class="body-loading"><div class="loadingspinner"></div></div>', // add html attribute if you want or remove
                allowOutsideClick: false,
                showConfirmButton: false,
              });
            },
            success: function(res) {
              loading.close();
              const data = JSON.parse(res);
              if (data.status == "error") {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: data.msg,
                })
              } else {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: data.msg,
                }).then(function() {
                  window.location.replace("setting_landing.php");
                });
              }

            }
          });
        } else if (result.isDenied) {

        }
      })
    }

    var data_delete = [];

    for (var i = 1; i <= 10; i++) {

      data_delete.push({
        "img": 'img-' + i,
        "hapus_gambar": 'hapus_gambar' + i,
      });
    }

    for (var i = 0; i <= data_delete.length; i++) {
      let index = i;
      $('#' + data_delete[i]["hapus_gambar"]).mouseleave(function() {
        var img = data_delete[index]["img"];
        var icon = data_delete[index]["hapus_gambar"];
        mouseOut(img, icon);
      })
    }

    // console.log(data_delete);

    function ppp(id) {
      alert(id);
    }
  </script>
</body>

</html>
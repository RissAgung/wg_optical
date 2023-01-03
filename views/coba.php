<?php
date_default_timezone_set("Asia/Bangkok");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  <button onclick="pelli()">Coba</button>
  <h1 id="resultarea"></h1>

  <script src="../js/jquery-3.6.1.min.js"></script>
  <script>

    function pelli() {
      $.ajax({
        type: "post",
        url: "../config/koneksi.php",
        data: {
          nama: "risqi"
        },
        cache: false,
        success: function(data) {
          $("#resultarea").text(data);
        }
      });
    }

  </script>
</body>

</html>
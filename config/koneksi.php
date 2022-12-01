<?php

$kon = new Koneksi();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($_POST['type'] == 'pegawai') {
    // echo $_POST['query'];

    if ($kon->insertData($_POST['query'])) {
      echo 'berhasil';
    } else {
      echo 'error';
      // echo $_POST['query'];
      // }
    }
  }
}


class koneksi
{
  private $server = "mphstar.com";
  private $username = "mphstar";
  private $password = "123";
  private $db = "wgoptical";

  private function prepareKoneksi()
  {
    return mysqli_connect($this->server, $this->username, $this->password, $this->db);
  }

  private function execute($new_query)
  {
    return mysqli_query($this->prepareKoneksi(), $new_query);
  }

  public function insertData($query)
  {
    $result = $this->execute($query);
  }

  public function showData($query)
  {
    $result = $this->execute($query);
    $datas = [];
    while ($data = mysqli_fetch_assoc($result)) {
      $datas[] = $data;
    }

    return $datas;
  }
}

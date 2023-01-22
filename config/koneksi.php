<?php

class koneksi
{
<<<<<<< HEAD
  private $server = "mphstar.com";
=======
  private $server = "hamsyong.cuy";
>>>>>>> 4baddf21edb6a5e0d6102a98e5117279f700ee6d
  private $username = "root";
  private $password = "123";
  private $db = "wgoptical";

  public function prepareKoneksi()
  {
    return mysqli_connect($this->server, $this->username, $this->password, $this->db);
  }

  public function execute($new_query)
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

<?php

$kon = new koneksi();

if(isset($_POST["type"])){
  if($_POST["type"] == "insert"){
    $kon -> execute($_POST["query"]);
  }

  if($_POST["type"] == "delete"){
    $kon -> execute($_POST["query"]);
  }
  
  if($_POST["type"] == "update"){
    $kon -> execute($_POST["query"]);
  }
}

class koneksi {

    private $server="localhost";
    private $username = "root";
    private $password= "";
    private $db= "wgoptical";

    public function prepareKoneksi(){
        return mysqli_connect($this->server, $this->username, $this->password, $this->db);
    }

    public function execute($new_query)
    {
      return mysqli_query($this->prepareKoneksi(), $new_query);
    }

    public function showData($query){
      $result = $this->execute($query);
      $datas = [];
      while($data = mysqli_fetch_assoc($result)){
        $datas[] = $data;
      }

      return $datas;
    }
}

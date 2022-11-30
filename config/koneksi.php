<?php

class koneksi {
    private $server="localhost";
    private $username = "root";
    private $password= "";
    private $db= "wgoptical";

    public function prepareKoneksi(){
        return mysqli_connect($this->server, $this->username, $this->password, $this->db);
    }
}
?>

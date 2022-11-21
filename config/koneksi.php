<?php

class koneksi {
    private $server="mphstar.com";
    private $username = "mphstar";
    private $password= "123";
    private $db= "wgoptical";

    public function prepareKoneksi(){
        return mysqli_connect($this->server, $this->username, $this->password, $this->db);
    }
}
?>

<?php

class crud extends koneksi
{
    public function execute($new_query)
    {
        return mysqli_query($this->prepareKoneksi(), $new_query);
    }
}

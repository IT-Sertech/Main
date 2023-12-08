<?php

namespace Modules\Main\Plugins;

class getImageCDN {

    /**
    * @param string $img
    * @param int $size
    * @return string
     */
    public function process(string $img, int $size):string{
        return "https://cdn.example.de".$img."?".$size;
    }
}

<?php

namespace Modules\Main\Plugins;

class getWebp {

    /**
     * @param string $source
     * @param int $quality
     * @param bool $removeOld
     * @return string
     */
    public function process(string $source, int $quality = 100, bool $removeOld = false): string {
        $dir = pathinfo($source, PATHINFO_DIRNAME);
        $name = pathinfo($source, PATHINFO_FILENAME);
        $destination = $dir.DIRECTORY_SEPARATOR.$name.'.webp';

        if (!file_exists(WEB_ROOT_DIR.$destination)){
            $info = getimagesize(WEB_ROOT_DIR.$source);
            $isAlpha = false;
            if ($info['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg(WEB_ROOT_DIR.$source);
            }
            elseif ($isAlpha = $info['mime'] == 'image/gif') {
                $image = imagecreatefromgif(WEB_ROOT_DIR.$source);
            } elseif ($isAlpha = $info['mime'] == 'image/png') {
                $image = imagecreatefrompng(WEB_ROOT_DIR.$source);
            } else {
                return $source;
            }
            if ($isAlpha) {
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }
            imagewebp($image, WEB_ROOT_DIR.$destination, $quality);
            if ($removeOld) {
                unlink($source);
            }
        }

        return $destination;
    }

}

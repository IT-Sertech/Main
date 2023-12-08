<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Plugins;

class FileModified {

    /**
     * @param string $variable
     * @return string
     */
    public function process(string $variable): string {
        $path = WEB_ROOT_DIR.$variable;
        if (file_exists($path)) {
            return $variable.'?ver='.filemtime($path);
        }
        return $variable;
    }

}

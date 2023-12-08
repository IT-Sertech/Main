<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Plugins;

class getDay {

    /**
     * @param string|null $date
     * @return string
     */
    public function process(string $date = null): string {
        if ($date===null) {
            $date = date("d.m.Y");
        }
        return date("d", strtotime($date));
    }

}

<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Plugins;

class getYear {

    /**
     * @param string|null $date
     * @return int
     */
    public function process(string $date = null): int {
        if ($date===null) {
            $date = date("Y");
        }
        else {
            $date = date("Y", strtotime($date));
        }
        return $date;
    }

}

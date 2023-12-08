<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Plugins;

class DateTime {

    /**
     * @param string|null $date
     * @param bool $todayOnlyTime
     * @return string
     */
    public function process(string $date = null, bool $todayOnlyTime = true): string {
        $today = date("d.m.Y ", time());
        $dateTime = date("d.m.Y H:i", strtotime($date));
        if ($todayOnlyTime){
            $dateTime = str_replace($today, "", $dateTime);
        }
        return $dateTime;
    }

}

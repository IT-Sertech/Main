<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Plugins;

class getWeekDay {

    /**
     * @var string[][]
     */
    private $weekDay = [
        'en'=>[
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
        ],
        'de'=>[
            'Sonntag',
            'Montag',
            'Dienstag',
            'Mittwoch',
            'Donnerstag',
            'Freitag',
            'Samstag',
        ]
    ];

    /**
     * @param string $date
     * @param string $lang
     * @return string
     */
    public function process(string $date = null, string $lang = 'de'): string {
        if ($date===null) {
            $date = date("d.m.Y");
        }
        return $this->weekDay[$lang][date("w", strtotime($date))];
    }
}

<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Plugins;

class getMonth {

    /**
     * @var string[][]
     */
    private $month = [
        'en'=>[
            '01'=>'January',
            '02'=>'February',
            '03'=>'March',
            '04'=>'April',
            '05'=>'May',
            '06'=>'June',
            '07'=>'July',
            '08'=>'August',
            '09'=>'September',
            '10'=>'October',
            '11'=>'November',
            '12'=>'December',
        ],
        'de'=>[
            '01'=>'Januar',
            '02'=>'Februar',
            '03'=>'März',
            '04'=>'April',
            '05'=>'Mai',
            '06'=>'Juni',
            '07'=>'Juli',
            '08'=>'August',
            '09'=>'September',
            '10'=>'Oktober',
            '11'=>'November',
            '12'=>'Dezember',
        ]
    ];

    /**
     * @param string|null $date
     * @param string $lang
     * @return string
     */
    public function process(string $date = null, string $lang = 'de'): string {
        if ($date===null) {
            $date = date("d.m.Y");
        }
        return $this->month[$lang][date("m", strtotime($date))];
    }

}

<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Plugins;

class getShortMonth {

    /**
     * @var string[][]
     */
    private $month = [
        'en'=>[
            '01'=>'Jan',
            '02'=>'Feb',
            '03'=>'Mar',
            '04'=>'Apr',
            '05'=>'May',
            '06'=>'Jun',
            '07'=>'Jul',
            '08'=>'Aug',
            '09'=>'Sep',
            '10'=>'Oct',
            '11'=>'Nov',
            '12'=>'Dec',
        ],
        'de'=>[
            '01'=>'Jan',
            '02'=>'Feb',
            '03'=>'Mär',
            '04'=>'Apr',
            '05'=>'Mai',
            '06'=>'Jun',
            '07'=>'Jul',
            '08'=>'Aug',
            '09'=>'Sep',
            '10'=>'Okt',
            '11'=>'Nov',
            '12'=>'Dez',
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

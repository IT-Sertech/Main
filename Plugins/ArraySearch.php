<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Plugins;

class ArraySearch {

    /**
     * @param mixed $needle
     * @param array $haystack
     * @param bool $strict
     * @return int|string|false
     */
    public function process(mixed $needle,  array $haystack, bool $strict = false): int|string|false {
        return array_search($needle, $haystack, $strict);
    }

}

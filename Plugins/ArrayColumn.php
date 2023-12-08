<?php

namespace Modules\Main\Plugins;

class ArrayColumn {

    /**
     * @param array $array
     * @param int|string|null $column_key
     * @param int|string|null $index_key
     * @return array
     */
    public function process(array $array, int|string|null $column_key, int|string|null $index_key = null): array {
        return array_column($array, $column_key, $index_key);
    }

}

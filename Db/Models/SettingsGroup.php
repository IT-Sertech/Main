<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Db\Models;

use Illuminate\Database\Eloquent\Collection;
use Modules\Database\Model;

class SettingsGroup extends Model {

    protected $table = "settings_group";

    public function getSetting(string $key): object|null {
        return $this->hasMany('Modules\Main\Db\Models\Settings')->where('key', '=', $key)->first();
    }

    /**
     * @return Collection
     */
    public function getSettings(): Collection {
        return $this->hasMany('Modules\Main\Db\Models\Settings')->get();
    }

}

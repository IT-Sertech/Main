<?php

namespace Modules\Main\Plugins;

use DI\DependencyException;
use DI\NotFoundException;
use Modules\Main\MainTrait;
use Modules\View\AbstractPlugin;

class getActiveActions extends AbstractPlugin {

    use MainTrait;

    /**
     * @return mixed
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function process(): mixed {
        return $this->getMainManager()
            ->getActionsEntity()::where('status', '=', 1)->OrderBy('id', 'DESC')->get();
    }
}
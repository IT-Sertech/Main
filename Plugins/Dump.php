<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Plugins;

use DI\DependencyException;
use DI\NotFoundException;
use Modules\View\AbstractPlugin;
use Modules\View\ViewManager;
use Tracy\Dumper;

class Dump extends AbstractPlugin {

    /**
     * @var array|false[]
     */
    protected array $options = [
        Dumper::LAZY=>false,
        Dumper::LOCATION=>false,
        //Dumper::THEME=>'dark'
    ];

    /**
     * @param mixed $var
     * @return void
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function process(mixed $var = "all"): void {
        if ($var === "all") {
            /** @var ViewManager $view */
            $view = $this->getContainer()->get('ViewManager::View');
            Dumper::dump($view->getVariables(), $this->options);
        }
        else Dumper::dump($var, $this->options);
    }
}

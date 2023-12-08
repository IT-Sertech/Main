<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main;

use Core\Module\Provider;
use DI\DependencyException;
use DI\NotFoundException;
use Modules\Database\MigrationCollection;
use Modules\Main\Console\Minify;
use Modules\Main\Console\ProcessCheck;
use Modules\Main\Db\Schema;
use Modules\Main\Manager\MainManager;
use Modules\Main\Manager\MainModel;
use Modules\View\PluginManager;
use Modules\View\ViewManager;

class ServiceProvider extends Provider {

    /**
     * @var array|string[]
     */
    protected array $plugins = [
        'dump' => '\Modules\Main\Plugins\Dump',
        'fileModified' => '\Modules\Main\Plugins\FileModified',
        'getDay'=>'\Modules\Main\Plugins\getDay',
        'getWeekDay'=>'\Modules\Main\Plugins\getWeekDay',
        'getMonth'=>'\Modules\Main\Plugins\getMonth',
        'getShortMonth'=>'\Modules\Main\Plugins\getShortMonth',
        'getYear'=>'\Modules\Main\Plugins\getYear',
        'date'=>'\Modules\Main\Plugins\Date',
        'dateTime'=>'\Modules\Main\Plugins\DateTime',
        'getWebp' => '\Modules\Main\Plugins\getWebp',
        'md5' => '\Modules\Main\Plugins\MD5',
        'array_search' => '\Modules\Main\Plugins\ArraySearch',
        'array_column' => '\Modules\Main\Plugins\ArrayColumn',
        'getActiveActions' => '\Modules\Main\Plugins\getActiveActions',
        'getParentPages'=>'\Modules\Main\Plugins\getParentPages',
        'getSetting'=>'\Modules\Main\Plugins\getSetting',
        'getImageCDN'=>'\Modules\Main\Plugins\getImageCDN',
    ];

    /**
     * @return string[]
     */
    public function console(): array {
        return [
            ProcessCheck::class,
            Minify::class
        ];
    }

    /**
     * @return void
     */
    public function init(): void {
        $container = $this->getContainer();
        if (!$container->has('Main\Router')){
            $container->set('Main\Router', function(){
                return new Router($this);
            });
        }

        /*if (!$container->has('Main\DashboardRouter')){
            $container->set('Main\DashboardRouter', function(){
                return new DashboardRouter($this);
            });
        }*/

        if (!$container->has('Main\ApiRouter')){
            $container->set('Main\ApiRouter', function(){
                return new ApiRouter($this);
            });
        }
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function afterInit(): void {
        $container = $this->getContainer();
        if ($container->has('Modules\Database\ServiceProvider::Migration::Collection')) {
            /* @var $databaseMigration MigrationCollection  */
            $container->get('Modules\Database\ServiceProvider::Migration::Collection')->add(new Schema($this));
        }

        if (!$container->has('Main\Manager')) {
            $this->getContainer()->set('Main\Manager', function(){
                $manager = new MainManager($this);
                return $manager->initEntity();
            });
        }

        $container->set('Main\Model', function () {
            return new MainModel($this);
        });

        if ($container->has('ViewManager::View')) {
            /** @var $viewer ViewManager */
            $viewer = $container->get('ViewManager::View');
            $plugins = function(){
                $pluginManager = new PluginManager();
                $pluginManager->addPlugins($this->plugins);
                return $pluginManager->getPlugins();
            };
            $viewer->setPlugins($plugins());
        }
    }

    public function boot(): void {
        $container = $this->getContainer();
        $container->set('Modules\Main\Controller\IndexController', function(){
            return new Controller\IndexController($this);
        });

        /*$container->set('Modules\Main\Controller\DashboardController', function(){
            return new Controller\DashboardController($this);
        });*/

        $container->set('Modules\Main\ApiController\IndexController', function(){
            return new ApiController\IndexController($this);
        });
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function register(): void {
        $container = $this->getContainer();

        if ($container->has('Main\Router')){
            $container->get('Main\Router')->init();
        }

        if ($container->has('Main\ApiRouter')){
            $container->get('Main\ApiRouter')->init();
        }
    }

}

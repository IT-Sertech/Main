<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Manager;

use Core\Traits\App;
use DI\DependencyException;
use DI\NotFoundException;

class MainManager {

    use App;

    /**
     * @var string
     */
    private string $page = "Main\Page";

    /**
     * @var string
     */
    private string $landingPage = "Main\LandingPage";

    /**
     * @var string
     */
    private string $settings = "Main\Settings";

    /**
     * @var string
     */
    private string $settingsGroup = "Main\SettingsGroup";

    /**
     * @var string
     */
    private string $actions = "Main\Actions";

    /**
     * @return $this
     */
    public function initEntity(): static {
        if (!$this->getContainer()->has($this->page)){
            $this->getContainer()->set($this->page, function(){
                return 'Modules\Main\Db\Models\Page';
            });
        }

        if (!$this->getContainer()->has($this->landingPage)){
            $this->getContainer()->set($this->landingPage, function(){
                return 'Modules\Main\Db\Models\LandingPage';
            });
        }

        if (!$this->getContainer()->has($this->settings)){
            $this->getContainer()->set($this->settings, function(){
                return 'Modules\Main\Db\Models\Settings';
            });
        }

        if (!$this->getContainer()->has($this->settingsGroup)){
            $this->getContainer()->set($this->settingsGroup, function(){
                return 'Modules\Main\Db\Models\SettingsGroup';
            });
        }

        if (!$this->getContainer()->has($this->actions)){
            $this->getContainer()->set($this->actions, function(){
                return 'Modules\Main\Db\Models\Actions';
            });
        }
        return $this;
    }

    /**
     * @return string|null
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function getPageEntity(): string|null {
        return $this->getContainer()->get($this->page);
    }

    /**
     * @return string|null
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function getLandingPageEntity(): string|null {
        return $this->getContainer()->get($this->landingPage);
    }

    /**
     * @return string|null
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function getSettingsEntity(): string|null {
        return $this->getContainer()->get($this->settings);
    }

    /**
     * @return string|null
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function getSettingsGroupEntity(): string|null {
        return $this->getContainer()->get($this->settingsGroup);
    }

    /**
     * @return string|null
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function getActionsEntity(): string|null {
        return $this->getContainer()->get($this->actions);
    }

}

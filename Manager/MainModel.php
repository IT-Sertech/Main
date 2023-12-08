<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Manager;

use DI\DependencyException;
use DI\NotFoundException;
use Modules\Main\MainTrait;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Http\ServerRequest as Request;

class MainModel {

    use MainTrait;

    private array $chars = [
        'ö', 'ä', 'ü', 'ß', 'Ö', 'Ä', 'Ü', ' ', '_', '#', '.'
    ];

    private array $replace_chars = [
        'oe', 'ae', 'ue', 'ss', 'Oe', 'Ae', 'Ue', '-', '-', '-', '-'
    ];

    public function changeChars(string $title = ''): string {
        $title = str_replace($this->chars, $this->replace_chars, $title);
        return strtolower($title);
    }

    /**
     * @return string
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function getLang(): string {
        $lang = 'de';
        if ($this->getContainer()->has('Session\Manager')){
            $session = $this->getContainer()->get('Session\Manager');
            if ($session->has('lang')){
                $lang=$session->get('lang');
            }
        }
        else {
            $config = $this->getContainer()->get('config')->getSetting('lang');
            if (!empty($config) && isset($config['default'])){
                $lang=$config['default'];
            }
        }
        return $lang;
    }

    /**
     * @param int $page_id
     * @return array
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function getParents(int $page_id): array {
        $parents = [];
        $page = $this->getMainManager()->getPageEntity()::select('id', 'name', 'title', 'parent_id')->find($page_id);
        if ($page->parent_id !== 0){
            $parent_page = $this->getMainManager()
                ->getPageEntity()::select('id', 'name', 'title', 'parent_id')->find($page->parent_id);
            $check_parent = $this->getParents($page->parent_id);
            $parents[$parent_page->title] = ['main_page', ['page'=>$parent_page->name]];
            if (!empty($check_parent)){
                $parents = array_merge($check_parent, $parents);
            }
        }
        return $parents;
    }
}

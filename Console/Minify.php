<?php

namespace Modules\Main\Console;

use Core\Console\Command;
use Modules\Main\MainTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Minify extends Command {

    use MainTrait;

    public function __construct($application) {
        parent::__construct($application);
    }

    /**
     * @return void
     */
    protected function configure(): void {
        $this->setName('main:minify')
            ->setDescription("Minify CSS und JS on active template");
    }

    protected function execute (InputInterface $input, OutputInterface $output): int {
        return 1;
    }

}
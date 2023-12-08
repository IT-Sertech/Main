<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\Console;

use Core\Console\Command;
use DI\DependencyException;
use DI\NotFoundException;
use Modules\Main\MainTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessCheck extends Command {

    use MainTrait;

    protected mixed $config;

    public function __construct($application) {
        parent::__construct($application);
    }

    public function configure(): void {
        $this->setName('process_check')->setDescription('Proccessen Checker für Queue, Import, Mail, Bestellungen');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws DependencyException
     * @throws NotFoundException
     */
    protected function execute (InputInterface $input, OutputInterface $output): int {
        $this->config = $this->getContainer()->get('config')->getSetting('process');

        $list = [];
        if (is_array($this->config['list'])) {
            $list = $this->config['list'];
        }
        $this->check($list);
        return 1;
    }

    protected function start($process) {
        $type = explode(':', $process);
        if (count($type)>1) {
            $name = $type[1];
        }
        else {
            $name = $type[0];
        }
        $process_logs_path = realpath(__DIR__."/../../../").$this->config['logs'];
        if (!is_dir($process_logs_path)) {
            mkdir($process_logs_path, 0755);
        }
        if (!is_dir($process_logs_path."/".$name)) {
            mkdir($process_logs_path . "/" . $name, 0755);
        }
        $process_logs_path.="/".$name."/".$name;
        exec(
            "php console ".$process." >".$process_logs_path."_log.log 2>".$process_logs_path."_error.log &", 
            $out
        );
        sleep(1);
    }

    protected function check(array $process_liste = []){
        putenv("COLUMNS=1000");
        exec("ps -ax | grep 'console' | grep -v grep", $out);
        foreach ($out as $tmp_process){
            preg_match('/\d+/', $tmp_process, $match);
            $name = explode(' ', $tmp_process);
            $tmp[$name[(count($name)-1)]]=[
                'pid'=> $match[0] ?? false,
            ];
        }

        foreach ($process_liste as $process){
            if (isset($tmp[$process])) {
                $this->info($process . " PID: " . $tmp[$process]['pid']);
            }
            else {
                $this->error("Process \"".$process."\" is not running");
                $this->start($process);
            }
        }
    }

}

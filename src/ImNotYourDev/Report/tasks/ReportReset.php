<?php

namespace ImNotYourDev\Report\tasks;

use pocketmine\scheduler\Task;
use pocketmine\utils\Config;

class ReportReset extends Task
{
    public function onRun(int $currentTick)
    {
        $cfg = new Config("/reports/inf.yml", Config::YAML);
        $cfg->set("new", false);
        $cfg->save();
    }
}
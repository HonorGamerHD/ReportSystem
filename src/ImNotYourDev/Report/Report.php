<?php

namespace ImNotYourDev\Report;

use ImNotYourDev\Report\commands\ReportCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Report extends PluginBase
{
    public static $instance;
    public $prefix;

    public function onEnable()
    {
        self::$instance = $this;
        $this->saveResource("config.yml");
        $this->prefix = $this->getPluginConfig()->get("prefix");
        $this->getLogger()->info($this->prefix . "ReportSystem by ImNotYourDev enabled!");
        $this->getServer()->getCommandMap()->register("report", new ReportCommand("report"));
    }

    /**
     * @return Report
     */
    public static function getInstance() : Report
    {
        return self::$instance;
    }

    /**
     * @return Config
     */
    public function getPluginConfig() : Config
    {
        return new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    /**
     * @return array
     */
    public function getReportList() : array
    {
        $cfg = new Config($this->getDataFolder() . "reports.yml", Config::YAML);
        return $cfg->getAll();
    }

    /**
     * @param String $reportname
     * @param String $reporter
     * @param String $playername
     * @param String $desc
     * @param String $notizen
     */
    public function saveReport(String $reportname, String $reporter, String $playername, String $desc, String $notizen)
    {
        $cfg = new Config($this->getDataFolder() . "reports.yml", Config::YAML);
        $report = [
            "name" => $reportname,
            "reporter" => $reporter,
            "player" => $playername,
            "desc" => $desc,
            "notes" => $notizen
        ];
        $int = count($cfg->getAll()) + 1; //no overwrite
        $cfg->setNested("reports.$reportname$int", $report);
        $cfg->save();
    }
}
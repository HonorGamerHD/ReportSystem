<?php

namespace ImNotYourDev\Report;

use ImNotYourDev\Report\commands\AdminCommand;
use ImNotYourDev\Report\commands\ReportCommand;
use ImNotYourDev\Report\commands\ReportListCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Report extends PluginBase
{
    public static $instance;
    public $prefix;
    public $mode = "local";

    public function onEnable()
    {
        self::$instance = $this;
        $this->saveResource("config.yml");
        $this->mode = $this->getPluginConfig()->get("mode");
        $this->prefix = $this->getPluginConfig()->get("prefix");
        if($this->mode == "global"){
            @mkdir("/reports/");
        }
        $this->getLogger()->info($this->prefix . "ReportSystem by ImNotYourDev enabled!");
        $this->getLogger()->info("§7System mode: §e" . $this->mode);
        $this->getServer()->getCommandMap()->register("report", new ReportCommand("report"));
        $this->getServer()->getCommandMap()->register("reportadmin", new AdminCommand("reportadmin"));
        $this->getServer()->getCommandMap()->register("reportlist", new ReportListCommand("reportlist"));
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
        if($this->mode == "local"){
            $cfg = new Config($this->getDataFolder() . "reports.yml", Config::YAML);
            return $cfg->get("reports", []);
        }else{
            $cfg = new Config("/reports/reports.yml", Config::YAML);
            return $cfg->get("reports", []);
        }
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
        if($this->mode == "local"){
            $cfg = new Config($this->getDataFolder() . "reports.yml", Config::YAML);
            $report = [
                "name" => $reportname,
                "reporter" => $reporter,
                "player" => $playername,
                "desc" => $desc,
                "notes" => $notizen
            ];
            $int = count($cfg->get("reports", [])) + 1; //no overwrite
            $cfg->setNested("reports.$reportname$int", $report);
            $cfg->save();
        }else{
            $cfg = new Config("/reports/reports.yml", Config::YAML);
            $report = [
                "name" => $reportname,
                "reporter" => $reporter,
                "player" => $playername,
                "desc" => $desc,
                "notes" => $notizen
            ];
            $int = count($cfg->get("reports", [])) + 1; //no overwrite
            $cfg->setNested("reports.$reportname$int", $report);
            $cfg->save();
        }
    }
}
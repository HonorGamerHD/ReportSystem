<?php

namespace ImNotYourDev\Report;

use ImNotYourDev\Report\commands\AdminCommand;
use ImNotYourDev\Report\commands\ReportCommand;
use ImNotYourDev\Report\commands\ReportListCommand;
use ImNotYourDev\Report\tasks\ReportRecieve;
use ImNotYourDev\Report\tasks\ReportReset;
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
            $cfg = new Config("/reports/inf.yml", Config::YAML);
            $cfg->set("new", false);
            $cfg->save();
        }
        $this->getLogger()->info($this->prefix . "ReportSystem by ImNotYourDev enabled!");
        $this->getLogger()->info("§7System mode: §e" . $this->mode);
        $this->getServer()->getCommandMap()->register("report", new ReportCommand("report"));
        $this->getServer()->getCommandMap()->register("reportadmin", new AdminCommand("reportadmin"));
        $this->getServer()->getCommandMap()->register("reportlist", new ReportListCommand("reportlist"));

        $this->getScheduler()->scheduleRepeatingTask(new ReportRecieve(), 20);
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

    /**
     * NOTE: maybe not the best thing but wokring!
     */
    public function sendReportToMod()
    {
        if($this->mode == "local"){
            foreach ($this->getServer()->getOnlinePlayers() as $player){
                if($player->hasPermission("reportssystem.admin")){
                    $player->sendMessage($this->prefix . "§eNew Report! §7Use /reportadmin to see latest reports!");
                }
            }
        }else{
            $cfg = new Config("/reports/inf.yml", Config::YAML);
            $cfg->set("new", true);
            $cfg->save();
            $this->getScheduler()->scheduleDelayedTask(new ReportReset(), 20);
        }
    }
}
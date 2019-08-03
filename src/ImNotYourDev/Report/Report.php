<?php

namespace ImNotYourDev\Report;

use ImNotYourDev\Report\commands\AdminCommand;
use ImNotYourDev\Report\commands\ReportCommand;
use ImNotYourDev\Report\commands\ReportListCommand;
use ImNotYourDev\Report\listener\EventListener;
use ImNotYourDev\Report\tasks\ReportRecieve;
use ImNotYourDev\Report\tasks\ReportReset;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Report extends PluginBase
{
    public static $instance;
    public $prefix;
    public $mode = "local";
    public $unreviewed = false;

    public function onEnable()
    {
        self::$instance = $this;
        $this->saveResource("config.yml");
        $this->mode = $this->getPluginConfig()->get("mode");
        $this->prefix = $this->getPluginConfig()->get("prefix");
        if($this->mode == "global"){
            mkdir("/reports", 777);
            $cfg = new Config("/reports/inf.yml", Config::YAML);
            $cfg->set("new", false);
            $cfg->save();

            $this->getScheduler()->scheduleRepeatingTask(new ReportRecieve(), 20); //never ever start outsite of this thing...
        }
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getCommandMap()->register("report", new ReportCommand("report"));
        $this->getServer()->getCommandMap()->register("reportadmin", new AdminCommand("reportadmin"));
        $this->getServer()->getCommandMap()->register("reportlist", new ReportListCommand("reportlist"));

        $this->getLogger()->info("§7System mode: §e" . $this->mode);
        $this->getLogger()->info($this->prefix . "ReportSystem by ImNotYourDev enabled!");
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

    public function getRecycleBinList() : array
    {
        if($this->mode == "local"){
            $cfg = new Config($this->getDataFolder() . "reports.yml", Config::YAML);
            return $cfg->get("recyclebin", []);
        }else{
            $cfg = new Config("/reports/reports.yml", Config::YAML);
            return $cfg->get("recyclebin", []);
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
            $int = count($cfg->get("reports", [])) + 1; //no overwrite
            $report = [
                "name" => $reportname,
                "nestdir" => $reportname . $int,
                "reporter" => $reporter,
                "player" => $playername,
                "desc" => $desc,
                "notes" => $notizen,
                "reviewed" => false
            ];
            $cfg->setNested("reports.$reportname$int", $report);
            $cfg->save();
        }else{
            $cfg = new Config("/reports/reports.yml", Config::YAML);
            $int = count($cfg->get("reports", [])) + 1; //no overwrite
            $report = [
                "name" => $reportname,
                "nestdir" => $reportname . $int,
                "reporter" => $reporter,
                "player" => $playername,
                "desc" => $desc,
                "notes" => $notizen,
                "reviewed" => false
            ];
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

    /**
     * @return bool
     */
    public function checkForUnreviewed() : bool
    {
        foreach ($this->getReportList() as $report){
            if($report["reviewed"] == false){
                $this->unreviewed = true;
            }else{
                $this->unreviewed = false;
            }
        }
        return $this->unreviewed;
    }

    /**
     * @param String $reportnestdir
     */
    public function setReviewed(String $reportnestdir)
    {
        $cfg = new Config("/reports/reports.yml", Config::YAML);
        $cfg->setNested("reports.$reportnestdir.reviewed", true);
        $cfg->save();
    }

    /**
     * @param array $report
     */
    public function moveToRecycleBin(array $report)
    {
        $cfg = new Config("/reports/reports.yml", Config::YAML);
        $cfg->removeNested("reports." . $report["nestdir"]);
        $cfg->save();

        $cfg->setNested("recyclebin." . $report["nestdir"], $report);
        $cfg->save();
    }

    public function deleteForEver(String $reportnestdir){
        $cfg = new Config("/reports/reports.yml", Config::YAML);
        $cfg->removeNested("recyclebin." . $reportnestdir);
        $cfg->save();
    }
}
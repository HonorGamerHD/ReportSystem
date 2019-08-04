<?php

namespace ImNotYourDev\Report\forms;

use ImNotYourDev\Report\libs\dktapps\pmforms\MenuForm;
use ImNotYourDev\Report\libs\dktapps\pmforms\MenuOption;
use ImNotYourDev\Report\Report;
use pocketmine\Player;

class ReportListForm extends MenuForm
{
    public $options = [];
    public function __construct()
    {
        $title = "§cReportSystem §7> §eList";
        $text = "Choose now an report to review";
        foreach (Report::getInstance()->getReportList() as $report){
            if($report["reviewed"] == false){
                $this->options[] = new MenuOption("§eNEW: §r" . $report["name"]);
            }else{
                $this->options[] = new MenuOption($report["name"]);
            }
        }
        parent::__construct($title, $text, $this->options, function (Player $player, $data) : void {
            $player->sendForm(new ReviewReportForm(Report::getInstance()->getReportList()[array_keys(Report::getInstance()->getReportList())[$data]]));
            return;
        });
    }
}
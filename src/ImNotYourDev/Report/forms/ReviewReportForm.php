<?php

namespace ImNotYourDev\Report\forms;

use ImNotYourDev\Report\libs\dktapps\pmforms\MenuForm;
use ImNotYourDev\Report\libs\dktapps\pmforms\MenuOption;
use ImNotYourDev\Report\Report;
use pocketmine\Player;

class ReviewReportForm extends MenuForm
{
    public $report = [];

    public function __construct(array $report)
    {
        $this->report = $report;
        $title = "§cReportSystem §7> §eReview";
        $text = "§7Reportname: §e" . $report["name"] . "\n§7Reporter: §e" . $report["reporter"] . "\n§7Reported player: §e" . $report["player"] . "\n§7Description: §e" . $report["desc"] . "\n§7Notes: §e" . $report["notes"] . "\n\n§7Choose now what u want to do";
        $options = [
            new MenuOption("§7Teleport(only if online)"),
            new MenuOption("§cBan player(soon)"),
            new MenuOption("§4Delete report"),
            new MenuOption("§cBack")
        ];

        Report::getInstance()->setReviewed($report["nestdir"]);

        parent::__construct($title, $text, $options, function (Player $player, $data) : void {
            if($data == 0){
                $target = Report::getInstance()->getServer()->getPlayer($this->report["player"]);
                if($target == true){
                    $player->teleport($target->asPosition());
                    $player->sendMessage(Report::getInstance()->prefix . "You were teleported to §e" . $target->getName() . "§7!");
                }else{
                    $player->sendMessage(Report::getInstance()->prefix . "§cPlayer isn't online!");
                    $player->sendForm($this);
                }
            }elseif($data == 1){
                $player->sendMessage(Report::getInstance()->prefix . "§csoon available!");
                $player->sendForm($this);
            }elseif($data == 2){
                Report::getInstance()->moveToRecycleBin($this->report);
                $player->sendMessage(Report::getInstance()->prefix . "Report moved to Recycle Bin!");
                $player->sendForm(new ReportListForm());
            }else{
                $player->sendForm(new ReportListForm());
            }
            return;
        });
    }
}
<?php

namespace ImNotYourDev\Report\forms;

use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;
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
            new MenuOption("§cBan player(soon)")
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
            }else{
                $player->sendMessage(Report::getInstance()->prefix . "§csoon available!");
                $player->sendForm($this);
            }
            return;
        });
    }
}
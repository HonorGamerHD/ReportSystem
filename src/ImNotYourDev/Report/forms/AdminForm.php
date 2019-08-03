<?php

namespace ImNotYourDev\Report\forms;

use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;
use ImNotYourDev\Report\Report;
use pocketmine\Player;

class AdminForm extends MenuForm
{
    public function __construct()
    {
        $title = "§cReportSystem §7> §eAdmin";
        $text = "ReportSystem admin tools";
        $options = [
            new MenuOption("§eReportlist"),
            new MenuOption("§7Settings(soon)")
        ];
        parent::__construct($title, $text, $options, function (Player $player, $data) : void {
            if($data == 0){
                $player->sendForm(new ReportListForm());
            }else{
                $player->sendMessage(Report::getInstance()->prefix . "§csoon available!");
                $player->sendForm($this);
            }
            return;
        });
    }
}
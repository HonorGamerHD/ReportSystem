<?php

namespace ImNotYourDev\Report\forms;

use ImNotYourDev\Report\libs\dktapps\pmforms\MenuOption;
use ImNotYourDev\Report\libs\dktapps\pmforms\MenuForm;
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
            new MenuOption("§cRecycle Bin"),
            new MenuOption("§7Settings(soon)"),
            new MenuOption("§4Exit")
        ];
        parent::__construct($title, $text, $options, function (Player $player, $data) : void {
            if($data == 0){
                $player->sendForm(new ReportListForm());
            }elseif($data == 1){
                $player->sendForm(new RecycleBinForm());
            }elseif($data == 2){
                $player->sendMessage(Report::getInstance()->prefix . "§csoon available!");
                $player->sendForm($this);
            }else{
                $player->removeAllWindows();
            }
            return;
        });
    }
}
<?php

namespace ImNotYourDev\Report\forms;

use ImNotYourDev\Report\libs\dktapps\pmforms\MenuForm;
use ImNotYourDev\Report\libs\dktapps\pmforms\MenuOption;
use ImNotYourDev\Report\Report;
use pocketmine\Player;

class RecycleBinForm extends MenuForm
{
    public $options = [];
    public function __construct()
    {
        $title = "§cReportSystem §7> §cRecycle Bin";
        $text = "Choose now an report to delete";
        $this->options[] = new MenuOption("§4Delete all");
        foreach (Report::getInstance()->getRecycleBinList() as $report){
            $this->options[] = new MenuOption($report["name"]);
        }
        $this->options[] = new MenuOption("§cBack");
        parent::__construct($title, $text, $this->options, function (Player $player, $data) : void {
            if($data == 0){
                foreach (Report::getInstance()->getRecycleBinList() as $item){
                    Report::getInstance()->deleteForEver($item["nestdir"]);
                }
                $player->sendMessage(Report::getInstance()->prefix . "§4All Reports deleted!");
                $player->sendForm(new $this);
            }elseif($data == count($this->options) - 1){
                $player->sendForm(new AdminForm());
            }else{
                $item = Report::getInstance()->getRecycleBinList()[array_keys(Report::getInstance()->getRecycleBinList())[$data - 1]]; //-1 dont calculate with delete all button
                Report::getInstance()->deleteForEver($item["nestdir"]);
                $player->sendMessage(Report::getInstance()->prefix . "§cReport deleted!");
                $player->sendForm(new $this);
            }
            return;
        });
    }
}
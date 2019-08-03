<?php

namespace ImNotYourDev\Report\forms;

use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Dropdown;
use dktapps\pmforms\element\Input;
use ImNotYourDev\Report\Report;
use pocketmine\Player;

class PlayerReportForm extends CustomForm
{
    public $pnarr = [];

    /**
     * PlayerReportForm constructor.
     */
    public function __construct()
    {
        $title = "§cSpielerreport";
        foreach (Report::getInstance()->getServer()->getOnlinePlayers() as $player)
        {
            $this->pnarr[$player->getName()] = $player->getName();
        }
        $elements = [
            new Input("reportname", "Report name", "fly hacker..."),
            new Dropdown("playername", "Choose Player", $this->pnarr),
            new Input("desc", "Description, what did the player do?"),
            new Input("notizen", "Notes(discord tag, ...)")
        ];
        parent::__construct($title, $elements, function (Player $player, CustomFormResponse $response) : void {
            $reportname = $response->getString("reportname");
            $pint = $response->getInt("playername");
            $playername = array_keys($this->pnarr)[$pint];
            $desc = $response->getString("desc");
            $notizen = $response->getString("notizen");

            Report::getInstance()->saveReport($reportname, $player->getName(), $playername, $desc, $notizen);
            $player->sendMessage(Report::getInstance()->prefix . "§eYour report was sent!");
            Report::getInstance()->sendReportToMod();
            return;
        });
    }
}
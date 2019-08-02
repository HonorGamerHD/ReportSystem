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
            array_push($this->pnarr, $player->getName());
        }
        $elements = [
            new Input("reportname", "Report Name", "Spieler ... hackt..."),
            new Dropdown("pno", "Spieler wählen", $this->pnarr),
            new Input("desc", "Beschreibung der Tat"),
            new Input("notizen", "weitere Notizen(Dein DiscordTag, ...)")
        ];
        parent::__construct($title, $elements, function (Player $player, CustomFormResponse $response) : void {
            $reportname = $response->getString("reportname");
            $pint = $response->getInt("pno");
            $playername = array_keys($this->pnarr)[$pint];
            $desc = $response->getString("desc");
            $notizen = $response->getString("notizen");

            Report::getInstance()->saveReport($reportname, $player->getName(), $playername, $desc, $notizen);
            $player->sendMessage("§l§0ReportSystem §r§7> §eDein Report wurde gespeichert!");
            return;
        });
    }
}
<?php

namespace ImNotYourDev\Report\forms;

use ImNotYourDev\PGToDiscord\PGTD;
use ImNotYourDev\Report\libs\dktapps\pmforms\CustomForm;
use ImNotYourDev\Report\libs\dktapps\pmforms\CustomFormResponse;
use ImNotYourDev\Report\libs\dktapps\pmforms\element\Input;
use ImNotYourDev\Report\libs\dktapps\pmforms\element\Dropdown;
use ImNotYourDev\Report\libs\dktapps\pmforms\element\Label;
use ImNotYourDev\Report\libs\dktapps\pmforms\element\Toggle;
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
        $title = "§cPlayer report";
        foreach (Report::getInstance()->getServer()->getOnlinePlayers() as $player)
        {
            $this->pnarr[$player->getName()] = $player->getName();
        }
        $elements = [
            new Input("reportname", "Report name", "fly hacker..."),
            new Dropdown("playername", "Choose Player", $this->pnarr),
            new Input("desc", "Description, what did the player do?"),
            new Input("notizen", "Notes(discord tag, ...)"),
            new Label("l", "\n"),
            new Toggle("exit", "§4Dont send and exit", 0)
        ];
        parent::__construct($title, $elements, function (Player $player, CustomFormResponse $response) : void {
            if($response->getBool("exit") == false){
                $reportname = $response->getString("reportname");
                $pint = $response->getInt("playername");
                $playername = array_keys($this->pnarr)[$pint];
                $desc = $response->getString("desc");
                $notizen = $response->getString("notizen");

                Report::getInstance()->saveReport($reportname, $player->getName(), $playername, $desc, $notizen);
                $player->sendMessage(Report::getInstance()->prefix . "§eYour report was sent!");
                Report::getInstance()->sendReportToMod();

                if(Report::getInstance()->discord){
                    PGTD::getInstance()->sendMessage(array("message" => "NEW Report! " . $player->getName() . " reported $playername for $desc!"), PGTD::TYPE_PLUGIN);
                }
            }else{
                $player->removeAllWindows();
                $player->sendMessage(Report::getInstance()->prefix . "§cReport was not send and got deleted!");
            }
            return;
        });
    }
}
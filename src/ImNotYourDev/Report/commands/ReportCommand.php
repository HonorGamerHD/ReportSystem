<?php

namespace ImNotYourDev\Report\commands;

use ImNotYourDev\Report\forms\PlayerReportForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class ReportCommand extends Command
{
    /**
     * ReportCommand constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $description = "send report to admins";
        $usageMessage = "/report";
        $aliases = ["rport", "reeport", "reprt"];
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool|mixed
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            $sender->sendForm(new PlayerReportForm());
        }
        return false;
    }
}
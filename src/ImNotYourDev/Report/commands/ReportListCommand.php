<?php

namespace ImNotYourDev\Report\commands;

use ImNotYourDev\Report\forms\ReportListForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class ReportListCommand extends Command
{
    public function __construct(string $name)
    {
        $description = "show you an list of all reports";
        $usageMessage = "/reportlist";
        $aliases = ["reportlst"];
        $this->setPermission("reportsystem.list");
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission("reportsystem.admin")){
            if($sender instanceof Player){
                $sender->sendForm(new ReportListForm());
            }
        }
        return false;
    }
}
<?php

namespace ImNotYourDev\Report\listener;

use ImNotYourDev\Report\Report;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class EventListener implements Listener
{
    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();

        if($player->hasPermission("reportsystem.admin")){
            if(Report::getInstance()->checkForUnreviewed() == true){
                $player->sendMessage(Report::getInstance()->prefix . "§eNew Report! §7Use /reportadmin to see latest reports!");
            }
        }
    }
}
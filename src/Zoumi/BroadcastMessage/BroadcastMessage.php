<?php

namespace Zoumi\BroadcastMessage;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class BroadcastMessage extends PluginBase {
    use SingletonTrait;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        $this->saveDefaultConfig();
        $this->getScheduler()->scheduleRepeatingTask(new BroadcastMessageTask(), 20);
    }

}
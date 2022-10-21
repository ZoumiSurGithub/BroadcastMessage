<?php

namespace Zoumi\BroadcastMessage;

use pocketmine\scheduler\CancelTaskException;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class BroadcastMessageTask extends Task {

    private int $time = 30;
    private int $order = 0;

    public function __construct()
    {
        $this->time = BroadcastMessage::getInstance()->getConfig()->get("time");
    }

    public function onRun(): void
    {
        if (empty(BroadcastMessage::getInstance()->getConfig()->get("messages"))){
            Server::getInstance()->getLogger()->error("[FR] | Aucun message définis, définissez en puis redémarrer le serveur.");
            Server::getInstance()->getLogger()->error("[EN] | No message defined, set it then restart the server.");
            throw new CancelTaskException();
        }
        if (--$this->time <= 0) {
            if ($this->order > (count(BroadcastMessage::getInstance()->getConfig()->get("messages")) - 1)) {
                $this->order = 0;
            }
            Server::getInstance()->broadcastMessage(BroadcastMessage::getInstance()->getConfig()->get("messages")[$this->order]);
            $this->order++;
            $this->time = BroadcastMessage::getInstance()->getConfig()->get("time");
        }
    }

}
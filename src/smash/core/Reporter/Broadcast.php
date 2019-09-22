<?php
/*
 *
| |  | |
| |__| | ___  _ __   ___  _ __
|  __  |/ _ \| '_ \ / _ \| '__|
| |  | | (_) | | | | (_) | |
|_|  |_|\___/|_| |_|\___/|_|
 *
 * This program is private software: you can not redistribute it and/or modify
 * it under the terms of the GNUv3 Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketmineSmash
 *
*/
declare(strict_types=1);
namespace smash\core\Reporter;


use pocketmine\scheduler\Task;
use pocketmine\Server;
use smash\core\Database\YamlProvider;

class Broadcast extends Task
{
	/**
	 * Actions to execute when run
	 *
	 * @param int $currentTick
	 *
	 * @return void
	 */
	public function onRun(int $currentTick)
	{
		if (Server::getInstance()->getOnlinePlayers() > 0) {
			foreach (Server::getInstance()->getOnlinePlayers() as $player) {
				$player->sendMessage("§7[§6Honor§5Games§7]§b > " . $this->getBroadcastMessage());
			}
		}
	}


	public function getBroadcastMessage(): string {
		$messages = array();
			foreach (YamlProvider::getBroadcastMessages()->getAll() as $message) {
			$messages[] = $message;
		}
		return $messages[array_rand($messages)];
	}
}
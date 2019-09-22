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
namespace smash\core\EventHandler;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use smash\core\Database\QueryManager;
use smash\core\RankSys\RankManager;

class GlobalHandler implements Listener {

	/*
	 * guest
	 * vip
	 * admin
	 * supervisor
	 * samurai
	 * sumo
	 */

	public function onChat(PlayerChatEvent $event) {
		$player = $event->getPlayer();
		$message = $event->getMessage();
		$rank = QueryManager::getRank($player->getName());
		switch ($rank){
			case 'vip':
				$event->setFormat(RankManager::extractRank($player) . "§7" .$player->getName(). "§9 >> §r". $message);
				break;
			case 'admin':
				$event->setFormat(RankManager::extractRank($player) . "§4:" . "§a " . $message);
				break;
			case 'supervisor':
				$event->setFormat(RankManager::extractRank($player) . "§7" .$player->getName(). "§9: " . $message);
				break;
			case 'samurai':
				$event->setFormat(RankManager::extractRank($player) . "§7" .$player->getName() . "§c㊛: " . $message);
				break;
			case 'sumo':
				$event->setFormat(RankManager::extractRank($player) . "§7" .$player->getName() . " §2㊚: " . $message);
				break;
			case 'guest':
			default:
				$event->setFormat(RankManager::extractRank($player) . "§7" .$player->getName() . "§0 >§r " . $message);
				break;
		}
	}

	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		RankManager::updateRank($player);
	}
}
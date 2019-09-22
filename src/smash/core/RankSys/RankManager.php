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
namespace smash\core\RankSys;

use pocketmine\Player;
use smash\core\Database\QueryManager;

abstract class RankManager
{

	/*
	 * guest
	 * vip
	 * admin
	 * supervisor
	 * samurai
	 * sumo
	 */

	public static function extractRank(Player $player): string
	{
		$rank = QueryManager::getRank($player->getName());
		switch ($rank) {
			case 'guest':
				return "§7[§cGuest§7] ";
				break;
			case 'vip':
				return '§e[§6VIP§e] ';
				break;
			case 'admin':
				return '§7[§f☯§7] §6SERVER ';
				break;
			case 'supervisor':
				return '§7[§bSupervisor§7] ';
				break;
			case 'samurai':
				return '§7[§4Samu§6rai§7] ';
				break;
			case 'sumo':
				return '§7[§9Su§bmo§7] ';
				break;
			default:
				return 'unknown';
				break;
		}
	}

	public static function updateRank(Player $player) {
		$player->setDisplayName(RankManager::extractRank($player) . "§7" . $player->getName());
		$player->setNameTag(RankManager::extractRank($player) . "§7" . $player->getName());
	}
}
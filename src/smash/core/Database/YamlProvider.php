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
namespace smash\core\Database;


use pocketmine\utils\Config;

abstract class YamlProvider
{
	public static function getSettings(): Config {
		return new Config(self::getPlugin()->getDataFolder()."settings.conf", Config::YAML);
	}

	public static function getBroadcastMessages(): Config {
		return new Config(self::getPlugin()->getDataFolder()."messages.yml", Config::YAML);
	}

	public static function getSpamMessages(): Config {
		return new Config(self::getPlugin()->getDataFolder()."spam_messages.yml", Config::YAML);
	}

	public static function getFlyingPlayers(): Config {
		return new Config(self::getPlugin()->getDataFolder()."flying.yml", Config::YAML);
	}
}
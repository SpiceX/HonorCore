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

use pocketmine\Player;

interface API_SQL
{
	public static function getPlayer(string $player): string;
	public static function addPlayer(Player $player);
	public static function deletePlayer(string $player);
	public static function playerExists(string $player): bool;
	public static function isBanned(string $player): bool;
	public static function setCoins(string $player, int $coins);
	public static function getCoins(string $player): int;
	public static function getRank(string $player): string;
	public static function setRank(string $player, string $rank);
	public static function getIp(string $player): string;
	public static function getUUID(string $player): string;
	public static function setPassword(string $player, string $password);
	public static function getPassword(string $player): string;
	public static function verifyPassword(string $player, string $password): bool;
}
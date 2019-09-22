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
use smash\core\Reporter\Console;

class QueryManager implements API_SQL
{
	protected static $DATABASE;

	public static function Initiate(): void
	{
		self::$DATABASE = Connection::getDatabase();
		self::$DATABASE->exec('CREATE TABLE IF NOT EXISTS Players (
            NAME TEXT NOT NULL,
            RANK TEXT NOT NULL,
            BANNED TEXT NOT NULL,
            COINS INT NOT NULL,
            IP TEXT NOT NULL,
            UUID TEXT NOT NULL,
            PASSWORD TEXT NOT NULL,
            UNIQUE(NAME)
        )');
		Console::info("Connected to the database!");
	}

	public static function getPlayer(string $player): string
	{
		self::$DATABASE = Connection::getDatabase();
		return self::$DATABASE->querySingle("SELECT NAME FROM Players WHERE NAME = '$player'");
	}

	public static function addPlayer(Player $player)
	{
		self::$DATABASE = Connection::getDatabase();
		$name = $player->getName();
		$address = $player->getAddress();
		$uuid = $player->getUniqueId()->toString();
		self::$DATABASE->exec("INSERT INTO Players(NAME,RANK,BANNED,COINS,IP,UUID,PASSWORD) VALUES ('$name', 'guest', 'false', 0,'$address','$uuid','null');");
	}

	public static function deletePlayer(string $player)
	{
		self::$DATABASE = Connection::getDatabase();
		self::$DATABASE->exec("DELETE FROM Players WHERE NAME = $player");
	}

	public static function playerExists(string $player): bool
	{
		self::$DATABASE = Connection::getDatabase();
		$query = self::$DATABASE->querySingle("SELECT NAME FROM Players WHERE NAME = '$player'");
		if ($query == null) {
			return false;
		} else {
			return true;
		}
	}

	public static function isBanned(string $player): bool
	{
		self::$DATABASE = Connection::getDatabase();
		$query = self::$DATABASE->querySingle("SELECT BANNED FROM Players WHERE NAME = '$player'");
		if ($query == 'true') {
			return true;
		} else {
			return false;
		}
	}

	public static function setCoins(string $player, int $coins)
	{
		self::$DATABASE = Connection::getDatabase();
		self::$DATABASE->exec("UPDATE Players SET COINS='$coins' WHERE NAME='$player'");
	}

	public static function getCoins(string $player): int
	{
		self::$DATABASE = Connection::getDatabase();
		return self::$DATABASE->querySingle("SELECT COINS FROM Players WHERE NAME='$player'");
	}

	public static function getRank(string $player): string
	{
		self::$DATABASE = Connection::getDatabase();
		return self::$DATABASE->querySingle("SELECT RANK FROM Players WHERE NAME='$player'");
	}

	public static function setRank(string $player, string $rank)
	{
		self::$DATABASE = Connection::getDatabase();
		self::$DATABASE->exec("UPDATE Players SET RANK='$rank' WHERE NAME='$player'");
	}

	public static function getIp(string $player): string
	{
		self::$DATABASE = Connection::getDatabase();
		return self::$DATABASE->querySingle("SELECT IP FROM Players WHERE NAME='$player'");
	}

	public static function getUUID(string $player): string
	{
		self::$DATABASE = Connection::getDatabase();
		return self::$DATABASE->querySingle("SELECT UUID FROM Players WHERE NAME='$player'");
	}

	public static function setPassword(string $player, string $password)
	{
		self::$DATABASE = Connection::getDatabase();
		self::$DATABASE->exec("UPDATE Players SET PASSWORD='$password' WHERE NAME='$player'");
	}

	public static function getPassword(string $player): string
	{
		self::$DATABASE = Connection::getDatabase();
		$pass_enc = self::$DATABASE->querySingle("SELECT PASSWORD FROM Players WHERE NAME='$player'");
		return base64_decode($pass_enc);
	}

	public static function verifyPassword(string $player, string $password): bool
	{
		if ($password === self::getPassword($player)){
			return true;
		} else {
			return false;
		}
	}
}
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
namespace smash\core\Utils;


use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\network\mcpe\protocol\StopSoundPacket;
use pocketmine\Player;

abstract class SoundHandler {
	/**
	 * @param Player $player
	 * @param string $soundName
	 * @param float $volume
	 * @param float $pitch
	 */
	public static function playSound(Player $player, string $soundName, float $volume = 0, float $pitch = 0): void
	{
		$pk = new PlaySoundPacket();
		$pk->soundName = $soundName;
		$pk->x = (int)$player->x;
		$pk->y = (int)$player->y;
		$pk->z = (int)$player->z;
		$pk->volume = $volume;
		$pk->pitch = $pitch;
		$player->dataPacket($pk);
	}
	/**
	 * @param Player $player
	 * @param String $song
	 * @param bool $all
	 */
	public static function stopSound(Player $player, String $song, $all = true)
	{
		$pk = new StopSoundPacket();
		$pk->soundName = $song;
		$pk->stopAll = $all;
		$player->dataPacket($pk);
	}
}
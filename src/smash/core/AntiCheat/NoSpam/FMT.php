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
namespace smash\core\AntiCheat\NoSpam;

use pocketmine\utils\TextFormat as color;

class FMT
{

	public static function colorMessage($message)
	{
		$symbol = "&";
		$message = str_replace($symbol . "0", color::BLACK, $message);
		$message = str_replace($symbol . "1", color::DARK_BLUE, $message);
		$message = str_replace($symbol . "2", color::DARK_GREEN, $message);
		$message = str_replace($symbol . "3", color::DARK_AQUA, $message);
		$message = str_replace($symbol . "4", color::DARK_RED, $message);
		$message = str_replace($symbol . "5", color::DARK_PURPLE, $message);
		$message = str_replace($symbol . "6", color::GOLD, $message);
		$message = str_replace($symbol . "7", color::GRAY, $message);
		$message = str_replace($symbol . "8", color::DARK_GRAY, $message);
		$message = str_replace($symbol . "9", color::BLUE, $message);
		$message = str_replace($symbol . "a", color::GREEN, $message);
		$message = str_replace($symbol . "b", color::AQUA, $message);
		$message = str_replace($symbol . "c", color::RED, $message);
		$message = str_replace($symbol . "d", color::LIGHT_PURPLE, $message);
		$message = str_replace($symbol . "e", color::YELLOW, $message);
		$message = str_replace($symbol . "f", color::WHITE, $message);
		$message = str_replace($symbol . "k", color::OBFUSCATED, $message);
		$message = str_replace($symbol . "l", color::BOLD, $message);
		$message = str_replace($symbol . "m", color::STRIKETHROUGH, $message);
		$message = str_replace($symbol . "n", color::UNDERLINE, $message);
		$message = str_replace($symbol . "o", color::ITALIC, $message);
		$message = str_replace($symbol . "r", color::RESET, $message);
		return $message;
	}
}
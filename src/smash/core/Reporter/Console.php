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

abstract class Console
{
	private static $FORMAT_BOLD = "\x1b[1m";
	private static $FORMAT_OBFUSCATED = "";
	private static $FORMAT_ITALIC = "\x1b[3m";
	private static $FORMAT_UNDERLINE = "\x1b[4m";
	private static $FORMAT_STRIKETHROUGH = "\x1b[9m";
	private static $FORMAT_RESET = "\x1b[m";
	private static $COLOR_BLACK = "\x1b[38;5;16m";
	private static $COLOR_DARK_BLUE = "\x1b[38;5;19m";
	private static $COLOR_DARK_GREEN = "\x1b[38;5;34m";
	private static $COLOR_DARK_AQUA = "\x1b[38;5;37m";
	private static $COLOR_DARK_RED = "\x1b[38;5;124m";
	private static $COLOR_PURPLE = "\x1b[38;5;127m";
	private static $COLOR_GOLD = "\x1b[38;5;214m";
	private static $COLOR_GRAY = "\x1b[38;5;145m";
	private static $COLOR_DARK_GRAY = "\x1b[38;5;59m";
	private static $COLOR_BLUE = "\x1b[38;5;63m";
	private static $COLOR_GREEN = "\x1b[38;5;83m";
	private static $COLOR_AQUA = "\x1b[38;5;87m";
	private static $COLOR_RED = "\x1b[38;5;203m";
	private static $COLOR_LIGHT_PURPLE = "\x1b[38;5;207m";
	private static $COLOR_YELLOW = "\x1b[38;5;227m";
	private static $COLOR_WHITE = "\x1b[38;5;231m";

	public static function info($message)
	{
		self::send('INFO', $message, self::$COLOR_GREEN);
	}

	public static function error($message)
	{
		self::send('ERROR', $message, self::$COLOR_DARK_RED);
	}

	public static function warning($message)
	{
		self::send('WARNING', $message, self::$COLOR_YELLOW);
	}

	private static function getDate(): string
	{
		$format = date("d.m.y");
		$date = str_replace(".", ":", $format);
		return '[' . $date. ']';
	}

	private static function send(string $prefix, string $message, string $color)
	{
		$br = "\n";
		$clear = self::$FORMAT_RESET;
		$p = ' ' . self::$COLOR_GOLD . '['. self::$COLOR_PURPLE .'HonorCore' . self::$COLOR_GOLD . '/' . $prefix . ']';
		if (!strlen($message) == 0) {
			echo self::$COLOR_AQUA . self::getDate() . $p . ': ' . $color . $message . $clear . $br;
		}
	}
}
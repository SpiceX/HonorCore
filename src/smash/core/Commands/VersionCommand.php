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
namespace smash\core\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\command\utils\CommandException;
use pocketmine\plugin\Plugin;
use smash\core\Core;

class VersionCommand extends Command implements PluginIdentifiableCommand
{

	public function __construct()
	{
		parent::__construct("version", "version info", "/version", ['version', 'v']);
	}

	/**
	 * @param CommandSender $sender
	 * @param string $commandLabel
	 * @param string[] $args
	 *
	 * @return mixed
	 * @throws CommandException
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		if (isset($args[0])){
			$sender->sendMessage("§e>> §aThis server is running PocketMine-MP: §6§lNight§5mare §r§a modded version 4.1.0 implementing §cPHP 7.4-dev");
		} else {
			$sender->sendMessage("§e>> §aThis server is running PocketMine-MP: §6§lNight§5mare §r§a modded version 4.1.0 implementing §cPHP 7.4-dev");
		}
	}

	/**
	 * @return Plugin
	 */
	public function getPlugin(): Plugin
	{
		return Core::getPlugin();
	}
}
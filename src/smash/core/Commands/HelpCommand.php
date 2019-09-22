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

class HelpCommand extends Command implements PluginIdentifiableCommand
{

	public function __construct()
	{
		parent::__construct('help', 'nightmare help command', 'usage: /help', ['help', 'h', 'sos']);
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
		if (!isset($args[0])) {
			$sender->sendMessage("§c---------§6[§aServer §lHelp: page §21§r§6]§c---------\n" .
				"- §ehelp : §7Help command for nightmare server\n" .
				"- §esumo : §7Sumo tournament command\n" .
				"- §einfo : §7Information about the server\n" .
				"- §eranks : §7Info for ranks and youtube reviews\n" .
				"- §efly : §7Enable/Disable fly\n" .
				"- §eversion : §7Show server version");
		} else {
			switch ($args[0]) {
				case null:
				case 0:
				$sender->sendMessage("§c---------§6[§aServer §lHelp: page §21§r§6]§c---------\n" .
					"- §ehelp : §7Help command for nightmare server\n" .
					"- §esumo : §7Sumo tournament command\n" .
					"- §einfo : §7Information about the server\n" .
					"- §eranks : §7Info for ranks and youtube reviews\n" .
					"- §efly : §7Enable/Disable fly\n" .
					"- §eversion : §7Show server version");
					break;
			}
		}
		return true;
	}

	/**
	 * @return Plugin
	 */
	public function getPlugin(): Plugin
	{
		return Core::getPlugin();
	}
}
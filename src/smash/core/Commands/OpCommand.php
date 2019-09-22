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
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use smash\core\Core;

class OpCommand extends Command implements PluginIdentifiableCommand
{
	public function __construct()
	{
		parent::__construct('op', 'op command', '/op <player>', ['op', 'operator']);
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
			$sender->sendMessage(Core::PREFIX . "§cUsage: /op <pĺayer>");
		} else {
			if (!$sender instanceof Player) {
				if (!Player::isValidUserName($args[0])) {
					throw new InvalidCommandSyntaxException();
				}
					$sender->getServer()->getOfflinePlayer($args[0])->setOp(true);
					$sender->sendMessage(Core::PREFIX . "§e$args[0]§a is now operator!");
			} else {
				$sender->sendMessage(Core::PREFIX . "§cOnly the console can give operator to a player");
			}
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
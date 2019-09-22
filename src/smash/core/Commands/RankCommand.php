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
use pocketmine\Server;
use smash\core\Core;
use smash\core\Database\QueryManager;
use smash\core\RankSys\RankManager;

class RankCommand extends Command implements PluginIdentifiableCommand
{

	/*
	 * guest
	 * vip
	 * admin
	 * supervisor
	 * samurai
	 * sumo
	 */

	public function __construct()
	{
		parent::__construct('rank', 'rank command for nightmare', '/rank', ['rank', 'rk']);
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
		if ($sender->isOp() || $sender->hasPermission('nightmare.cmd.rank'))
		if (isset($args[0])){
			$ranks = ['guest', 'vip', 'admin', 'supervisor', 'admin', 'sumo', 'samurai',];
			switch ($args[0]){
				case 'set':
					if (QueryManager::playerExists($args[1]) == true){
						if (in_array($args[2], $ranks)){
							QueryManager::setRank($args[1], $args[2]);
							$sender->sendMessage(Core::PREFIX ."§e$args[2] §arank given to §e$args[1]§a!");
							RankManager::updateRank(Server::getInstance()->getPlayerExact($args[1]));
						} else {
							$sender->sendMessage(Core::PREFIX . "§cThe rank §e$args[2]§c does not exists");
						}
					} else {
						$sender->sendMessage(Core::PREFIX . "§cThe player §e$args[1] §cdoes not exists!");
					}
					break;
			}
		} else {
			$sender->sendMessage('');
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
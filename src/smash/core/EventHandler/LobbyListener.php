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
namespace smash\core\EventHandler;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use smash\core\Core;
use smash\core\Database\QueryManager;
use smash\core\Forms\FormManager;
use smash\core\TaskHandler\GiveLobbyItems;
use smash\core\Utils\SoundHandler;

class LobbyListener implements Listener
{
	private function isOnLobby(Player $player)
	{
		if ($player->getLevel()->getFolderName() == Server::getInstance()->getDefaultLevel()->getFolderName()) {
			return true;
		} else {
			return false;
		}
	}

	public function noVoidLobby(PlayerMoveEvent $event)
	{
		if ($this->isOnLobby($event->getPlayer())) {
			if ($event->getTo()->getFloorY() < 2) {
				$event->getPlayer()->teleport(Server::getInstance()->getDefaultLevel()->getSafeSpawn());
			}
		}
	}


	public function noDamage(EntityDamageEvent $event)
	{
		$player = $event->getEntity();
		if ($player instanceof Player) {
			if ($this->isOnLobby($player)) {
				$event->setCancelled(true);
			}
		}
	}

	public function noHunger(PlayerExhaustEvent $event)
	{
		$event->setCancelled(true);
	}

	public function onQuit(PlayerQuitEvent $event)
	{
		$event->setQuitMessage('');
	}

	public function onJoin(PlayerJoinEvent $event)
	{
		$event->setJoinMessage('');
		$player = $event->getPlayer();
		$player->setGamemode(2);
		$player->setFood(20);
		$player->setHealth(20);
		$player->getInventory()->clearAll();
		if (QueryManager::playerExists($player->getName()) == true) {
			$player->addTitle("§5Night§6mare", "§7Welcome!", 15, 15, 15);
			SoundHandler::playSound($player, 'firework.launch', 1, 1);
			Core::getPlugin()->getScheduler()->scheduleTask(new GiveLobbyItems($player));
		} else {
			QueryManager::addPlayer($player);
			FormManager::sendFirstTimeForm($player);
			$player->addTitle("§5Night§6mare", "§7Welcome!", 15, 15, 15);
			SoundHandler::playSound($player, 'firework.launch', 1, 1);
			Core::getPlugin()->getScheduler()->scheduleTask(new GiveLobbyItems($player));
		}
	}

	public function onSelectMenu(PlayerInteractEvent $event){
		$item = $event->getItem()->getId();
		$player = $event->getPlayer();
		$pets = new Item(Item::DRAGON_EGG);
		$tnt = new Item(Item::TNT);
		$snowball = new Item(Item::SNOWBALL);
		$back = new Item(Item::CLAY_BALL);
		if ($this->isOnLobby($player)){
			if ($item == Item::ENCHANTED_GOLDEN_APPLE){
				$player->getInventory()->clearAll();
				$player->getInventory()->setItem(0, $pets->setCustomName("§9P§ce§et§2s"));
				$player->getInventory()->setItem(1, $tnt->setCustomName("§4TNT"));
				$player->getInventory()->setItem(2, $snowball->setCustomName("§fSnowballs"));
				$player->getInventory()->setItem(8, $back->setCustomName("§cBack"));
			} elseif ($item == Item::DRAGON_EGG){
				FormManager::sendPetsForm($player);
			} elseif ($item == Item::CLAY_BALL){
				$player->getInventory()->clearAll();
				Core::getPlugin()->getScheduler()->scheduleTask(new GiveLobbyItems($player));
			}
		}
	}

}
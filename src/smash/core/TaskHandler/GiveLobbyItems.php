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
namespace smash\core\TaskHandler;


use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\scheduler\Task;

class GiveLobbyItems extends Task
{
	private $player;

	public function __construct(Player $player)
	{
		$this->player = $player;
	}

	/**
	 * Actions to execute when run
	 *
	 * @param int $currentTick
	 *
	 * @return void
	 */
	public function onRun(int $currentTick)
	{
		$items = [
			'games' => (new Item(Item::NETHER_STAR))->setCustomName("§9[Games]"),
			'info' => (new Item(Item::BOOK))->setCustomName("§b[Information]"),
			'cosmetics' => (new Item(Item::ENCHANTED_GOLDEN_APPLE))->setCustomName("§a[Cosmetics]"),
			'particles' => (new Item(Item::SLIME_BALL))->setCustomName("§c[Particles]"),
			'news' => (new Item(Item::TOTEM))->setCustomName("§6[News]")];
		$this->player->getInventory()->setItem(0, $items['info']);
		$this->player->getInventory()->setItem(2, $items['news']);
		$this->player->getInventory()->setItem(4, $items['games']);
		$this->player->getInventory()->setItem(6, $items['cosmetics']);
		$this->player->getInventory()->setItem(8, $items['particles']);
		unset($items);
	}
}
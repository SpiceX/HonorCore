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
namespace smash\core\Pets;

use pocketmine\{entity\Entity, math\Vector3, Player, Server};

class PetManager
{
	/**
	 * Registra las entidades en el servidor
	 */
	public static function Initiate()
	{
		Entity::registerEntity(WolfPet::class, true);
		Entity::registerEntity(ParrotPet::class, true);
		self::removeAll();
	}

	/**
	 * @param string $type
	 * @param Player $player
	 * Crea un nuevo pet
	 */
	public static function create(string $type, Player $player)
	{
		$pet = null;
		self::remove($player);
		$nbt = Entity::createBaseNBT(new Vector3($player->x - 1, $player->y, $player->z + 1));
		if ($type == "wolf") {
			$pet = new WolfPet($player->getLevel(), $nbt);
			$pet->setBaby(true);
		} elseif ($type == "parrot") {
			$pet = new ParrotPet($player->getLevel(), $nbt);
		}
		$pet->setOwner($player);
		$pet->spawnToAll();
		$player->sendMessage(self::getRandomMessage());
	}

	/**
	 * @return string
	 * Obtiene un mensaje para dar al jugador
	 */
	public static function getRandomMessage(): string
	{
		$title = "§7[§ePet§7] §b: §r";
		$msg = [
			"Hey! Good thing you're back",
			"Good to see you again",
			"Do you have any food?",
			"",
			"",
			""
		];
		return $title . $msg[array_rand($msg)];
	}


	/**
	 * @param Player $player
	 * Remueve un pet a un jugador
	 */
	public static function remove(Player $player)
	{
		foreach (Server::getInstance()->getLevels() as $level) {
			foreach ($level->getEntities() as $entity) {
				if ($entity instanceof WolfPet) {
					if ($entity->getOwner() == $player) {
						$entity->close();
					}
				}
				if ($entity instanceof ParrotPet) {
					if ($entity->getOwner() == $player) {
						$entity->close();
					}
				}
			}
		}
	}

	/**
	 *Remueve todas las entidades al jugador
	 */
	public static function removeAll()
	{
		foreach (Server::getInstance()->getLevels() as $level) {
			foreach ($level->getEntities() as $entity) {
				if ($entity instanceof WolfPet) {
					$entity->close();
				}
				if ($entity instanceof ParrotPet) {
					$entity->close();
				}
			}
		}
	}

	/**
	 * @param Player $player
	 * Da a un jugador un pet al azar
	 */
	public static function createRandom(Player $player)
	{
		$pets = ['parrot','wolf'];
		self::create($pets[array_rand($pets)], $player);
	}
}
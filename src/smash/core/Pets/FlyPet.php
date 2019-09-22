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

use pocketmine\block\Air;
use pocketmine\block\Liquid;
use pocketmine\entity\Entity;
use pocketmine\math\Math;
use pocketmine\math\Vector3;
use pocketmine\Player;

class FlyPet extends Entity
{
	protected $owner = null;
	protected $distanceToOwner = 0;
	protected $closeTarget = null;
	public $width = 0.9;
	public $height = 1.4;
	public $length = 0.6;

	/**
	 * @param Player $player
	 * Configura el owner
	 */
	public function setOwner(Player $player)
	{
		$this->owner = $player;
	}

	/*
	 * Obtiene el owner
	 */
	public function getOwner()
	{
		return $this->owner;
	}

//reemplazar move de pcoketmine para hacer un move y retroceder 1 eliminar 1
	public function move(float $dx, float $dy, float $dz): void
	{
		$this->boundingBox->offset($dx, 0, 0);
		$this->boundingBox->offset(0, 0, $dz);
		$this->boundingBox->offset(0, $dy, 0);
		$this->setComponents($this->x + $dx, $this->y + $dy, $this->z + $dz);
	}

	/**
	 * @return int
	 * Obtiene la velocidad del pet
	 */
	public function getSpeed()
	{
		return 1;
	}

	public function setBaby(bool $type = false)
	{
		$this->setGenericFlag(self::DATA_FLAG_BABY, $type);
		$this->setScale(0.5);
	}

	/**
	 * Actualiza el movimiento del pet
	 */
	public function updateMove()
	{
		if (is_null($this->closeTarget)) {
			$x = $this->owner->x - $this->x;
			$z = $this->owner->z - $this->z;
		} else {
			$x = $this->closeTarget->x - $this->x;
			$z = $this->closeTarget->z - $this->z;
		}
		if ($x ** 2 + $z ** 2 < 4) {
			$this->motion->x = 0;
			$this->motion->z = 0;
			$this->motion->y = 0;
			if (!is_null($this->closeTarget)) {
				$this->close();
			}
			return;
		} else {
			$diff = abs($x) + abs($z);
			$this->motion->x = $this->getSpeed() * 0.15 * ($x / $diff);
			$this->motion->z = $this->getSpeed() * 0.15 * ($z / $diff);
		}
		$this->yaw = -atan2($this->motion->x, $this->motion->z) * 180 / M_PI;
		if (is_null($this->closeTarget)) {
			$y = $this->owner->y - $this->y;
		} else {
			$y = $this->closeTarget->y - $this->y;
		}
		$this->pitch = $y == 0 ? 0 : rad2deg(-atan2($y, sqrt($x ** 2 + $z ** 2)));
		$dx = $this->motion->x;
		$dz = $this->motion->z;
		$newX = Math::floorFloat($this->x + $dx);
		$newZ = Math::floorFloat($this->z + $dz);
		$block = $this->level->getBlock(new Vector3($newX, Math::floorFloat($this->y), $newZ));
		if (!($block instanceof Air) && !($block instanceof Liquid)) {
			$block = $this->level->getBlock(new Vector3($newX, Math::floorFloat($this->y + 1), $newZ));
			if (!($block instanceof Air) && !($block instanceof Liquid)) {
				$this->motion->y = 0;
				if (is_null($this->closeTarget)) {
					$this->returnToOwner();
					return;
				}
			} else {
				if (!$block->canBeFlowedInto()) {
					$this->motion->y = 1.1;
				} else {
					$this->motion->y = 0;
				}
			}
		} else {
			$block = $this->level->getBlock(new Vector3($newX, Math::floorFloat($this->y - 1), $newZ));
			if (!($block instanceof Air) && !($block instanceof Liquid)) {
				$blockY = Math::floorFloat($this->y);
				if ($this->y - $this->gravity * 4 > $blockY) {
					$this->motion->y = -$this->gravity * 4;
				} else {
					$this->motion->y = ($this->y - $blockY) > 0 ? ($this->y - $blockY) : 0;
				}
			} else {
				$this->motion->y -= $this->gravity * 4;
			}
		}
		$dy = $this->motion->y;
		$this->move($dx, $dy, $dz);
		$this->updateMovement();
	}

	/**
	 * Necesario en Entity
	 */
	public function fastClose()
	{
		parent::close();
	}

	/**
	 * @param int $currentTick
	 * @return bool
	 */
	public function onUpdate(int $currentTick): bool
	{
		//verificar si el dueño no esta close
		if (!($this->owner instanceof Player) || $this->owner->closed) {
			$this->fastClose();
			return false;
		}
		if ($this->closed) {
			return false;
		}
		$tickDiff = $currentTick - $this->lastUpdate;
		$this->lastUpdate = $currentTick;
		//estancias de y
		if (is_null($this->closeTarget) && $this->distance($this->owner) > 40) {
			$this->returnToOwner();
		}
		if (is_null($this->closeTarget) && $this->y > $this->owner->y) {
			$this->setPosition(new Vector3($this->x, $this->owner->y + 1.5, $this->z));
		}
		if (is_null($this->closeTarget) && $this->owner->y > $this->y) {
			$this->setPosition(new Vector3($this->x, $this->owner->y + 1.5, $this->z));
		}
		$this->entityBaseTick($tickDiff);
		$this->updateMove();
		$this->checkChunks();
		return true;
	}

	/**
	 * Devuelve el pet al dueño
	 */
	public function returnToOwner()
	{
		$len = rand(2, 6);
		$x = (-sin(deg2rad($this->owner->yaw))) * $len + $this->owner->getX();
		$z = cos(deg2rad($this->owner->yaw)) * $len + $this->owner->getZ();
		$this->x = $x;
		$this->y = $this->owner->getY() + 1;
		$this->z = $z;
	}

	public static function getTimeInterval($started)
	{
		return round((strtotime(date('Y-m-d H:i:s')) - strtotime($started)) / 60);
	}
}
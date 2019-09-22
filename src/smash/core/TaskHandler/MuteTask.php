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

use pocketmine\Player;
use pocketmine\scheduler\Task;
use smash\core\AntiCheat\NoSpam\AntiSpammer;
use smash\core\AntiCheat\NoSpam\FMT;
use smash\core\Database\YamlProvider;

class MuteTask extends Task
{
	private $spammer;
	private $player;

	public function __construct(AntiSpammer $spammer, Player $p)
	{
		parent::__construct($spammer);
		$this->spammer = $spammer;
		$this->player = $p;
	}

	public function onRun($tick)
	{
		$this->spammer->unMutePlayer($this->player);
		$this->player->sendMessage(FMT::colorMessage(YamlProvider::getSpamMessages()->getAll(){"un-muted_message"}));
	}
}
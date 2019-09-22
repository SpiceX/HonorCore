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
namespace smash\core\AntiCheat\NoSpam;

use pocketmine\Player;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\Listener;
use smash\core\Core;
use smash\core\Database\YamlProvider;
use smash\core\TaskHandler\MuteTask;

class AntiSpammer implements Listener {
	private $players = [];
	private $warnings = [];
	private $muted = [];

	public function isPlayerMuted(Player $p){
		return isset($this->muted[spl_object_hash($p)]);
	}
	public function unMutePlayer(Player $p){
		unset($this->muted[spl_object_hash($p)]);
	}
	public function onChat(PlayerChatEvent $e){
		if($e->getPlayer()->hasPermission("spam.bypass")) return;
		if(isset($this->muted[spl_object_hash($e->getPlayer())])){
			$e->getPlayer()->sendMessage(FMT::colorMessage(YamlProvider::getSpamMessages()->getAll(){"muted_message"}));
			$e->setCancelled();
			return;
		}
		if(isset($this->players[spl_object_hash($e->getPlayer())]) and
			(time() - $this->players[spl_object_hash($e->getPlayer())] <= intval(YamlProvider::getSpamMessages()->get("time")))){
			if(!isset($this->warnings[spl_object_hash($e->getPlayer())])){
				$this->warnings[spl_object_hash($e->getPlayer())] = 0;
			}
			++$this->warnings[spl_object_hash($e->getPlayer())];
			$e->getPlayer()->sendMessage(str_replace("%warns%", $this->warnings[spl_object_hash($e->getPlayer())],
				FMT::colorMessage(YamlProvider::getSpamMessages()->getAll(){"warning_message"})));
			$e->setCancelled();
			if($this->warnings[spl_object_hash($e->getPlayer())] >= intval(YamlProvider::getSpamMessages()->get("max_warnings"))){
				if(strtolower(YamlProvider::getSpamMessages()->getAll(){"block_type"}) === "message"){
					$e->getPlayer()->sendMessage(str_replace("%player%", $e->getPlayer()->getName(), FMT::colorMessage(YamlProvider::getSpamMessages()->getAll(){"message"})));
					unset($this->warnings[spl_object_hash($e->getPlayer())]);
					$e->setCancelled();
				}
				if(strtolower(YamlProvider::getSpamMessages()->getAll(){"block_type"}) === "mute"){
					$this->muted[spl_object_hash($e->getPlayer())] = true;
					Core::getPlugin()->getScheduler()->scheduleDelayedTask(new MuteTask($this, $e->getPlayer()), 20*intval(YamlProvider::getSpamMessages()->get("mute_time")));
					$e->getPlayer()->sendMessage(FMT::colorMessage(YamlProvider::getSpamMessages()->getAll(){"mute_message"}));
					unset($this->players[spl_object_hash($e->getPlayer())]);
					unset($this->warnings[spl_object_hash($e->getPlayer())]);
					$e->setCancelled();
				}
				if(strtolower(YamlProvider::getSpamMessages()->getAll(){"block_type"}) === "kick"){
					$e->getPlayer()->kick(str_replace("%player%", $e->getPlayer()->getName(), FMT::colorMessage(YamlProvider::getSpamMessages()->getAll(){"kick_reason"})));
					unset($this->players[spl_object_hash($e->getPlayer())]);
					$e->setCancelled();
				}
				if(strtolower(YamlProvider::getSpamMessages()->getAll(){"block_type"}) === "ban"){
					$e->getPlayer()->kick(str_replace("%player%", $e->getPlayer()->getName(), FMT::colorMessage(YamlProvider::getSpamMessages()->getAll(){"ban_reason"})));
					Core::getPlugin()->getServer()->getNameBans()->addBan($e->getPlayer()->getName(), str_replace("%player%", $e->getPlayer()->getName(), FMT::colorMessage(YamlProvider::getSpamMessages()->getAll(){"ban_reason"})));
					unset($this->warnings[spl_object_hash($e->getPlayer())]);
					unset($this->players[spl_object_hash($e->getPlayer())]);
					$e->setCancelled();
				}
				if(strtolower(YamlProvider::getSpamMessages()->getAll(){"block_type"}) === "ban-ip"){
					$e->getPlayer()->kick(str_replace("%player%", $e->getPlayer()->getName(), FMT::colorMessage(YamlProvider::getSpamMessages()->getAll(){"ip_ban_reason"})));
					Core::getPlugin()->getServer()->getIPBans()->addBan($e->getPlayer()->getAddress(), str_replace("%player%", $e->getPlayer()->getName(), FMT::colorMessage(YamlProvider::getSpamMessages()->getAll(){"ip_ban_reason"})), null, $e->getPlayer()->getName());
					unset($this->warnings[spl_object_hash($e->getPlayer())]);
					unset($this->players[spl_object_hash($e->getPlayer())]);
					$e->setCancelled();
				}
			}
		} else{
			$this->players[spl_object_hash($e->getPlayer())] = time();
		}
	}
}
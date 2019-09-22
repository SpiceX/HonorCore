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
namespace smash\core\Forms;


use pocketmine\Player;
use smash\core\Database\Connection;

abstract class FormManager
{

	public static function  sendFirstTimeForm(Player $player){
		$nulo = " ";
		$br = "\n";
		$line = [
			"§aWelcome to §l§5Night§6mare §r§a! :D, you will have much fun with sumo tournaments and more!",
			"§bDo not forget to join our community chatting with our or personal or more server members you can join by this link: §6{link}",
			"§bYou can follow us on our Twitter §a@{link} §band support us with your follow, you can make suggestions or support our publications with your love",
			"§bFor more information about ranges or general information you can visit us at §6{website link}",
			"§cImportant: §eThe server may contain bugs and some errors which we are gradually solving with your support, you can report them on our discord or twitter"
		];
		$textf = $line[0] . $br . $nulo . $br . $line[1] . $br . $nulo . $br . $line[2] . $br . $nulo . $br . $line[3] . $br . $nulo . $br . $line[4];
		$player->sendForm(new MenuForm("§l§6Information", $textf, [new Button("§aOK", new Image("textures/gui/newgui/buttons/checkbox/checkbox_checked_WhiteBorder", Image::TYPE_PATH))],
			function (Player $player, Button $selected): void {}));
		$player->sendForm(new CustomForm('§aCreate new §6password', [new Input("§bDo not worry, this password will §4only§b be used to secure your account, if we detect something unusual we will ask for it!, §eIf you do not create a password, your account cannot be recovered!", "New Password")],
			function (Player $player, CustomFormResponse $response): void {
				$result = $response->getInput();
				$password = base64_encode($result->getValue());
				$name = $player->getName();
				Connection::getDatabase()->exec("UPDATE Players SET PASSWORD='$password' WHERE NAME='$name'");
				$player->sendMessage("§2> §aPassword set!");
			}));
	}

	public static function sendPetsForm(Player $player){
		$player->sendForm(new MenuForm("§aSelect your §2pet", "What do u want today?", [new Button("§aParrot", new Image("https://pocketminesmash.000webhostapp.com/150px-Loro_rojo_azul.png", Image::TYPE_URL)), new Button("§aWolf", new Image("https://gamepedia.cursecdn.com/minecraft_es_gamepedia/thumb/7/7e/Lobo_(Salvaje).png/620px-Lobo_(Salvaje).png", Image::TYPE_URL))],
		function (Player $player, Button $selected): void{
			if ($selected->getText() == "§aParrot"){
				$player->sendMessage("selected parrot");
			} elseif ($selected->getText() == "§aWolf"){
				$player->sendMessage("selected wolf");
			}
		}));
	}

}
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
* @author PocketmineSmash, MikeGamerYT
*
*/
declare(strict_types=1);
namespace smash\core\TaskHandler;
use smash\{
  core\Loader
    };
use Scoreboards\{
  Scoreboards
    };
use pocketmine\{
  utils\Config,
  Server,
  Player,
  utils\TextFormat,
  scheduler\Task,
  level\Level
    };

class HudTask extends Task
{
  private $plugin;
  public function __construct(Loader $plugin)
  {
    $this->plugin = $plugin;
    }
  
  public function onRun(int $currentTask)
  {
    $world = Server::getInstance()->getLevelByName("world");
    if($world instanceof Level)
    {
      $players = $world->getPlayers():
      foreach($players as $pl)
      {
        $name = $pl->getName();
        $api = Scoreboards::getInstance();
        $api->new($pl, "HudWorld", TextFormat::BOLD . TextFormat::YELLOW . 'Prefix');
        $api->setLine($pl, 1, TextFormat::YELLOW . "Name:" . TextFormat::WHITE . $name);
        $api->getObjectiveName($pl);
        }
      }
    }
  }
?>

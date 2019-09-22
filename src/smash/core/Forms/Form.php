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

use Closure;
use pocketmine\Player;
use pocketmine\utils\Utils;
use function array_merge;
abstract class Form implements \pocketmine\form\Form {
	protected const TYPE_MODAL = "modal";
	protected const TYPE_MENU = "form";
	protected const TYPE_CUSTOM_FORM = "custom_form";
	/** @var string */
	private $title;
	/** @var Closure|null */
	protected $onSubmit;
	/** @var Closure|null */
	protected $onClose;
	/**
	 * @param string $title
	 */
	public function __construct(string $title){
		$this->title = $title;
	}
	/**
	 * @param string $title
	 * @return self
	 */
	public function setTitle(string $title) : self{
		$this->title = $title;
		return $this;
	}
	/**
	 * @return string
	 */
	abstract protected function getType() : string;
	/**
	 * @return callable
	 */
	abstract protected function getOnSubmitCallableSignature() : callable;
	/**
	 * @return array
	 */
	abstract protected function serializeFormData() : array;
	/**
	 * @param Closure $onSubmit
	 * @return self
	 */
	public function onSubmit(Closure $onSubmit) : self{
		Utils::validateCallableSignature($this->getOnSubmitCallableSignature(), $onSubmit);
		$this->onSubmit = $onSubmit;
		return $this;
	}
	/**
	 * @param Closure $onClose
	 * @return self
	 */
	public function onClose(Closure $onClose) : self{
		Utils::validateCallableSignature(function(Player $player) : void{}, $onClose);
		$this->onClose = $onClose;
		return $this;
	}
	/**
	 * @return array
	 */
	final public function jsonSerialize() : array{
		return array_merge(
			["title" => $this->title, "type" => $this->getType()],
			$this->serializeFormData()
		);
	}
}
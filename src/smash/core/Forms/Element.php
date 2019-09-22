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

use JsonSerializable;
use pocketmine\form\FormValidationException;
use function is_int;

abstract class Element implements JsonSerializable{
	/** @var string */
	protected $text;
	/** @var mixed */
	protected $value;
	/**
	 * @param string $text
	 */
	public function __construct(string $text){
		$this->text = $text;
	}
	/**
	 * @return mixed
	 */
	public function getValue(){
		return $this->value;
	}
	/**
	 * @param mixed $value
	 */
	public function setValue($value){
		$this->value = $value;
	}
	/**
	 * @return array
	 */
	final public function jsonSerialize() : array{
		$array = ["text" => $this->getText()];
		if($this->getType() !== null){
			$array["type"] = $this->getType();
		}
		return $array + $this->serializeElementData();
	}
	/**
	 * @return string
	 */
	public function getText() : string{
		return $this->text;
	}
	/**
	 * @return string|null
	 */
	abstract public function getType() : ?string;
	/**
	 * @return array
	 */
	abstract public function serializeElementData() : array;
	/**
	 * @param mixed $value
	 */
	public function validate($value) : void{
		if(!is_int($value)){
			throw new FormValidationException("Expected int, got " . gettype($value));
		}
	}
}
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

use pocketmine\form\FormValidationException;

class Dropdown extends Element{
	/** @var string[] */
	private $options;
	/** @var int */
	private $default;
	/**
	 * @param string   $text
	 * @param string[] $options
	 * @param int      $default
	 */
	public function __construct(string $text, array $options, int $default = 0){
		parent::__construct($text);
		$this->options = $options;
		$this->default = $default;
	}
	/**
	 * @return array
	 */
	public function getOptions() : array{
		return $this->options;
	}
	/**
	 * @return string
	 */
	public function getSelectedOption() : string{
		return $this->options[$this->value];
	}
	/**
	 * @return int
	 */
	public function getDefault() : int{
		return $this->default;
	}
	/**
	 * @return string
	 */
	public function getType() : string{
		return "dropdown";
	}
	/**
	 * @return array
	 */
	public function serializeElementData() : array{
		return [
			"options" => $this->options,
			"default" => $this->default
		];
	}
	public function validate($value) : void{
		parent::validate($value);
		if(!isset($this->options[$value])){
			throw new FormValidationException("Option with index $value does not exist in dropdown");
		}
	}
}
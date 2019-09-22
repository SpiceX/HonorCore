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

class CustomFormResponse{

	/** @var Element[] */
	private $elements;
	/**
	 * @param Element[] $elements
	 */
	public function __construct(array $elements){
		$this->elements = $elements;
	}
	/**
	 * @internal
	 *
	 * @param string $expected
	 *
	 * @return Element|mixed
	 */
	public function tryGet(string $expected = Element::class){
		if(($element = array_shift($this->elements)) instanceof Label){
			return $this->tryGet($expected); //remove useless element
		}elseif($element === null || !($element instanceof $expected)){
			throw new FormValidationException("Expected a element with of type $expected, got " . get_class($element));
		}
		return $element;
	}

	/**
	 * @return Input
	 */
	public function getInput() : Input{
		return $this->tryGet(Input::class);
	}

	/**
	 * @return Element[]
	 */
	public function getElements() : array{
		return $this->elements;
	}
	/**
	 * @return mixed[]
	 */
	public function getValues() : array{
		$values = [];
		foreach($this->elements as $element){
			if($element instanceof Label){
				continue;
			}
			$values[] = $element instanceof Dropdown ? $element->getSelectedOption() : $element->getValue();
		}
		return $values;
	}
}
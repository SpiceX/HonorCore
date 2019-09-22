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
use function is_string;

class Input extends Element
{
	/** @var string */
	private $placeholder;
	/** @var string */
	private $default;

	/**
	 * @param string $text
	 * @param string $placeholder
	 * @param string $default
	 */
	public function __construct(string $text, string $placeholder, string $default = "")
	{
		parent::__construct($text);
		$this->placeholder = $placeholder;
		$this->default = $default;
	}

	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return parent::getValue();
	}

	/**
	 * @return string
	 */
	public function getPlaceholder(): string
	{
		return $this->placeholder;
	}

	/**
	 * @return string
	 */
	public function getDefault(): string
	{
		return $this->default;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return "input";
	}

	/**
	 * @return array
	 */
	public function serializeElementData(): array
	{
		return [
			"placeholder" => $this->placeholder,
			"default" => $this->default
		];
	}

	/**
	 * @param $value
	 */
	public function validate($value): void
	{
		if (!is_string($value)) {
			throw new FormValidationException("Expected string, got " . gettype($value));
		}
	}
}
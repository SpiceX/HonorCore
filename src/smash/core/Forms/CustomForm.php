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
use pocketmine\form\FormValidationException;
use pocketmine\Player;

class CustomForm extends Form
{

	protected const TYPE_MODAL = "modal";
	protected const TYPE_MENU = "form";
	protected const TYPE_CUSTOM_FORM = "custom_form";
	/** @var Element[] */
	private $elements = [];

	public function __construct(string $title, array $elements, Closure $onSubmit, ?Closure $onClose = null)
	{
		parent::__construct($title);
		$this->elements = $elements;
		$this->onSubmit($onSubmit);
		if ($onClose !== null) {
			$this->onClose($onClose);
		}
	}

	protected function getType(): string
	{
		return self::TYPE_CUSTOM_FORM;
	}

	protected function getOnSubmitCallableSignature(): callable
	{
		return function (Player $player, CustomFormResponse $response): void {
		};
	}

	protected function serializeFormData(): array
	{
		return ["content" => $this->elements];
	}


	public function append(Element ...$elements): self
	{
		$this->elements = array_merge($this->elements, $elements);
		return $this;
	}

	final public function handleResponse(Player $player, $data): void
	{
		if ($data === null) {
			if ($this->onClose !== null) {
				($this->onClose)($player);
			}
		} elseif (is_array($data)) {
			foreach ($data as $index => $value) {
				if (!isset($this->elements[$index])) {
					throw new FormValidationException("Element at index $index does not exist");
				}
				$element = $this->elements[$index];
				$element->validate($value);
				$element->setValue($value);
			}
			($this->onSubmit)($player, new CustomFormResponse($this->elements));
		} else {
			throw new FormValidationException("Expected array or null, got " . gettype($data));
		}
	}
}
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

class Button extends Element{
	/** @var Image|null */
	private $image;
	/** @var string */
	private $type;
	/**
	 * @param string     $text
	 * @param Image|null $image
	 */
	public function __construct(string $text, ?Image $image = null){
		parent::__construct($text);
		$this->image = $image;
	}
	/**
	 * @return string|null
	 */
	public function getType() : ?string{
		return null;
	}
	/**
	 * @return bool
	 */
	public function hasImage() : bool{
		return $this->image !== null;
	}
	/**
	 * @return array
	 */
	public function serializeElementData() : array{
		$data = ["text" => $this->text];
		if($this->hasImage()){
			$data["image"] = $this->image;
		}
		return $data;
	}
}
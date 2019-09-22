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

class Image implements JsonSerializable{
	public const TYPE_URL = "url";
	public const TYPE_PATH = "path";
	/** @var string */
	private $type;
	/** @var string */
	private $data;
	/**
	 * @param string $data
	 * @param string $type
	 */
	public function __construct(string $data, string $type = self::TYPE_URL){
		$this->type = $type;
		$this->data = $data;
	}
	/**
	 * @return string
	 */
	public function getType() : string{
		return $this->type;
	}
	/**
	 * @return string
	 */
	public function getData() : string{
		return $this->data;
	}
	public function jsonSerialize() : array{
		return [
			"type" => $this->type,
			"data" => $this->data
		];
	}
}
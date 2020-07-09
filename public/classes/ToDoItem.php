<?php

class ToDoItem extends Item {
	protected ?int $id = null;

	protected static function &Cache($data) {
		if (is_array($data)) {
			if (!isset(static::$cache[$data["id"]])) {
				static::$cache[$data["id"]] = new static($data);
			}
			return static::$cache[$data["id"]];
		} elseif ($data instanceof static) {
			if (!isset(static::$cache[$data->getDatabaseId()])) {
				static::$cache[$data->getDatabaseId()] = $data;
			}
			return static::$cache[$data->getDatabaseId()];
		} else {
			$class = get_called_class();
			throw new InvalidArgumentException(__METHOD__ . " requires either a $class, or an Array of information to create a new $class");
		}
	}

	public static function Get($data) {
		$shopItem = false;
		if ($data instanceof static) {
			$shopItem = $data;
		} elseif (is_numeric($data)) {
			$shopItem = parent::Get(["id" => $data]);
		} elseif (is_array($data)) {
			$shopItem = parent::Get($data);
		} elseif ($data == null) {
			$shopItem = null;
		}
		if ($shopItem === false) {
			$class = get_called_class();
			throw new InvalidArgumentException(__METHOD__ . " requires either a $class, a $class ID or an Array of information to look up");
		}
		return $shopItem;
	}
	/*
	public static function Find($data = null) {
		$shopItem;
		if ($data instanceof static) {
			$shopItem = $data;
		} elseif (is_numeric($data)) {
			$shopItem = parent::Find(["id" => $data]);
		} elseif (is_array($data)) {
			$shopItem = parent::Find($data);
		} else {
			$shopItem = parent::Find();
		}
		if (!isset($shopItem)) {
			$class = get_called_class();
			throw new InvalidArgumentException(__METHOD__ . " requires either a $class, a $class ID or an Array of information to look up");
		}
		return $shopItem;
	}
	*/

	public function __construct(Array $data) {
		$this->setId($data["id"] ?? null);
	}

	public function getDatabaseId() {
		return $this->getId();
	}
	public function inDatabase() {
		return (bool)static::Get(["id" => $this->getId()]);
	}

	public function getId() { return $this->id; }
	public function setId($id = null) {
		if ($id) {
			if (!is_numeric($id)) {
				$id = (int)$id;
			}
			$this->id = $id;
		}
	}
}
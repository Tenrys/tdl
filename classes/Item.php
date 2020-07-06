<?php

abstract class Item implements JsonSerializable {
	public static PDO $db;
	protected static Array $cache;
	protected static string $table;

	protected static Array $sqlMap = [];

	abstract public function getDatabaseId();
	abstract public function inDatabase();
	public function toArray() {
		$arr = [];

		foreach ($this as $key => $value) {
			$arr[$key] = $value;
		}

		return $arr;
	}
	public function jsonSerialize() {
		return $this->toArray();
	}
	public function forSQL() {
		$arr = $this->toArray();

		foreach ($arr as $key => $value) {
			if ($value instanceof self && !$value->inDatabase()) {
				throw new InvalidArgumentException(get_class($value) . " " . $key . " is not part of the database");
			}

			if ($value instanceof DateTime) {
				$arr[$key] = mysql_timestamp($value);
			} elseif ($value instanceof self) {
				$arr[$key] = $value->getDatabaseId();
			}
		}

		foreach (static::$sqlMap as $from => $to) {
			$arr[$to] = $arr[$from];
			unset($arr[$from]);
		}

		return $arr;
	}

	abstract protected static function Cache($data);

	public static function Ready() {
		return self::$db instanceof PDO && is_string(static::$table);
	}

	public static function Query(string $request, Array $data = []) {
		$stmt = self::$db->prepare($request);
		$success = $stmt->execute($data);
		$result = $stmt->fetchAll();
		return [$success, $result, $stmt];
	}

	public static function Find(Array $data = []) {
		if (!static::Ready()) return;

		$request = "SELECT * FROM " . static::$table;
		if (count($data) > 0) {
			$request .= " WHERE\n";
			$i = 0;
			foreach ($data as $key => $_) {
				if (is_string($key)) {
					$request .= "$key = :$key";
					$i++;
					if ($i < count($data)) {
						$request .= " AND \n";
					}
				}
			}
		}

		[$success, $result, $stmt] = self::Query($request, $data);
		if (is_array($result)) {
			foreach ($result as $key => $value) {
				$result[$key] = &static::Cache($value);
			}
		}

		return $result;
	}

	public static function Get(Array $data) {
		$result = static::Find($data);
		if ($result) $result = &$result[0];

		return is_array($result) ? null : $result;
	}

	public static function Insert(self &$item) {
		if (!static::Ready()) return;

		if (!$item instanceof static) {
			throw new InvalidArgumentException(__METHOD__ . " requires an argument " . get_called_class());
		}

		$sqlArr = $item->forSQL();

		$request = "INSERT INTO " . static::$table . " (" . implode(", ", array_keys($sqlArr)) . ")
		VALUES (" . implode(", ", array_map(function($key) { return ":$key"; }, array_keys($sqlArr)))  . ")";

		[$success, $result, $stmt] = self::Query($request, $sqlArr);
		if ($success) {
			if (!$item->getId()) {
				$item->setId(self::$db->lastInsertId());
			}
			static::Cache($item);
			return true;
		} else {
			var_dump($stmt->errorInfo());
			return false;
		}
	}

	public static function Delete(self &$item) {
		if (!static::Ready()) return;

		if (!$item instanceof static) {
			throw new InvalidArgumentException(__METHOD__ . " requires an argument " . get_called_class());
		}

		if (!$item->getId()) {
			throw new InvalidArgumentException(__METHOD__ . " requires the " . get_called_class() . " to have an ID assigned");
		}

		$request = "DELETE FROM " . static::$table . " WHERE id = ?";

		[$success, $result, $stmt] = self::Query($request, [$item->getId()]);
		if ($success) {
			unset(static::$cache[$item->getId()]);
			$item = null;
			return true;
		} else {
			var_dump($stmt->errorInfo());
			return false;
		}
	}

	public static function Update(self $item) {
		if (!static::Ready()) return;

		if (!$item instanceof static) {
			throw new InvalidArgumentException(__METHOD__ . " requires an argument " . get_called_class());
		}

		if (!$item->getId()) {
			throw new InvalidArgumentException(__METHOD__ . " requires the " . get_called_class() . " to have an ID assigned");
		}

		$sqlArr = $item->forSQL();
		$cols = [];
		foreach($sqlArr as $key => $val) {
			$cols[] = "$key = :$key";
		}
		$request = "UPDATE " . static::$table . " SET " . implode(", ", $cols) . " WHERE id = :id";

		[$success, $result, $stmt] = self::Query($request, $sqlArr);
		if ($success) {
			return true;
		} else {
			var_dump($stmt->errorInfo());
			return false;
		}
	}
}

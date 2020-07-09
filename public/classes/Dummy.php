<?php

// Example MySQL object class deriving ShopItem, DO NOT USE, only copy from.

class Dummy extends ToDoItem {
	protected static Array $cache = [];
	protected static string $table = "";

	protected static Array $sqlMap = [ // When Dummy->forSQL is called, property "from" will be renamed to "to"
		"from" => "to"
	];

	function __construct(Array $data = []) {
		parent::__construct($data);
	}
}


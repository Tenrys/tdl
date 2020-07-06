<?php

function _set_item_date(Item $item, string $method, $date) {
	if (is_string($date)) {
		$date = new DateTime($date);
	}
	if (!$date instanceof DateTime) {
		throw new InvalidArgumentException(__METHOD__ . " requires either a DateTime or valid DateTime string");
	}
	$item->$method($date);
}

trait DateProperty {
	protected DateTime $date;

	public function getDate() { return $this->date; }
	public function _setDate($date) { $this->date = $date; }
	public function setDate($date) { _set_item_date($this, "_setDate", $date); }
}

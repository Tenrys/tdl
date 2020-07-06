<?php

class ToDo extends ToDoItem {
	protected static Array $cache = [];
	protected static string $table = "todo";

	protected string $description;
	protected string $status;
	protected User $assigned;
	protected DateTime $createdAt;
	protected DateTime $startedAt;
	protected DateTime $completedAt;

	protected static Array $sqlMap = [ // When Dummy->forSQL is called, property "from" will be renamed to "to"
		"assigned" => "id_assigned",
		"startedAt" => "started_at",
		"createdAt" => "created_at",
		"completedAt" => "completed_at"
	];

	function __construct(Array $data = []) {
		parent::__construct($data);

		$this->setDescription($data["description"] ?? "");
		$this->setStatus($data["status"] ?? "");
		$this->setAssigned($data["id_assigned"] ?? "");
		$this->setCreatedAt($data["created_at"] ?? "");
		$this->setStartedAt($data["started_at"] ?? "");
		$this->setCompletedAt($data["completed_at"] ?? "");
	}

	// Getters
	public function getDescription() { return $this->description; }
	public function getStatus() { return $this->status; }
	public function getAssigned() { return $this->assigned; }

	// Setters
	public function setDescription(string $description) { $this->description = $description; }
	public function setStatus(string $status) { $this->status = $status; }
	public function setAssigned($user) { $this->assigned = User::Get($user); }

	// Date stuff, eugh
	public function getCreatedAt() { return $this->createdAt; }
	public function _setCreatedAt($date) { $this->createdAt = $date; }
	public function setCreatedAt($date) { _set_item_date($this, "_setCreatedAt", $date); }

	public function getStartedAt() { return $this->startedAt; }
	public function _setStartedAt($date) { $this->startedAt = $date; }
	public function setStartedAt($date) { _set_item_date($this, "_setStartedAt", $date); }

	public function getCompletedAt() { return $this->completedAt; }
	public function _setCompletedAt($date) { $this->completedAt = $date; }
	public function setCompletedAt($date) { _set_item_date($this, "_setCompletedAt", $date); }
}

?>
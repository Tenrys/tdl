<?php

class User extends ToDoItem {
	protected static Array $cache = [];
	protected static string $table = "users";

	protected string $username;
	protected string $password;
	protected string $rank;

	public static function Register(Array $data, ?User $user = null) {
		$fields = [
			"username" => true,
			"password" => true,
			"passwordConfirm" => true
		];

		foreach (array_keys($fields) as $field) {
			if (!isset($data[$field])) return [false, "Champ '$field' manquant", null];
		}

		if (User::Get(["username" => $data["username"]]) && (!isset($user) || $user->getUsername() != $data["username"])) {
			return [false, "Ce nom d'utilisateur est déjà utilisé par un autre utilisateur", null];
		}

		if ($data["password"] !== $data["passwordConfirm"]) {
			return [false, "Veuillez confirmer votre mot de passe correctement", null];
		}

		// On ne veut que les valeurs qui nous concernent... Car n'importe qui peut mettre n'importe quoi dans son POST !
		unset($data["passwordConfirm"]);
		$data = array_intersect_key($data, $fields);

		if ($user == null) {
			$user = new User($data);
			$user->setPassword($data["password"], true); // Cryptage du mot de passe
			User::Insert($user);
		} else {
			$user->setUsername($data["username"]);
			$user->setPassword($data["password"], true);
			User::Update($user);
		}

		return [true, "Inscription réussie", $user];
	}

	public static function Login(string $username, string $password) {
		if (!$username) { // Le champ peut être vide ...
			return [false, "Champ 'username' manquant", null];
		}
		if (!$password) {
			return [false, "Champ 'password' manquant", null];
		}
		if (($user = User::Get(["username" => $username])) && password_verify($password, $user->getPassword())) {
			return [true, "", $user];
		}
		return [false, "Mot de passe incorrect", null]; // On ne fait pas savoir si un compte existe à l'adresse e-mail renseignée
	}

	function __construct(Array $data = []) {
		parent::__construct($data);

		$this->setUsername($data["username"] ?? "");
		$this->setPassword($data["password"] ?? "", false); // On recrée seulement un mot de passe si besoin
		$this->setRank($data["rank"] ?? "user");
	}

	public function getUsername() { return $this->username; }
	public function getPassword() { return $this->password; }
	public function getRank() { return $this->rank; }

	public function setUsername(string $username) { $this->username = $username; }
	public function setPassword(string $password, bool $hash = false) {
		if ($hash) {
			$password = password_hash($password, PASSWORD_BCRYPT);
		}
		$this->password = $password;
	}
	public function setRank(string $rank) { $this->rank = $rank; }
}

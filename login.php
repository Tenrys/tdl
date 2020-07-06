<?php

require_once("includes/init.php");

if (isset($_SESSION["user"])) { index(); }

if (isset($_POST["login"])) {
	$username = $_POST["username"] ?? "";
	$password = $_POST["password"] ?? "";
	[$success, $message, $user] = User::Login($username, $password);

	if ($success && $user instanceof User) {
		$_SESSION["user"] = $user;

		index();
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php require("includes/head.php") ?>
		<title>Connexion</title>
	</head>
	<body>
		<?php require("includes/header.php") ?>

		<main>
			<section class="section">
				<div class="columns is-centered">
					<div class="column is-narrow">
						<h1 class="title">Connexion</h1>

						<?php if (isset($message)) { ?>
							<article class="message">
								<div class="message-body">
									<?= $message ?>
								</div>
							</article>
						<?php } ?>

						<form method="POST">
							<div class="field">
								<label class="label" for="username">Nom d'utilisateur</label>
								<div class="control">
									<input class="input" type="text" name="username" required>
								</div>
							</div>
							<div class="field">
								<label class="label" for="password">Mot de passe</label>
								<div class="control">
									<input class="input" type="password" name="password" required>
								</div>
							</div>
							<div class="field">
								<div class="control">
									<input class="button is-link" type="submit" name="login" value="Se connecter">
								</div>
							</div>
						</form>
					</div>
				</div>
			</section>
		</main>

		<?php require("includes/footer.php") ?>
	</body>
</html>
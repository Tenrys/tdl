<?php

require_once("includes/init.php");

if (!isset($_SESSION["user"])) {
	index();
}

if (isset($_POST["update"])) {
	[$success, $message, $user] = User::Register($_POST, $_SESSION["user"]);

	if ($success) {
		header("Location: profile.php");
		die;
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php require("includes/head.php") ?>
		<title>Modifier mon profil</title>
	</head>
	<body>
		<?php require("includes/header.php") ?>

		<main>
			<section class="section">
				<div class="columns is-centered">
					<div class="column is-narrow">
						<h1 class="title">Modifier mon profil</h1>

						<?php if (isset($success) && !$success) { ?>
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
									<input class="input" type="text" minlength="3" maxlength="255" name="username" required value="<?= htmlspecialchars($_SESSION["user"]->getUsername()) ?>">
								</div>
							</div>
							<div class="field">
								<label class="label" for="password">Mot de passe</label>
								<div class="control">
									<input class="input" type="password" name="password" value="<?= htmlspecialchars($_POST["password"] ?? "") ?>"><br>
								</div>
							</div>
							<div class="field">
								<label class="label" for="passwordConfirm">Confirmez votre mot de passe</label>
								<div class="control">
									<input class="input" type="password" name="passwordConfirm" value="<?= htmlspecialchars($_POST["passwordConfirm"] ?? "") ?>">
								</div>
							</div>
							<div class="field">
								<div class="control">
									<input class="button is-link" type="submit" name="update" value="Modifier">
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

<?php

require_once("includes/init.php");

if (isset($_SESSION["user"])) { index(); }

if (isset($_POST["register"])) {
	[$success, $message, $user] = User::Register($_POST);

	if ($success) {
		header("Refresh: 5; URL=login.php");
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php require("includes/head.php") ?>
		<title>Inscription</title>
	</head>

	<body>
		<?php require("includes/header.php") ?>

		<main>
			<section class="section">
				<div class="columns is-centered">
					<div class="column is-narrow">
						<h1 class="title">Inscription</h1>

						<?php if (isset($success) && $success) { ?>
							<p>Inscription réussie !<p>
							<p>Vous allez être redirigé vers la page de connexion...</p>
						<?php } else {
							if (isset($message)) { ?>
								<article class="message is-danger">
									<div class="message-body">
										<?= $message ?>
									</div>
								</article>
							<?php } ?>
							<form method="POST">
								<div class="field">
									<label class="label" for="username">Nom d'utilisateur</label>
									<div class="control">
										<input class="input" type="text" name="username" required value="<?= $_POST['username'] ?? '' ?>">
									</div>
								</div>
								<div class="field">
									<label class="label" for="password">Mot de passe</label>
									<div class="control">
										<input class="input" type="password" name="password" required value="<?= $_POST['password'] ?? '' ?>"><br>
									</div>
								</div>
								<div class="field">
									<label class="label" for="passwordConfirm">Confirmez votre mot de passe</label>
									<div class="control">
										<input class="input" type="password" name="passwordConfirm" required value="<?= $_POST['passwordConfirm'] ?? '' ?>"><br>
									</div>
								</div>
								<div class="field">
									<div class="control">
										<input class="button is-link" type="submit" name="register" value="S'inscrire">
									</div>
								</div>
							</form>
						<?php } ?>
					</div>
				</div>
			</section>
		</main>

		<?php require("includes/footer.php") ?>
	</body>
</html>
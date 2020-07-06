<?php

require_once("includes/init.php");

if (!isset($_SESSION["user"])) {
	index();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php require("includes/head.php") ?>
		<title>Mon profil</title>
	</head>
	<body>
		<?php require("includes/header.php") ?>

		<main>
			<section class="section">

				<div class="columns is-centered">
					<div class="column is-narrow">
						<h1 class="title">Mon profil</h1>
						<div class="field">
							<label class="label">Nom d'utilisateur</label>
							<div class="control">
								<p>
									<?= htmlspecialchars($_SESSION["user"]->getUsername()) ?>
								</p>
							</div>
						</div>
						<div class="field">
							<div class="label">Rang</div>
							<div class="control">
								<p>
									<?= $ranks[$_SESSION["user"]->getRank()] ?? "???" ?>
								</p>
							</div>
						</div>
						<div class="field">
							<div class="control">
								<a class="button is-link" href="edit-profile.php">Modifier</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>

		<?php require("includes/footer.php") ?>
	</body>
</html>

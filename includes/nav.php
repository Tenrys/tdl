<nav class="navbar is-dark">
	<div class="navbar-menu">
		<div class="navbar-start" style="flex-grow: 1; justify-content: center;">
			<a class="navbar-item" href="index.php">
				Accueil
			</a>
			<?php if (isset($_SESSION["user"])) { ?>
				<a class="navbar-item" href="profile.php">
					<?= $_SESSION["user"]->getUsername(); ?>
				</a>
				<a class="navbar-item" href="disconnect.php">
					Déconnexion
				</a>
			<?php } else { ?>
				<a class="navbar-item" href="register.php">
					Inscription
				</a>
				<a class="navbar-item" href="login.php">
					Connexion
				</a>
			<?php } ?>
		</div>
	</div>
</nav>
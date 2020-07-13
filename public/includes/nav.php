<nav class="navbar is-dark">
	<div class="navbar-brand">
		<div class="navbar-item">
			<p class="has-text-warning"><b>Liste de tâches</b></p>
		</div>
	</div>
	<div class="navbar-menu is-active">
		<div class="navbar-start">
			<a class="navbar-item" href="index.php">
				Accueil
			</a>
			<a class="navbar-item" href="users.php">
				Utilisateurs
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
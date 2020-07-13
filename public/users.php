<?php

require_once("includes/init.php");

?>

<!DOCTYPE html>
<html>

	<head>
		<?php require("includes/head.php") ?>
		<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
		<title>Liste d'utilisateurs</title>
	</head>

	<body>
		<?php require("includes/header.php") ?>

		<main>
			<section class="section" id="users">
				<div class="columns is-centered">
					<div class="column is-narrow-desktop">
						<div v-if="isAdmin" class="buttons">
							<div class="dropdown" :class="{ 'is-active': dropdowns.changeRank.active }" @click="toggleDropdown('changeRank')">
								<div class="dropdown-trigger">
									<button class="button is-link">
										<span>Changer le rang...</span>
										<span class="icon is-small">
                                            <i class="fas fa-angle-down"></i>
                                        </span>
									</button>
								</div>
								<div class="dropdown-menu">
									<div class="dropdown-content">
										<a class="dropdown-item" v-for="rank in ranks" :key="rank" @click="changeRank(rank)">{{ rank }}</a>
									</div>
								</div>
							</div>
							<button class="button is-danger" @click="deleteUsers()">Supprimer</button>
						</div>
						<div is="Table" :rows="rows" :row-type="UserRow" :data="users" :is-admin="isAdmin"></div>
					</div>
				</div>
			</section>
		</main>

		<?php require("includes/footer.php") ?>

		<script src="bundle.js"></script>
	</body>

</html>
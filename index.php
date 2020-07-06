<?php

require_once("includes/init.php");

?>

<!DOCTYPE html>
<html>

	<head>
		<?php require("includes/head.php") ?>
		<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
		<title>Liste de tâches</title>

		<?php require("js/components/ToDo.vue") ?>
	</head>

	<body>
		<?php require("includes/header.php") ?>

		<main>
			<section class="hero has-background-warning-dark has-text-centered">
				<div class="hero-body">
					<div class="container">
						<h1 class="title has-text-warning">Liste de tâches</h1>
					</div>
				</div>
			</section>
			<section class="section" id="app">
				<div class="columns is-centered">
					<div class="column is-narrow">
						<table class="table is-hoverable">
							<thead>
								<th></th>
								<th>ID</th>
								<th>Tâche</th>
								<th>Assignée à</th>
								<th>Statut</th>
								<th>Créée le</th>
								<th>Démarrée le</th>
								<th>Terminée le</th>
								<th>Actions</th>
							</thead>
							<tbody>
								<tr is="todo" v-for="todo in todos" :key="todo.id" v-bind="todo">
									<template>
										<input type="checkbox" v-model="todo.selected">
									</template>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</main>

		<?php require("includes/footer.php") ?>

		<script src="js/index.js"></script>
	</body>

</html>
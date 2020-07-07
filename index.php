<?php

require_once("includes/init.php");

?>

<!DOCTYPE html>
<html>

	<head>
		<?php require("includes/head.php") ?>
		<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
		<title>Liste de tâches</title>
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
						<div v-if="isAdmin" class="buttons is-right">
							<button class="button is-link" @click="showModal({})">Nouveau</button>
						</div>
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
								<th v-if="isAdmin">Actions</th>
							</thead>
							<tbody>
								<tr is="ToDo" v-for="todo in todos" :key="todo.id" v-bind="todo" @edit="showModal(todo)">
									<td>
										<input type="checkbox" v-model="todo.selected">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div is="ToDoModal" :todo="dirtyTodo" :class="{ 'is-active': dirtyTodo }"></div>
			</section>
		</main>

		<?php require("includes/footer.php") ?>

		<script src="bundle.js"></script>
	</body>

</html>
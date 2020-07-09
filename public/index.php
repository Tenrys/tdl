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
			<section class="section" id="app">
				<div class="columns is-centered">
					<div class="column is-narrow-desktop">
						<div v-if="isAdmin" class="buttons">
							<button class="button is-success" @click="showModal({})">Nouveau</button>
							<div class="dropdown" :class="{ 'is-active': dropdowns.assignTo.active }" @click="toggleDropdown('assignTo')">
								<div class="dropdown-trigger">
									<button class="button">
										Assigner à...
									</button>
								</div>
								<div class="dropdown-menu">
									<div is="UserList" class="dropdown-content" item-class="dropdown-item" @picked="assignTo">
										<hr class="dropdown-divider">
									</div>
								</div>
							</div>
							<div class="dropdown" :class="{ 'is-active': dropdowns.changeStatus.active }" @click="toggleDropdown('changeStatus')">
								<div class="dropdown-trigger">
									<button class="button is-link">
										Changer le statut...
									</button>
								</div>
								<div class="dropdown-menu">
									<div class="dropdown-content">
										<a class="dropdown-item" v-for="status in statuses" :class="status.class" @click="changeStatus(status.id)">{{ status.display }}</a>
									</div>
								</div>
							</div>
							<button class="button is-danger">Supprimer</button>
						</div>
						<div class="table-container">
							<table class="table is-striped">
								<thead>
									<th><input type="checkbox" v-model="allSelected"></th>
									<th>ID</th>
									<th @click="sort('id')">Tâche</th>
									<th @click="sort('assigned')">Assignée à</th>
									<th @click="sort('status')">Statut</th>
									<th @click="sort('createdAt')">Créée le</th>
									<th @click="sort('startedAt')">Démarrée le</th>
									<th @click="sort('completedAt')">Terminée le</th>
									<th v-if="isAdmin"></th>
								</thead>
								<tbody>
									<tr is="ToDo" v-for="todo in todos" :key="todo.id" v-bind="todo" @edit="showModal(todo)">
										<td>
											<input type="checkbox" :checked="todo.selected" @input="toggleTodo(todo)">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div is="ToDoModal" :todo="dirtyTodo" :class="{ 'is-active': dirtyTodo }"></div>
			</section>
		</main>

		<?php require("includes/footer.php") ?>

		<script src="bundle.js"></script>
	</body>

</html>
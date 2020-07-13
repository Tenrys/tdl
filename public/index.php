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
							<button class="button is-success" @click="showModal()">Nouveau</button>
							<div class="dropdown" :class="{ 'is-active': dropdowns.assignTo.active }" @click="toggleDropdown('assignTo')">
								<div class="dropdown-trigger">
									<button class="button">
										<span>Assigner à...</span>
										<span class="icon is-small">
                                            <i class="fas fa-angle-down"></i>
                                        </span>
									</button>
								</div>
								<div class="dropdown-menu">
									<div is="UserList" class="dropdown-content" item-class="dropdown-item" @picked="assignTo" :users="users">
										<hr class="dropdown-divider">
									</div>
								</div>
							</div>
							<div class="dropdown" :class="{ 'is-active': dropdowns.changeStatus.active }" @click="toggleDropdown('changeStatus')">
								<div class="dropdown-trigger">
									<button class="button is-link">
										<span>Changer le statut...</span>
										<span class="icon is-small">
                                            <i class="fas fa-angle-down"></i>
                                        </span>
									</button>
								</div>
								<div class="dropdown-menu">
									<div class="dropdown-content">
										<a class="dropdown-item" v-for="status in statuses" :key="status.id" :class="status.class" @click="changeStatus(status.id)">{{ status.display }}</a>
									</div>
								</div>
							</div>
							<button class="button is-danger" @click="deleteTasks()">Supprimer</button>
						</div>
						<div class="table-container">
							<table class="table is-striped">
								<thead>
									<th><input type="checkbox" v-model="all"></th>
									<th v-for="row of rows" :key="row.name" @click="sort(row.name)">
										<span>{{ row.display }}</span>
										<span class="icon is-small">
                                            <i class="fas" v-if="sortMethod == row.name" :class="{ 'fa-angle-down':  sortReverse, 'fa-angle-up': !sortReverse }"></i>
                                        </span>
									</th>
									<th v-if="isAdmin"></th>
								</thead>
								<tbody>
									<tr is="ToDo" v-for="todo in sortedTodos" :key="todo.id" v-bind="todo" @edit="showModal">
										<td>
											<input type="checkbox" :checked="todo.selected" @input="$set(todo, 'selected', !todo.selected)">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div is="ToDoModal" v-if="dirtyTodo" :todo="dirtyTodo" :users="users" @cancel="showModal(null)" @submit="postTodos([dirtyTodo])" @delete="deleteTasks([dirtyTodo])"></div>
			</section>
		</main>

		<?php require("includes/footer.php") ?>

		<script src="bundle.js"></script>
	</body>

</html>
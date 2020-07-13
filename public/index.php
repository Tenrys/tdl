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
			<section class="section" id="index">
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
						<div is="Table" :rows="rows" :row-type="ToDoRow" :data="todos" @edit="showModal" :is-admin="isAdmin"></div>
					</div>
				</div>
				<div is="ToDoModal" v-if="dirtyTodo" :todo="dirtyTodo" :users="users" @cancel="showModal(null)" @submit="postTodos([dirtyTodo])" @delete="deleteTasks([dirtyTodo])"></div>
			</section>
		</main>

		<?php require("includes/footer.php") ?>

		<script src="bundle.js"></script>
	</body>

</html>
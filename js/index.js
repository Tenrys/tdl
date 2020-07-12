import ToDo from "./components/ToDo.vue";
import ToDoModal from "./components/ToDoModal.vue";
import UserList from "./components/UserList.vue";
import { get, sortBy, find } from "lodash";

new Vue({
	components: { ToDo, ToDoModal, UserList },
	el: "#app",
	data() {
		return {
			todos: [],
			user: {},
			users: [],
			dirtyTodo: null,
			sortMethod: null,
			sortReverse: null,
			dropdowns: {
				assignTo: { active: false },
				changeStatus: { active: false },
			},
			statuses: [
				{ id: "WAITING", class: "", display: "En attente" },
				{ id: "IN_PROGRESS", class: "has-text-info-dark", display: "En cours" },
				{ id: "COMPLETED", class: "has-text-success-dark", display: "Terminée" },
				{ id: "WAITING", class: "has-text-warning-dark", display: "Annulée" },
			],
			rows: [
				{ name: "id", display: "ID" },
				{ name: "description", display: "Tâche" },
				{ name: "assigned.username", display: "Assignée à" },
				{ name: "status", display: "Statut" },
				{ name: "createdAt.date", display: "Créée le" },
				{ name: "startedAt.date", display: "Démarrée le" },
				{ name: "completedAt.date", display: "Terminée le" },
			],
		};
	},
	computed: {
		isAdmin() {
			return this.user && this.user.rank == "ADMIN";
		},
		sortedTodos() {
			if (!this.sortMethod) {
				return this.todos;
			}
			const todos = sortBy(this.todos, this.sortMethod);
			if (this.sortReverse) {
				todos.reverse();
			}
			return todos;
		},
		selected() {
			return this.todos.filter(todo => todo.selected);
		},
		all: {
			get() {
				return this.selected.length > this.todos.length / 2;
			},
			set() {
				const all = !this.all;
				for (const todo of this.todos) {
					this.$set(todo, "selected", all);
				}
			},
		},
	},
	async mounted() {
		this.todos = await (await fetch("api/todos.php")).json();
		this.user = await (await fetch("api/auth.php")).json();
		this.users = await (await fetch("api/users.php")).json();
	},
	methods: {
		showModal(todo) {
			this.dirtyTodo = todo;
		},
		toggleDropdown(name) {
			for (const [_name, dropdown] of Object.entries(this.dropdowns)) {
				if (_name != name) dropdown.active = false;
			}
			this.dropdowns[name].active = !this.dropdowns[name].active;
		},
		sort(method) {
			if (this.sortMethod != method) {
				this.sortMethod = method;
				this.sortReverse = false;
			} else if (this.sortMethod == method) {
				this.sortReverse = !this.sortReverse;
			}
		},
		assignTo(user) {
			for (const todo of this.selected) {
				todo.assigned = user;
			}
			this.postTodos();
		},
		changeStatus(status) {
			for (const todo of this.selected) {
				todo.status = status;
			}
			this.postTodos();
		},
		async deleteTasks() {
			if (this.selected.length < 1) return;

			if (confirm("Êtes-vous sûr de vouloir supprimer ces tâches ?")) {
				await fetch("api/todos.php", {
					method: "DELETE",
					body: JSON.stringify({ todos: this.selected }),
				});

				for (const [k, todo] of Object.entries(this.todos)) {
					for (const _todo of this.selected) {
						if (_todo.id == todo.id) {
							this.todos.splice(k, 1);
						}
					}
				}

				this.$forceUpdate();
			}
		},
		async postTodos() {
			if (this.selected.length < 1) return;

			const res = await fetch("api/todos.php", {
				method: "POST",
				body: JSON.stringify({ todos: this.selected }),
			});

			const data = await res.json();
			for (const [k, todo] of Object.entries(this.todos)) {
				for (const _todo of data) {
					if (_todo.id == todo.id) {
						this.$set(this.todos, k, {
							...this.todos[k],
							..._todo,
						});
						break;
					}
				}
			}
		},
	},
});

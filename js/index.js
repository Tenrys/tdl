import ToDo from "./components/ToDo.vue";
import ToDoModal from "./components/ToDoModal.vue";
import UserList from "./components/UserList.vue";

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
			const todos = this.todos.slice().sort((a, b) => {
				if (a[this.sortMethod] < b[this.sortMethod]) {
					return -1;
				} else {
					return 1;
				}
				return 0;
			});
			if (this.sortReverse) {
				todos.reverse();
			}
			return todos;
		},
		allSelected: {
			get() {
				return this.todos.filter(todo => todo.selected).length == this.todos.length;
			},
			set() {
				const state =
					this.todos.filter(todo => todo.selected).length <= this.todos.length / 2;
				for (const todo of this.todos) {
					this.$set(todo, "selected", state);
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
		toggleTodo(todo) {
			this.$set(todo, "selected", !todo.selected);
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
			for (const todo of this.todos.filter(todo => todo.selected)) {
				todo.assigned = user;
			}
			this.postTodos();
		},
		changeStatus(status) {
			for (const todo of this.todos.filter(todo => todo.selected)) {
				todo.status = status;
			}
			this.postTodos();
		},
		async postTodos() {
			const selected = this.todos.filter(todo => todo.selected);
			if (selected.length < 1) return;

			const res = await fetch("api/todos.php", {
				method: "POST",
				body: JSON.stringify({ todos: selected }),
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

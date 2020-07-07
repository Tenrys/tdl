import ToDo from "./components/ToDo.vue";
import ToDoModal from "./components/ToDoModal.vue";

new Vue({
	components: { ToDo, ToDoModal },
	el: "#app",
	data() {
		return { todos: null, dirtyTodo: null, user: null };
	},
	computed: {
		isAdmin() {
			return this.user && this.user.rank == "ADMIN";
		},
	},
	async mounted() {
		const todos = await fetch("api/todos.php");
		const auth = await fetch("api/auth.php");

		this.todos = await todos.json();
		this.user = await auth.json();
	},
	methods: {
		showModal(todo) {
			this.dirtyTodo = todo;
		},
	},
});

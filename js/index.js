const app = new Vue({
	el: "#app",
	data() {
		return { todos: null };
	},
	async mounted() {
		const todos = await fetch("api/todos.php");

		this.todos = await todos.json();
	},
});

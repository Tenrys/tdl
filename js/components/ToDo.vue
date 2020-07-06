<template id="todo-template">
	<tr class="todo" :class="{ 'is-striked': completed, 'has-text-danger': canceled }">
		<slot></slot>
		<th>{{ id }}</th>
		<td class="description">{{ description }}</td>
		<td v-if="assigned">
			{{ assigned.username }}
		</td>
		<td v-else>
			<pre>n/a</pre>
		</td>
		<td>{{ niceStatus }}</td>
		<td>{{ new Date(createdAt.date).toLocaleString("fr-FR") }}</td>
		<td></td>
	</tr>
</template>
<style>
.todo.is-striked .description {
	text-decoration: line-through;
}
</style>
<script>
const statusMap = {
	WAITING: "En attente",
	IN_PROGRESS: "En cours",
	COMPLETED: "Terminée",
	CANCELED: "Annulée",
};

Vue.component("todo", {
	props: ["id", "description", "status", "assigned", "startedAt", "createdAt", "completedAt"],
	computed: {
		completed() {
			return this.status == "COMPLETED" || this.status == "CANCELED";
		},
		canceled() {
			return this.status == "CANCELED";
		},
		niceStatus() {
			return statusMap[this.status];
		},
	},
	mounted() {
		console.log(this.createdAt);
	},
	template: "#todo-template",
});
</script>

<template>
	<tr
		class="todo has-aligned-rows"
		:class="{ 'is-completed': completed, 'has-text-danger': canceled }"
	>
		<slot></slot>
		<th>{{ id }}</th>
		<td class="description">{{ description }}</td>
		<td>
			<template v-if="assigned">
				{{ assigned.username }}
			</template>
		</td>
		<td>{{ niceStatus }}</td>
		<td>{{ formatDate(createdAt) }}</td>
		<td>{{ formatDate(startedAt) }}</td>
		<td>{{ formatDate(completedAt) }}</td>
		<td v-if="$root.isAdmin">
			<div class="buttons">
				<button class="button is-warning" @click="$emit('edit')">Modifier</button>
			</div>
		</td>
	</tr>
</template>

<script>
const statusMap = {
	WAITING: "En attente",
	IN_PROGRESS: "En cours",
	COMPLETED: "Terminée",
	CANCELED: "Annulée",
};

export default {
	props: ["id", "description", "status", "assigned", "createdAt", "startedAt", "completedAt"],
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
	methods: {
		formatDate(date) {
			if (date && date.date) {
				return new Date(date.date).toLocaleString("fr-FR");
			} else {
				return "";
			}
		},
	},
};
</script>

<style>
.todo.is-completed {
	opacity: 0.75;
}
</style>

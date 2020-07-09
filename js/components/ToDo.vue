<template>
	<tr class="todo has-aligned-rows" :class="{ 'is-completed': completed }">
		<slot></slot>
		<th>{{ id }}</th>
		<td class="description">{{ description }}</td>
		<td>
			<template v-if="assigned">
				{{ assigned.username }}
			</template>
		</td>
		<td :class="statusStyle">{{ statusDisplay }}</td>
		<td>{{ formatDate(createdAt) }}</td>
		<td>{{ formatDate(startedAt) }}</td>
		<td>{{ formatDate(completedAt) }}</td>
		<td v-if="$root.isAdmin">
			<a @click="$emit('edit')">Gérer...</a>
		</td>
	</tr>
</template>

<script>
const statusDisplayMap = {
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
		statusDisplay() {
			return statusDisplayMap[this.status];
		},
		statusStyle() {
			switch (this.status) {
				case "WAITING":
					return [];
				case "IN_PROGRESS":
					return ["has-text-info-dark"];
				case "COMPLETED":
					return ["has-text-success-dark"];
				case "CANCELED":
					return ["has-text-warning-dark"];
			}
		},
	},
	methods: {
		formatDate(date) {
			if (date && date.date) {
				return new Date(date.date).toLocaleString("fr-FR", {
					day: "2-digit",
					month: "2-digit",
					year: "numeric",
					hour: "2-digit",
					minute: "2-digit",
				});
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

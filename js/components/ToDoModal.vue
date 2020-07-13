<template>
	<div class="modal has-overflow is-active">
		<div class="modal-background" @click="$emit('cancel')"></div>
		<div class="modal-content">
			<div class="box">
				<form method="POST" @submit.prevent="$emit('submit')">
					<div class="field">
						<label class="label">Tâche</label>
						<div class="control">
							<textarea
								class="textarea"
								name="description"
								v-model="todo.description"
							></textarea>
						</div>
					</div>
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label">Assignée à</label>
						</div>
						<div class="field-body">
							<div class="field">
								<div class="control">
									<div
										class="dropdown"
										:class="{ 'is-active': dropdowns.assignTo.active }"
										@click="toggleDropdown('assignTo')"
									>
										<div class="dropdown-trigger">
											<button type="button" class="button">
												<span>
													{{
														todo.assigned
															? todo.assigned.username
															: "..."
													}}
												</span>
												<span class="icon is-small">
													<i class="fas fa-angle-down"></i>
												</span>
											</button>
										</div>
										<div class="dropdown-menu">
											<div
												is="UserList"
												class="dropdown-content"
												item-class="dropdown-item"
												@picked="assignTo"
												:users="users"
											>
												<hr class="dropdown-divider" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label" style="display: inline-block;">Statut</label>
						</div>
						<div class="field-body">
							<div class="field">
								<div class="control">
									<div
										class="dropdown"
										:class="{ 'is-active': dropdowns.changeStatus.active }"
										@click="toggleDropdown('changeStatus')"
									>
										<div class="dropdown-trigger">
											<button type="button" class="button">
												<span :class="statusStyle">{{
													statusDisplay
												}}</span>
												<span class="icon is-small">
													<i class="fas fa-angle-down"></i>
												</span>
											</button>
										</div>
										<div class="dropdown-menu">
											<div class="dropdown-content">
												<a
													class="dropdown-item"
													:key="status.id"
													v-for="status in statuses"
													:class="status.class"
													@click="changeStatus(status.id)"
													>{{ status.display }}</a
												>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="buttons is-right">
						<button type="submit" class="button is-success">Sauvegarder</button>
						<button
							v-if="todo.id"
							type="button"
							class="button is-danger"
							@click="$emit('delete')"
						>
							Supprimer
						</button>
						<button type="button" class="button" @click="$emit('cancel')">
							Annuler
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import UserList from "./UserList.vue";

	const statusDisplayMap = {
		WAITING: "En attente",
		IN_PROGRESS: "En cours",
		COMPLETED: "Terminée",
		CANCELED: "Annulée",
	};

	export default {
		components: {
			UserList,
		},
		props: {
			todo: {
				type: Object,
				default: {},
			},
			users: {
				type: Array,
				default: [],
			},
		},
		data() {
			return {
				dropdowns: {
					assignTo: { active: false },
					changeStatus: { active: false },
				},
				statuses: [
					{ id: "WAITING", class: "", display: "En attente" },
					{ id: "IN_PROGRESS", class: "has-text-info-dark", display: "En cours" },
					{ id: "COMPLETED", class: "has-text-success-dark", display: "Terminée" },
					{ id: "CANCELED", class: "has-text-warning-dark", display: "Annulée" },
				],
			};
		},
		computed: {
			statusDisplay() {
				return statusDisplayMap[this.todo.status];
			},
			statusStyle() {
				switch (this.todo.status) {
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
			toggleDropdown(name) {
				for (const [_name, dropdown] of Object.entries(this.dropdowns)) {
					if (_name != name) dropdown.active = false;
				}
				this.dropdowns[name].active = !this.dropdowns[name].active;
			},
			assignTo(user) {
				this.todo.assigned = user;
			},
			changeStatus(status) {
				this.todo.status = status;
			},
		},
	};
</script>

<style>
	.modal.has-overflow {
		position: fixed !important;
		overflow: auto !important;
	}
	.modal.has-overflow .modal-background {
		position: fixed !important;
	}
	.modal.has-overflow .modal-content,
	.modal.has-overflow .modal-card,
	.modal.has-overflow .modal-card-body {
		overflow: visible !important;
	}
</style>

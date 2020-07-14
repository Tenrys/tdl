import Table from "../components/Table.vue";
import UserRow from "../components/UserRow.vue";

export default new Vue({
	components: { Table },
	data() {
		return {
			UserRow,
			user: {},
			users: [],
			dropdowns: {
				assignTo: { active: false },
				changeRank: { active: false },
			},
			rows: [
				{ name: "id", display: "ID" },
				{ name: "username", display: "Nom d'utilisateur" },
				{ name: "rank", display: "Rang" },
				{ name: "", display: "", show: () => this.isAdmin },
			],
			ranks: ["USER", "ADMIN"],
		};
	},
	computed: {
		isAdmin() {
			return this.user && this.user.rank == "ADMIN";
		},
		selected() {
			return this.users.filter(user => user.selected);
		},
	},
	async mounted() {
		this.user = await (await fetch("api/auth.php")).json();
		this.users = await (await fetch("api/users.php")).json();
	},
	methods: {
		toggleDropdown(name) {
			for (const [_name, dropdown] of Object.entries(this.dropdowns)) {
				if (_name != name) dropdown.active = false;
			}
			this.dropdowns[name].active = !this.dropdowns[name].active;
		},
		changeRank(rank, id) {
			const selected = id ? this.users.filter(user => user.id == id) : this.selected;
			if (selected.length < 1) return;
			for (const user of selected) {
				user.rank = rank;
			}
			this.postUsers(selected);
		},
		async deleteUsers(id) {
			const selected = id ? this.users.filter(user => user.id == id) : this.selected;
			if (selected.length < 1) return;
			let plural = "ces utilisateurs";
			if (selected.length < 2) plural = "cet utilisateur";

			if (confirm(`Êtes-vous sûr de vouloir supprimer ${plural} ?`)) {
				await fetch("api/users.php", {
					method: "DELETE",
					body: JSON.stringify({ users: selected }),
				});

				let deleted = 0;
				for (const [k, user] of Object.entries(this.users)) {
					if (selected.find(_user => user.id == _user.id)) {
						this.users.splice(k - deleted, 1);
						deleted++;
					}
				}
			}
		},
		async postUsers(selected) {
			selected = selected || this.selected;
			if (selected.length < 1) return;

			const res = await fetch("api/users.php", {
				method: "POST",
				body: JSON.stringify({ users: selected }),
			});

			const data = await res.json().catch(console.error);
			if (Array.isArray(data)) {
				// Update existing users
				for (const [k, user] of Object.entries(this.users)) {
					const _user = data.find(_user => _user.id == user.id);
					if (_user) {
						this.$set(this.users, k, {
							...this.users[k],
							..._user,
						});
					}
				}
			}
		},
	},
});

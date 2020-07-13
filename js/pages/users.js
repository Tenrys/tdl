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
			],
			ranks: ["USER", "ADMIN"],
		};
	},
	computed: {
		isAdmin() {
			return this.user && this.user.rank == "ADMIN";
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
		changeRank(a) {
			console.log(a);
		},
	},
});

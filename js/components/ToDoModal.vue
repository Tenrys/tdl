<template>
	<div class="modal">
		<div class="modal-background"></div>
		<div class="modal-content">
			<div class="box">
				<div class="buttons is-right">
					<button class="button is-success">Sauvegarder</button>
					<button class="button">Annuler</button>
				</div>
			</div>
		</div>
		<button class="modal-close is-large"></button>
	</div>
</template>

<script>
export default {
	props: ["todo"],
	watch: {
		todo() {
			console.log(this.todo);
		},
	},
};
</script>

<style></style>

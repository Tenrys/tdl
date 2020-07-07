<template>
	<div class="modal">
		<div class="modal-background"></div>
		<div class="modal-card">
			<section class="modal-card-body"></section>
			<footer class="modal-card-foot">
				<div class="buttons">
					<button class="button is-success">Sauvegarder</button>
					<button class="button">Annuler</button>
				</div>
			</footer>
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

<template>
	<div class="modal">
		<div class="modal-background"></div>
		<div class="modal-content">
			<div class="box">
				<form method="POST" @submit="$emit('submit')">
					<div class="field">
						<label class="label">Tâche</label>
						<div class="control">
							<textarea class="textarea" name="description"></textarea>
						</div>
					</div>
					<div class="buttons is-right">
						<button type="submit" class="button is-success">Sauvegarder</button>
						<button class="button" @click="$emit('cancel')">Annuler</button>
					</div>
				</form>
			</div>
		</div>
		<button class="modal-close is-large"></button>
	</div>
</template>

<script>
	export default {
		props: ["todo"],
	};
</script>

<style></style>

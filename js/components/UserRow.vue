<template>
	<tr class="user has-aligned-rows">
		<td v-if="isAdmin">
			<input type="checkbox" :checked="selected" @input="$emit('select')" />
		</td>
		<td>{{ id }}</td>
		<td>{{ username }}</td>
		<td>{{ rank }}</td>
	</tr>
</template>

<script>
	export default {
		props: ["id", "username", "rank", "isAdmin"],
	};
</script>

<style></style>

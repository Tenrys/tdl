<template>
	<tr class="user has-aligned-rows">
		<td v-if="isAdmin">
			<input type="checkbox" :checked="selected" @input="$emit('select')" />
		</td>
		<td>{{ id }}</td>
		<td>{{ username }}</td>
		<td v-if="isAdmin">
			<div class="field">
				<div class="control">
					<div class="select">
						<select
							:value="rank"
							@change="$emit('change-rank', $event.target.value, id)"
						>
							<option v-for="rank in ranks" :key="rank" :value="rank">
								{{ rank }}
							</option>
						</select>
					</div>
				</div>
			</div>
		</td>
		<td v-else>{{ rank }}</td>
		<td v-if="isAdmin">
			<a class="has-text-danger" @click="$emit('delete', id)">Supprimer...</a>
		</td>
	</tr>
</template>

<script>
	export default {
		props: ["id", "username", "rank", "isAdmin", "selected"],
		data() {
			return {
				active: false,
				ranks: ["USER", "ADMIN"],
			};
		},
	};
</script>

<style></style>

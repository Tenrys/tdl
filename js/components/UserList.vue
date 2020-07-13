<template>
	<div class="userlist">
		<a class="has-text-danger" :class="itemClass" @click="$emit('picked', null)">Désassigner</a>
		<slot></slot>
		<a :class="itemClass" v-for="user in users" :key="user.id" @click="$emit('picked', user)">{{
			user.username
		}}</a>
	</div>
</template>

<script>
	export default {
		props: ["itemClass", "users"],
	};
</script>

<style>
	.userlist {
		max-height: 512px;
		overflow: auto;
	}
</style>

<template>
	<div v-if="showNotification" class="notification is-default">
	  <button class="delete" @click.prevent="showNotification = false"></button>
	  {{ message }}
	</div>
</template>

<script>
	export default {
		props: ['message'],

		data() {
			return {
				showNotification: false
			}
		}
	}
</script>

<style scoped>
	.notification {
		position: absolute;
		top: 14px;
		right: 14px;
		z-index: 9999;
	}
</style>
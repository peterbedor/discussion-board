<template>
	<div>
		<sidebar></sidebar>
		<router-view></router-view>
	</div>
</template>

<script>
	let sidebar = require('./sidebar.vue'),
		spinner = require('./utilities/spinner.vue');

	export default {
		components: {
			sidebar,
			spinner
		},
		created() {
			this.eventBus.$on('loaded', function() {
				this.loading = false;
			}.bind(this));

			this.eventBus.$on('loading', function() {
				this.loading = true;
			}.bind(this));
		},
		data() {
			return {
				loading: true
			}
		},
		name: 'app',
		computed: {
			eventBus() {
				return window.bus;
			}
		}
	}
</script>
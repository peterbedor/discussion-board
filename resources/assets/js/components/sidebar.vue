<template>
	<div class="col-xs-6 col-sm-3">
		<router-link to="/discussion/create" class="btn btn-success new-discussion">
			New Discussion
		</router-link>
		<ul class="list-group">
			<li class="list-group-item" v-for="channel in channels">
				<div class="badge pull-right" :style="{ backgroundColor: channel.color }">{{ channel.discussions_count }}</div>
				<router-link :to="/channel/ + channel.slug">{{ channel.title }}</router-link>
			</li>
		</ul>
	</div>
</template>

<script>
	export default {
		name: 'sidebar',
		data() {
			return {
				user: {},
				channels: {}
			}
		},
		created() {
			this.eventBus.$on('discussionCreated', function() {
				this.getChannels();
			}.bind(this));
		},
		mounted() {
			this.getChannels();
		},
		methods: {
			getChannels() {
				this.$http.get('channel').then(function(response) {
					Vue.set(this, 'channels', response.body);
				});
			}
		},
		computed: {
			eventBus() {
				return window.bus;
			}
		}
	}
</script>

<style scoped>
	.fade-enter-active, .fade-leave-active {
		transition: opacity .5s
	}
	.fade-enter, .fade-leave-active {
		opacity: 0
	}
	.new-discussion {
		width: 100%;
		margin-bottom: 15px;
	}
	.router-link-active {
		font-weight: bold;
	}
</style>
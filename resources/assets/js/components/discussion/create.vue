<template>
	<div class="col-xs-12 col-sm-9">
		<div class="panel panel-default">
			<div class="panel-body">
				<form class="js-discussion-form" @submit.prevent="submitDiscussion">
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" id="title" name="title" class="form-control">
					</div>

					<div class="form-group">
						<label for="channel">Channel</label>
						<select id="channel" name="channel" class="form-control">
							<option v-for="channel in channels" :value="channel.id" :selected="channel.slug == fromChannel">{{ channel.title }}</option>
						</select>
					</div>

					<div class="form-group">
						<label for="body">Body</label>
						<textarea class="form-control" id="body" name="body"></textarea>
					</div>

					<button class="btn btn-primary" type="submit">Submit</button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'discussionCreate',
		data() {
			return {
				channels: {},
				fromChannel: ''
			}
		},
		mounted() {
			this.getChannels();
			this.getUsers();
		},
		beforeRouteEnter(to, from, next) {
			next(function(vm) {
				vm.fromChannel = from.params.slug
			});
		},
		methods: {
			submitDiscussion() {
				this.$http.post('discussion/create', $('.js-discussion-form').serializeFormJSON())
					.then(function(response) {
						this.$router.push(`/channel/${response.body.channel.slug}/${response.body.slug}`);

						this.eventBus.$emit('discussionCreated');
					});
			},
			getChannels() {
				this.$http.get('channel').then(function(response) {
					Vue.set(this, 'channels', response.body);
				});
			},
			getUsers() {
				this.$http.get('mention').then(function(response) {
					this.setTribute(response.body);
				});
			},
			setTribute(users) {
				let vm = this,
					tribute = new Tribute({
					values: users
				});

				tribute.attach(document.getElementById('body'));
			}
		},
		computed: {
			eventBus() {
				return window.bus;
			}
		}
	}
</script>

<style lang="scss">
	.tribute-container {
		ul {
			list-style: none;
			padding-left: 0;
			margin-bottom: 20px;
			margin-top: 10px;
			li {
				position: relative;
				display: block;
				padding: 10px 15px;
				margin-bottom: -1px;
				background-color: #fff;
				border: 1px solid #ddd;
				span {
					font-weight: bold;
				}
				&.highlight {
					background-color: #f5f5f5;
				}
				&:first-child {
					border-top-left-radius: 4px;
					border-top-right-radius: 4px;
				}
				&:last-child {
					margin-bottom: 0;
					border-bottom-right-radius: 4px;
					border-bottom-left-radius: 4px;
				}
			}
		}
	}
</style>
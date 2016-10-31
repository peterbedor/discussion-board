<template>
	<div class="col-xs-12 col-sm-9">
		<div class="list-group" v-if="discussions.length">
			<div class="list-group-item clearfix" v-for="discussion in discussions">
				<div class="post-info pull-left">
					<router-link style="display: block" :to="/channel/ + discussion.channel.slug + '/' + discussion.slug">{{ discussion.title }}</router-link>
					<div class="label label-default" :style="{ backgroundColor: discussion.channel.color }">{{ discussion.channel.title }}</div>
					<div class="small text-muted" v-if="discussion.latest_reply">
						Latest Reply By:
						<router-link :to="'/user/' + '@' + discussion.latest_reply.author.username">
							@{{ discussion.latest_reply.author.username }}
						</router-link>
						<span>-</span>
						<router-link :to="/channel/ + discussion.channel.slug + '/' + discussion.slug + '#' + discussion.latest_reply.id">
							Go!
						</router-link>
					</div>
				</div>
				<div class="pull-right">
					<img :src="discussion.author.avatar" class="img-circle avatar center-block" v-if="discussion.author.avatar">
					<div class="placeholder-avatar circle" v-else>
						<div class="placeholder-avatar__letter">{{ discussion.author.first_name|firstLetter }}</div>
					</div>
					<div class="text-center">
						<div>{{ discussion.author.username }}</div>
						<small class="text-muted">{{ discussion.human_created_at }}</small>
					</div>
				</div>
			</div>

			<div class="flex-container" v-if="page != lastPage">
				<button type="button" class="btn btn-primary m-x-auto load-more" @click="loadMore()">More</button>
			</div>
		</div>

		<div v-else>
			<h3 class="no-discussions">No Discussions! <router-link to="/discussion/create">Why not start one?</router-link></h3>
		</div>


	</div>
</template>

<script>
	export default {
		name: 'channel',
		data() {
			return {
				discussions: [],
				page: 0,
				lastPage: 0,
				totalResults: 0,
				channel: ''
			}
		},
		created() {
			this.getDiscussions();
		},
		watch: {
			$route(to, from) {
				this.channel = to.params.slug;

				this.getDiscussions();
			}
		},
		methods: {
			getDiscussions() {
				let channel = this.currentChannel;

				this.$http.get(`discussion?channel=${channel}`).then(function(response) {
					Vue.set(this, 'discussions', response.body.data);
					Vue.set(this, 'lastPage', response.body.last_page);
					Vue.set(this, 'totalResults', response.body.total);

					Vue.set(this, 'page', response.body.current_page);

					this.eventBus.$emit('loaded');
				});
			},
			loadMore() {
				let page = this.page,
					channel = this.currentChannel;

				this.$http.get(`discussion?page=${page + 1}&channel=${channel}`).then(function(response) {

					// TODO: find a better way to do this, probably not very performent
					Vue.set(this, 'discussions', this.discussions.concat(response.body.data));

					Vue.set(this, 'page', response.body.current_page);
				});
			}
		},
		computed: {
			currentChannel() {
				return this.channel || this.$route.params.slug;
			},
			eventBus() {
				return window.bus;
			}
		}
	}
</script>

<style>
	.flex-container	{
		display: flex;
	}
	.load-more {
		justify-content: space-around;
		margin-bottom: 20px;
	}
	.avatar {
		width: 55px;
		height: 55px;
	}
	.no-discussions {
		margin: 0;
	}
</style>
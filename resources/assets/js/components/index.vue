<template>
	<div class="col-xs-12 col-sm-9">
		<div class="list-group">
			<div class="list-group-item clearfix" v-for="discussion in discussions">
				<div class="post-info pull-left">
					<router-link style="display: block" :to="/channel/ + discussion.channel.slug + '/' + discussion.slug">{{ discussion.title }}</router-link>
					<div class="label label-default" :style="{ backgroundColor: discussion.channel.color }">{{ discussion.channel.title }}</div>
				</div>
				<div class="pull-right">
					<img :src="discussion.author.avatar" class="img-circle avatar center-block" v-if="discussion.author.avatar">
					<div class="placeholder-avatar circle" v-else>
						<div class="placeholder-avatar__letter">{{ discussion.author.first_name|firstLetter }}</div>
					</div>
				</div>
			</div>
		</div>

		<div class="flex-container">
			<button type="button" class="btn btn-primary m-x-auto load-more" @click="getDiscussions()">More</button>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'index',
		data() {
			return {
				user: {},
				discussions: [],
				page: 0
			}
		},
		mounted() {
			this.getDiscussions();
			this.getUser();
		},
		methods: {
			getUser() {
				this.$http.get('user').then(function(response) {
					Vue.set(this, 'user', response.body);
				});
			},
			getDiscussions() {
				let page = this.page;

				this.$http.get(`discussion?page=${(page + 1)}`).then(function(response) {

					// TODO: find a better way to do this, probably not very performant
					Vue.set(this, 'discussions', this.discussions.concat(response.body.data));

					Vue.set(this, 'page', response.body.current_page);
				});
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
</style>
<template>
	<div class="col-xs-12 col-sm-9">
		<div class="list-group">
			<div class="list-group-item clearfix">
				<div class="row">
					<div class="col-sm-2">
						<router-link :to="'/user/@' + discussion.author.username">
							<img :src="discussion.author.avatar" class="img-circle avatar center-block" v-if="discussion.author.avatar">
							<div v-else class="placeholder-avatar circle">
								<div class="placeholder-avatar__letter">{{ discussion.author.first_name|firstLetter }}</div>
							</div>
							<div class="text-center">
								{{ discussion.author.username }}
							</div>
						</router-link>
					</div>
					<div class="col-sm-10" v-html="addMention(discussion.body, discussion.mentions)"></div>
				</div>
			</div>
		</div>

		<div class="list-group">
			<div class="list-group-item clearfix" v-for="reply in discussion.replies">
				<div class="row" :id="'reply-' + reply.id">
					<div class="col-sm-2">
						<router-link :to="'/user/@' + reply.author.username">
							<img :src="reply.author.avatar" class="img-circle avatar center-block" v-if="reply.author.avatar">
							<div class="placeholder-avatar circle" v-else>
								<div class="placeholder-avatar__letter">{{ reply.author.first_name|firstLetter }}</div>
							</div>
							<div class="text-center">
								{{ reply.author.username }}
							</div>
						</router-link>
						<div class="text-center" style="margin-top: 10px;">
							<div class="btn-group btn-group-xs" role="group" style="">
								<button type="button" class="btn btn-default btn-success" @click="point('up', reply.id)"><i class="fa fa-thumbs-up"></i></button>
								<span class="btn btn-default">{{ reply.points.points }}</span>
								<button type="button" class="btn btn-default btn-danger" @click="point('down', reply.id)"><i class="fa fa-thumbs-down"></i></button>
							</div>
						</div>
					</div>
					<div class="col-sm-10" v-html="addMention(reply.body, reply.mentions)"></div>
				</div>
				<div class="pull-right">
					<h6 style="display:inline-block"><small>Posted: {{ reply.human_created_at }}</small></h6>
					<h6 style="display:inline-block" v-show="edited(reply.created_at, reply.updated_at)"><small>Edited: {{ reply.human_updated_at }}</small></h6>
				</div>
			</div>
		</div>

		<form class="js-reply-form" @submit.prevent="addReply">
			<div class="panel panel-default">
				<div class="panel-body">
					<label>Add a reply</label>
					<textarea class="form-control reply" id="reply" name="reply"></textarea>
					<input type="hidden" name="channel_id" :value="discussion.channel_id">
					<input type="hidden" name="discussion_id" :value="discussion.id">
					<button class="btn btn-primary pull-right" type="submit">Submit</button>
				</div>
			</div>
		</form>

		<div class="flex-container">
			<button type="button" class="btn btn-primary m-x-auto load-more" @click="getDiscussions()">More</button>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'discussion',
		data() {
			return {
				discussion: {
					author: {},
					replies: []
				},
				latestReply: ''
			}
		},
		mounted() {
			this.getDiscussion();
			this.getUsers();

			this.scrollToReply();
		},
		methods: {
			edited(created, updated) {
				return Date.parse(updated) > Date.parse(created);
			},
			addMention(value, mentions) {
				if (mentions) {
					let mentionsLength = mentions.length;

					if (mentionsLength) {
						let i = 0,
							userNames = '';

						for (; i < mentionsLength; i++) {
							userNames += `@${mentions[i].user.username}`;

							if (mentionsLength !== (i + 1)) {
								userNames += '|';
							}
						}

						let pattern = new RegExp('(' + userNames + ')', 'gi');

						return value.replace(pattern, '<a href="/#/user/$1">$1</a>');
					}

					return value;
				}
			},
			getDiscussion() {
				this.$http.get(this.path).then(function(response) {
					Vue.set(this, 'discussion', response.body);
				});
			},
			pointUp(id) {
				this.$http.get(`points/${id}/add`);

				console.log(this);
			},
			pointDown(id) {
				this.$http.get(`points/${id}/remove`);
			},
			addReply() {
				let params = this.$route.params;

				this.$http.post(`channel/${params.channelSlug}/${params.discussionSlug}`, $('.js-reply-form').serializeFormJSON())
					.then(function(response) {
						this.discussion.replies.push(response.body);

						this.clearReply();
					});
			},
			clearReply() {
				$('.reply').val('');
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

				tribute.attach(document.getElementById('reply'));
			},
			scrollToReply() {
				let hash = this.$route.hash;

				if (hash) {
					setTimeout(function() {
						let reply = `#reply-${hash.replace('#', '')}`,
							offset = $(reply).offset().top;

						window.scrollTo(0, offset);
					}, 500);
				}
			},
			point(direction, replyId) {
				this.$http.get(`points/${replyId}/${direction}`).then(function(response) {
					this.getDiscussion();
				});
			}
		},
		computed: {
			path() {
				let params = this.$route.params;

				return `channel/${params.channelSlug}/${params.discussionSlug}`;
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
		margin-bottom: 5px;
	}
	.placeholder-avatar {
		margin-bottom: 5px;
		width: 55px;
		height: 55px;
		background-color: #5cb85c;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto 5px auto;
	}
	.placeholder-avatar__letter {
		color: white;
		font-size: 30px;
	}
	.reply {
		margin-bottom: 15px;
	}
</style>
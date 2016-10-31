<template>
	<div>
		<div class="row">
			<div class="col-md-8 col-xs-10">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-sm-4 text-center">
								<img :src="user.avatar" alt="" class="center-block img-circle img-thumbnail img-responsive">
							</div>
							<!--/col-->
							<div class="col-xs-12 col-sm-8">
								<h2>{{ user.first_name }} {{ user.last_name }}</h2>
								<div class="small username secondary">{{ user.username }}</div>
								<p><strong>About: </strong> {{ user.data.about }}</p>

								<ul class="list-group">
									<li class="list-group-item"><strong>Github:</strong> {{ user.data.github }}</li>
									<li class="list-group-item"><strong>Bitbucket:</strong> {{ user.data.bitbucket }}</li>
									<li class="list-group-item"><strong>LinkedIn:</strong> {{ user.data.linked_in }}</li>
									<li class="list-group-item"><strong>Twitter:</strong> {{ user.data.twitter }}</li>
								</ul>
							</div>
						</div>


						<!--/row-->
					</div>
					<!--/panel-body-->
				</div>
				<!--/panel-->
			</div>
			<!--/col-->
		</div>
	</div>
</template>

<script>
	export default {
		name: 'user',
		data() {
			return {
				user: {
					data: {}
				}
			}
		},
		mounted() {
			this.getUser();
		},
		methods: {
			getUser() {
				this.$http.get(this.path).then(function(response) {
					Vue.set(this, 'user', response.body);
				});
			}
		},
		computed: {
			fullName() {
				return `${this.user.first_name} ${this.user.lastName}`;
			},
			path() {
				let params = this.$route.params;

				return `user/${params.userName}`;
			}
		}
	}
</script>

<style>
	.username {
		margin-bottom: 20px;
	}
</style>
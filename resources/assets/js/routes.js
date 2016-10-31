const routes = [
	{ path: '/', component: require('./components/index.vue') },

	{ path: '/channel/:slug', component: require('./components/channel.vue') },
	{ path: '/channel/:channelSlug/:discussionSlug', component: require('./components/discussion/show.vue') },

	{ path: '/user/:userName', component: require('./components/user.vue') },

	{ path: '/discussion/create', component: require('./components/discussion/create.vue') }
];

export { routes };
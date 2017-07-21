import VueRouter from 'vue-router';

let routes = [
	{
		path: '/',
		component: require('./components/Welcome'),
		children: [
			{
				path: '/documents',
				component: require('./components/Documents')
			},

			{
				path: '/documents/reception',
				component: require('./components/Reception')
			},

			{
				path: '/documents/scan',
				component: require('./components/Scan')
			},

			{
				path: '/documents/import',
				component: require('./components/Import')
			},

			{
				path: '/documents/clipping',
				component: require('./components/Clipping')
			},

			{
				path: '/documents/clipped',
				component: require('./components/Clipped')
			},

			{
				path: '/documents/export',
				component: require('./components/Export')
			}
		]
	},

	{
		path: '/admin',
		component: require('./components/Admin')
	}

	
];

export default new VueRouter({

	routes,

	linkActiveClass: 'is-active'

});
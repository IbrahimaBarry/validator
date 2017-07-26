import VueRouter from 'vue-router';

let routes = [
	{
		path: '/',
		component: require('./components/Welcome'),
		children: [
			{
				path: '/documents',
				component: require('./components/home/Documents')
			},

			{
				path: '/documents/reception',
				component: require('./components/home/Reception')
			},

			{
				path: '/documents/scan',
				component: require('./components/home/Scan')
			},

			{
				path: '/documents/import',
				component: require('./components/home/Import')
			},

			{
				path: '/documents/clipping',
				component: require('./components/home/Clipping')
			},

			{
				path: '/documents/clipped',
				component: require('./components/home/Clipped')
			},

			{
				path: '/documents/export',
				component: require('./components/home/Export')
			}
		]
	},

	{
		path: '/admin',
		component: require('./components/Admin'),
		children: [
			{
				path: '/admin/addUser',
				component: require('./components/admin/AddUser')
			},
			{
				path: '/admin/listUser',
				component: require('./components/admin/listUser')
			},
			{
				path: '/admin/teams',
				component: require('./components/admin/Teams')
			},
		]
	}

	
];

export default new VueRouter({

	routes,

	linkActiveClass: 'is-active'

});
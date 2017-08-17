import VueRouter from 'vue-router';

let routes = [
	{
		path: '/',
		component: require('./components/Welcome'),
		children: [
			{
				path: '/documents/reception',
				component: require('./components/home/Reception')
			},

			{
				path: '/documents/scan',
				component: require('./components/home/Scan')
			},
			{
				path: '/documents/ocr',
				component: require('./components/home/Ocr')
			},

			{
				path: '/documents/import',
				component: require('./components/home/Import')
			},

			{
				path: '/documents/affect',
				component: require('./components/home/Affect')
			},

			{
				path: '/documents/clipping',
				component: require('./components/home/Clipping')
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
				path: '/admin/documents',
				component: require('./components/admin/Documents')
			},
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
				component: require('./components/admin/Planning')
			},
		]
	}

	
];

export default new VueRouter({

	routes,

	linkActiveClass: 'is-active'

});
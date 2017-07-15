import VueRouter from 'vue-router';

let routes = [
	{
		path: '/',
		component: require('./components/Home')
	},

	{
		path: '/documents/reception',
		component: require('./components/Reception')
	},

	{
		path: '/documents/scan',
		component: require('./components/Scan')
	}
];

export default new VueRouter({

	routes,

	linkActiveClass: 'is-active'

});